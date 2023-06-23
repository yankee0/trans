<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Controllers\Facturations;
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
                ->where('MONTH(created_at)', $i)
                ->where('YEAR(created_at)', date('Y'))
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
}
