<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Camions;
use App\Models\Chauffeurs;
use App\Models\Livraisons as ModelsLivraisons;
use Exception;

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

    public function getLivs()
    {
        $model = new ModelsLivraisons();
        $data = $model
            ->select('
                livraisons.id,
                livraisons.etat,
                fact_liv_lignes.conteneur,
                fact_liv_lignes.type,
                zones.nom AS zone,
                fact_liv_lieux.adresse,
                fact_liv_lieux.carburant,
                clients.nom AS nom_client,
                livraisons.created_at AS date_enregistrement,
                fact_liv.paiement,
                fact_liv.date_pg,
                fact_liv.preget,
                fact_liv.bl
            ')
            ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
            ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
            ->join('zones', 'zones.id = fact_liv_lieux.id_zone', 'left')
            ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
            ->join('clients', 'clients.id = fact_liv.id_client', 'left')
            ->where('fact_liv.date_pg !=', null)
            ->where('fact_liv.annulation', 'NON')
            // ->where('livraisons.annulation','NON')
            ->orderBy('fact_liv.paiement', 'DESC')
            ->paginate(10);
        $pager = $model->pager;
        return [
            'data' => $data,
            'pager' => $pager
        ];
    }

    public function abord()
    {
        $data = $this->request->getPost();
        $data['etat'] = 'ANNULÉ';
        // dd($data);
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
        // dd($data);
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
        // dd($data);
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

    public function save(){
        $data = $this->request->getPost();
        // dd($data);
        $data['etat'] = isset($data['eirs']) ? 'LIVRÉ' : 'EN COURS';
        $data['ch_aller'] = empty($data['ch_aller']) ? null : $data['ch_aller'];
        $data['ch_retour'] = empty($data['ch_retour']) ? null : $data['ch_retour'];
        $data['ch_retour'] = empty($data['ch_retour']) ? null : $data['ch_retour'];
        $data['date_retour'] = empty($data['date_retour']) ? null : $data['date_retour'];
        $data['date_aller'] = empty($data['date_aller']) ? null : $data['date_aller'];
        $data['cam_retour'] = empty($data['cam_retour']) ? null : $data['cam_retour'];
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
}
