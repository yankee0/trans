<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Controllers\Facturations;
use App\Models\Livraisons;
use App\Models\FactLiv;

class Graph extends BaseController
{
    //Totaux des gains mensuel pour le graphe
    // facturation
    public function bar_fact_liv()
    {
        $data_liv = [];
        $modele = new FactLiv();
        for ($i = 1; $i <= 12; $i++) {

            $factures = $modele
                ->where('MONTH(date_creation)', $i)
                ->where('YEAR(date_creation)', date('Y', time()))
                ->where('paiement', 'OUI')
                ->find();

            for ($y = 0; $y < sizeof($factures); $y++) {
                $factures[$y] = (new Facturations())->FactLivInfos($factures[$y]);
            }
            $sum = 0;
            foreach ($factures as $f) {
                $sum += $f['total'];
            }
            array_push($data_liv, $sum);
        }

        $this->response->setJSON([
            'liv' => $data_liv,
        ])->send();
    }

    // Vue d'ensemble sur l'état des livraisons
    public function pie_fact_liv()
    {
        $data = [];
        $modele = new FactLiv();
        $data = [
            // 'no_preget_no_paiement'
            count($modele
                ->where('paiement', 'NON')
                ->where('preget', 'NON')
                ->where('annulation', 'NON')
                ->find()),
            // 'no_preget_yes_paiement' => 
            count($modele
                ->where('paiement', 'OUI')
                ->where('preget', 'NON')
                ->where('annulation', 'NON')
                ->find()),
            count($modele
                ->where('paiement', 'NON')
                ->where('preget', 'OUI')
                ->where('annulation', 'NON')
                ->find()),
            // 'Annulée' => 
            count($modele
                ->where('annulation', 'OUI')
                ->find()),
        ];

        $this->response->setJSON($data)->send();
    }

    public function pie_stat_liv()
    {
        $data = [
            sizeof((new Livraisons)
                ->select('')
                ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
                ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
                ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
                ->where('fact_liv.preget', 'OUI')
                ->where('YEAR(livraisons.created_at)', date('Y', time()))
                ->where('livraisons.etat', 'SUR PLATEAU')
                ->find()),
            sizeof((new Livraisons)
                ->select('')
                ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
                ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
                ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
                ->where('fact_liv.preget', 'OUI')
                ->where('YEAR(livraisons.created_at)', date('Y', time()))
                ->where('etat', 'MISE À TERRE')
                ->find()),
            sizeof((new Livraisons)
                ->select('')
                ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
                ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
                ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
                ->where('fact_liv.preget', 'OUI')
                ->where('YEAR(livraisons.created_at)', date('Y', time()))
                ->where('etat', 'EN COURS')
                ->find()),
            sizeof((new Livraisons)
                ->select('')
                ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
                ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
                ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
                ->where('fact_liv.preget', 'OUI')
                ->where('YEAR(livraisons.created_at)', date('Y', time()))
                ->where('etat', 'LIVRÉ')
                ->find()),
            sizeof((new Livraisons)
                ->select('')
                ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
                ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
                ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
                ->where('fact_liv.preget', 'OUI')
                ->where('YEAR(livraisons.created_at)', date('Y', time()))
                ->where('etat', 'ANNULÉ')
                ->find()),
        ];

        $this
            ->response
            ->setJSON($data)
            ->send();
    }

    public function bar_stat_liv()
    {
        $data = [];
        $modele = new Livraisons();
        for ($i = 1; $i <= 12; $i++) {
            $item = sizeof($modele
                ->select('')
                ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
                ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
                ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
                ->where('fact_liv.preget', 'OUI')
                ->where('fact_liv.annulation', 'NON')
                ->where('MONTH(livraisons.created_at)', $i)
                ->where('YEAR(livraisons.created_at)', date('Y', time()))
                ->find());
            array_push($data, $item);
        }
        $this
            ->response
            ->setJSON($data)
            ->send();
    }
}
