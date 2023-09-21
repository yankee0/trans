<?php

namespace App\Controllers;

use Exception;
use App\Models\Camions;
use App\Models\FactLiv;
use App\Models\Chauffeurs;
use App\Models\FactLivLieux;
use App\Models\FactLivLignes;
use App\Controllers\BaseController;
use App\Models\Livraisons as ModelsLivraisons;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Controllers\FactLiv as ControllersFactLiv;

class Livraisons extends BaseController
{
    public function index()
    {
        session()->p = 'livraisons';
        $data = [
            //livraisons
            'livs' => (new Livraisons())->getLivs(),
            'livsDailyCount' => sizeof(
                (new ModelsLivraisons())
                    ->select('fact_liv.date_pg')
                    ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
                    ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
                    ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
                    ->where('fact_liv.date_pg !=', null)
                    ->where('DAY(date_pg)', date('d', time()))
                    ->find()
            ),
            'livsWeekyCount' => sizeof(
                (new ModelsLivraisons())
                    ->select('fact_liv.date_pg')
                    ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
                    ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
                    ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
                    ->where('fact_liv.date_pg !=', null)
                    ->where('WEEK(date_pg)', date('W', time()))
                    ->find()
            ),
            'livsMonthlyCount' => sizeof(
                (new ModelsLivraisons())
                    ->select('fact_liv.date_pg')
                    ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
                    ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
                    ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
                    ->where('fact_liv.date_pg !=', null)
                    ->where('MONTH(date_pg)', date('m', time()))
                    ->find()
            ),
            'livsYearlyCount' => sizeof(
                (new ModelsLivraisons())
                    ->select('fact_liv.date_pg')
                    ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
                    ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
                    ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
                    ->where('fact_liv.date_pg !=', null)
                    ->where('YEAR(date_pg)', date('Y', time()))
                    ->find()
            ),

            'drivers' => (new Chauffeurs())
                ->orderBy('nom')
                ->findAll(),

            'trucks' => (new Camions())
                ->orderBy('im')
                ->findAll()
        ];
        return view('ops/livraisons/dashboard.php', $data);
    }

    public function getLivs($tc = '%', $limit = 15, $pg = false, $search = null)
    {
        $model = new ModelsLivraisons();
        $model
            ->select('
                livraisons.id,
                livraisons.etat,
                fact_liv_lignes.conteneur,
                fact_liv_lignes.type,
                zones.nom AS zone,
                fact_liv_lieux.adresse,
                fact_liv_lieux.carburant,
                clients.nom AS nom_client,
                clients.tel AS tel_client,
                clients.email AS email_client,
                livraisons.created_at AS date_enregistrement,
                fact_liv.paiement,
                fact_liv.date_pg,
                fact_liv.pregate,
                fact_liv.bl,
                fact_liv.id as facture,
                fact_liv.compagnie,
                chauffeurs.nom AS ch_aller,
                chauffeur2.nom AS ch_retour,
                camions.im AS cam_aller,
                camion2.im AS cam_retour,
                chauffeurs.id AS ch_aller_id,
                chauffeur2.id AS ch_retour_id,
                camions.id AS cam_aller_id,
                camion2.id AS cam_retour_id,
                livraisons.commentaire,
                livraisons.date_aller,
                livraisons.date_retour,
                livraisons.motif,
                livraisons.id as liv,
            ')
            ->join('chauffeurs', 'chauffeurs.id = livraisons.ch_aller', 'left')
            ->join('chauffeurs AS chauffeur2', 'chauffeur2.id = livraisons.ch_retour', 'left')
            ->join('camions', 'camions.id = livraisons.cam_aller', 'left')
            ->join('camions AS camion2', 'camion2.id = livraisons.cam_retour', 'left')
            ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
            ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
            ->join('zones', 'zones.id = fact_liv_lieux.id_zone', 'left')
            ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
            ->join('clients', 'clients.id = fact_liv.id_client', 'left')
            ->where('fact_liv.annulation', 'NON')
            ->like('fact_liv_lignes.conteneur', $tc)
            ->orLike('fact_liv.bl', $tc)
            ->orderBy('fact_liv.date_pg', 'DESC');
        if (!$pg) {
            $model->where('fact_liv.pregate', 'OUI');
        }

        if (!empty($search)) {
            if (is_array($search)) {
                $model->where('fact_liv.date_pg', $search['from']);
            } else {
                $model->like('fact_liv.bl', $search);
                $model->orLike('clients.nom', $search);
                $model->orLike('fact_liv.compagnie', $search);
                $model->orLike('chauffeurs.nom', $search);
                $model->orLike('chauffeur2.nom', $search);
                $model->orLike('zones.nom', $search);
                $model->orLike('camions.im', $search);
                $model->orLike('camion2.im', $search);
                $model->orLike('fact_liv.paiement', $search);
            }
        }

        $data = $model->paginate($limit);
        $pager = $model->pager;

        return [
            'data' => $data,
            'pager' => $pager
        ];
    }

    public function getAllLivs($y = null, $m = null, $d = null, $w = null)
    {
        $model = new ModelsLivraisons();

        $builder = $model
            ->select('
                livraisons.id,
                livraisons.etat,
                fact_liv_lignes.conteneur,
                fact_liv_lignes.type,
                zones.nom AS zone,
                fact_liv_lieux.adresse,
                fact_liv_lieux.carburant,
                clients.nom AS nom_client,
                clients.tel AS tel_client,
                clients.email AS email_client,
                livraisons.created_at AS date_enregistrement,
                fact_liv.paiement,
                fact_liv.date_pg,
                fact_liv.pregate,
                fact_liv.bl,
                fact_liv.id as facture,
                fact_liv.date_creation,
                fact_liv.date_paiement,
                fact_liv.compagnie,
                chauffeurs.nom AS ch_aller,
                chauffeur2.nom AS ch_retour,
                camions.im AS cam_aller,
                camion2.im AS cam_retour,
                chauffeurs.id AS ch_aller_id,
                chauffeur2.id AS ch_retour_id,
                camions.id AS cam_aller_id,
                camion2.id AS cam_retour_id,
                livraisons.commentaire,
                livraisons.date_aller,
                livraisons.date_retour,
                livraisons.motif,
            ')
            ->join('chauffeurs', 'chauffeurs.id = livraisons.ch_aller', 'left')
            ->join('chauffeurs AS chauffeur2', 'chauffeur2.id = livraisons.ch_retour', 'left')
            ->join('camions', 'camions.id = livraisons.cam_aller', 'left')
            ->join('camions AS camion2', 'camion2.id = livraisons.cam_retour', 'left')
            ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
            ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
            ->join('zones', 'zones.id = fact_liv_lieux.id_zone', 'left')
            ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
            ->join('clients', 'clients.id = fact_liv.id_client', 'left')
            ->orderBy('livraisons.date_retour', 'DESC')
            ->where('fact_liv.annulation', 'NON')
            ->where('fact_liv.pregate', 'OUI');

        if (!empty($y)) {
            $builder->where('YEAR(livraisons.date_retour)', $y);
        }
        if (!empty($m)) {
            $builder->where('MONTH(livraisons.date_retour)', $m);
        }
        if (!empty($d)) {
            $builder->where('DAY(livraisons.date_retour)', $d);
        }
        if (!empty($w)) {
            $builder->where('WEEK(livraisons.date_retour)', $w);
        }

        return $builder->find();
    }

    public function abord()
    {
        $data = $this->request->getPost();
        $data['etat'] = 'ANNULÉ';

        try {
            (new ModelsLivraisons())->save($data);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('n', false)
                ->with('m', 'Une erreur est survenue lors de l\'annulation.');
            // return $e->getMessage();
        }
        return redirect()
            ->back()
            ->with('n', true)
            ->with('m', 'Livraison annulée.');
    }

    public function drop($id)
    {

        $data = [
            'id' => $id,
            'etat' => 'MISE À TERRE'
        ];

        try {
            (new ModelsLivraisons())->save($data);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('n', false)
                ->with('m', 'Une erreur est survenue lors de la modification.');
            // return $e->getMessage();
        }
        return redirect()
            ->back()
            ->with('n', true)
            ->with('m', 'Mise à terre enregistrée.');
    }

    public function up($id)
    {

        $data = [
            'id' => $id,
            'etat' => 'SUR PLATEAU'
        ];

        try {
            (new ModelsLivraisons())->save($data);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('n', false)
                ->with('m', 'Une erreur est survenue lors de la modification.');
            // return $e->getMessage();
        }
        return redirect()
            ->back()
            ->with('n', true)
            ->with('m', 'Mise sur plateau enregistrée.');
    }

    public function save()
    {
        $data = $this->request->getPost();

        $data['etat'] = isset($data['eirs']) ? 'LIVRÉ' : 'EN COURS';
        $data['ch_aller'] = empty($data['ch_aller']) ? null : $data['ch_aller'];
        $data['ch_retour'] = empty($data['ch_retour']) ? null : $data['ch_retour'];
        $data['cam_aller'] = empty($data['cam_aller']) ? null : $data['cam_aller'];
        $data['cam_retour'] = empty($data['cam_retour']) ? null : $data['cam_retour'];
        $data['date_retour'] = empty($data['date_retour']) ? null : $data['date_retour'];
        $data['date_aller'] = empty($data['date_aller']) ? null : $data['date_aller'];
        $data['commentaire'] = empty($data['commentaire']) ? null : $data['commentaire'];
        try {
            (new ModelsLivraisons())->save($data);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('n', false)
                ->with('m', 'Une erreur est survenue lors de la modification.');
            // return $e->getMessage();
        }
        return redirect()
            ->back()
            ->with('n', true)
            ->with('m', 'Informations de livraisons enregistrées.');
    }

    public function pregate()
    {
        session()->p = 'pregate';
        return view('ops/livraisons/pregate', [
            'daily_pg' => $this->getLastpregate(date('Y-m-d')),

            'drivers' => (new Chauffeurs())
                ->orderBy('nom')
                ->findAll(),

            'trucks' => (new Camions())
                ->orderBy('im')
                ->findAll()
        ]);
    }

    public function getLastpregate($from = null, $to = null)
    {
        if (!empty($to)) {
            $res = (new FactLiv())
                ->select('fact_liv.*, fact_liv.id as facture, clients.nom AS nom')
                ->join('clients', 'clients.id = fact_liv.id_client', 'left')
                ->orderBy('fact_liv.deadline', 'DESC')
                ->find();
            $occ = [];
            for ($i = 0; $i < sizeof($res); $i++) {
                if (
                    strtotime($res[$i]['date_pg']) >= strtotime($from) and
                    strtotime($res[$i]['date_pg']) <= strtotime($to)
                ) {
                    array_push($occ, $res[$i]);
                }
            }
            $res = $occ;
        } else {
            $res = (new FactLiv())
                ->select('fact_liv.*, fact_liv.id as facture, clients.nom AS nom')
                ->join('clients', 'clients.id = fact_liv.id_client', 'left')
                ->orderBy('fact_liv.deadline', 'DESC')
                ->where('fact_liv.date_pg', $from)
                ->find();
        }

        


        //Recuperation des zones
        for ($i = 0; $i < sizeof($res); $i++) {

            $res[$i]['zones'] = (new FactLivLieux())
                ->where('id_fact', $res[$i]['facture'])
                ->findAll();

            //initialisation du nombre des encours
            $res[$i]['encours'] = 0;

            //initialisation du nombre des livrés
            $res[$i]['livres'] = 0;

            //initialisation du nombre des livrés
            $res[$i]['annules'] = 0;

            //initialisation du nombre des restants
            $res[$i]['restants'] = 0;

            if (!empty($res[$i]['zones'])) {

                // recuperation des conteneurs
                for ($j = 0; $j < sizeof($res[$i]['zones']); $j++) {
                    $res[$i]['zones'][$j]['tc'] = (new FactLivLignes())
                        ->where('id_lieu', $res[$i]['zones'][$j]['id'])
                        ->findAll();

                    //recuperation des informations de livraisons
                    for ($k = 0; $k < sizeof($res[$i]['zones'][$j]['tc']); $k++) {
                        $res[$i]['zones'][$j]['tc'][$k]['infos'] = (new ModelsLivraisons())
                            ->where('id_fact_ligne', $res[$i]['zones'][$j]['tc'][$k]['id'])
                            ->first();
                    }

                    //définir l'etat du pregate
                    for ($l = 0; $l < sizeof($res[$i]['zones'][$j]['tc']); $l++) {
                        if (!empty($res[$i]['zones'][$j]['tc'][$l]['infos'])) {
                            $etat = $res[$i]['zones'][$j]['tc'][$l]['infos']['etat'];

                            if ($etat == 'EN COURS') {
                                $res[$i]['encours'] += 1;
                            } else if ($etat == 'LIVRÉ') {
                                $res[$i]['livres'] += 1;
                            }else if ($etat == 'ANNULÉ') {
                                $res[$i]['annules'] += 1;
                            } else if (
                                $etat == 'SUR PLATEAU'
                                or $etat == 'MISE À TERRE'
                            ) {
                                $res[$i]['restants'] += 1;
                            }
                        }
                    }
                }
            }
        }

        // dd([intval($res[0]['pgtimestamp']),strtotime($from)]);
        return $res;
    }

    public function checkpregate($p = null)
    {
        session()->p = 'pregate';
        $pregate = $p == null ? $this->request->getVar('pregate') : $p;
        $res = (new FactLiv())
            ->select('id')
            ->like('fact_liv.bl', $pregate)
            ->first();

        if (!empty($res)) {
            $res = (new ControllersFactLiv)->getInvoice($res['id']);
            $data = [
                'facture' => $res,
                'pregate' => $pregate,
                'daily_pg' => (new ControllersFactLiv())
                    ->factInfo(null, null, null, null, true)
            ];
        } else {
            $data = [
                'facture' => false,
                'pregate' => $pregate,
                'daily_pg' => $this->getLastpregate()
            ];
        }

        return view('ops/livraisons/pregate', $data);
    }

    public function handlePG($id)
    {
        $data = $this->request->getPost();
        if (!isset($data['pregate'])) {
            $data['id'] = $id;
            $data['pregate'] = 'NON';
            $data['date_pg'] = null;
            $data['amendement'] = 'NON';
        } else {
            $data['id'] = $id;
            $data['pregate'] = 'OUI';
            $data['date_pg'] = $data['date_pg'];
            $data['amendement'] = isset($data['amendement']) ? 'OUI' : 'NON';
        }


        try {
            (new FactLiv())->save($data);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('n', false)
                ->with('m', 'Une erreur est survenue lors de la modification.');
        }
        return $this->checkpregate($data['bl']);
    }

    public function info($bl, $tc)
    {
        session()->p = 'search';
        $res = (new ModelsLivraisons())
            ->select('
                livraisons.etat,
                fact_liv_lignes.id,
                fact_liv_lignes.conteneur,
                fact_liv_lignes.type,
                zones.nom AS zone,
                fact_liv_lieux.adresse,
                fact_liv_lieux.carburant,
                clients.nom AS nom_client,
                clients.tel AS tel_client,
                clients.email AS email_client,
                livraisons.created_at AS date_enregistrement,
                fact_liv.paiement,
                fact_liv.date_pg,
                fact_liv.pregate,
                fact_liv.deadline,
                fact_liv.bl,
                fact_liv.date_creation,
                fact_liv.id as facture,
                fact_liv.compagnie,
                chauffeurs.nom AS ch_aller,
                chauffeur2.nom AS ch_retour,
                camions.im AS cam_aller,
                camion2.im AS cam_retour,
                chauffeurs.id AS ch_aller_id,
                chauffeur2.id AS ch_retour_id,
                camions.id AS cam_aller_id,
                camion2.id AS cam_retour_id,
                livraisons.commentaire,
                livraisons.date_aller,
                livraisons.date_retour,
                livraisons.motif,
                livraisons.id as liv
            ')
            ->join('chauffeurs', 'chauffeurs.id = livraisons.ch_aller', 'left')
            ->join('chauffeurs AS chauffeur2', 'chauffeur2.id = livraisons.ch_retour', 'left')
            ->join('camions', 'camions.id = livraisons.cam_aller', 'left')
            ->join('camions AS camion2', 'camion2.id = livraisons.cam_retour', 'left')
            ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
            ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
            ->join('zones', 'zones.id = fact_liv_lieux.id_zone', 'left')
            ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
            ->join('clients', 'clients.id = fact_liv.id_client', 'left')
            ->like('fact_liv.bl', $bl)
            ->where('conteneur', $tc)
            ->first();

        if (empty($res)) {
            throw new PageNotFoundException('Informations de livraison introuvable.', 404);
        } else {
            $res['drivers'] = (new Chauffeurs())
                ->orderBy('nom')
                ->findAll();

            $res['trucks'] = (new Camions())
                ->orderBy('im')
                ->findAll();

            return view('ops/livraisons/info', $res);
        }
    }
}
