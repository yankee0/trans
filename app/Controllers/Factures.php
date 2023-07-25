<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FactLiv;

class Factures extends BaseController
{
    public function dashboard()
    {
        session()->p = 'factures';

        $all = (new FactLiv())
            ->select('
                fact_liv.*,
                fact_liv.id as facture,
                clients.*,
                clients.id client,
                fact_liv_lignes.prix,
                SUM(fact_liv_lignes.prix) as total,
                COUNT(fact_liv_lignes.prix) as tcs
            ')
            ->groupBy('fact_liv.id, fact_liv_lignes.prix')
            ->join('clients', 'clients.id = fact_liv.id_client')
            ->join('fact_liv_lieux', 'fact_liv_lieux.id_fact = fact_liv.id')
            ->join('fact_liv_lignes', 'fact_liv_lieux.id = fact_liv_lignes.id_lieu')
            ->findAll();
        $all = $this->setFees($all);


        $unpaid = (new FactLiv())
            ->select('
                fact_liv.*,
                fact_liv.id as facture,
                clients.*,
                clients.id client,
                fact_liv_lignes.prix,
                SUM(fact_liv_lignes.prix) as total,
                COUNT(fact_liv_lignes.prix) as tcs
            ')
            ->groupBy('fact_liv.id, fact_liv_lignes.prix')
            ->join('clients', 'clients.id = fact_liv.id_client')
            ->join('fact_liv_lieux', 'fact_liv_lieux.id_fact = fact_liv.id')
            ->join('fact_liv_lignes', 'fact_liv_lieux.id = fact_liv_lignes.id_lieu')
            ->where('paiement', 'NON')
            ->where('annulation', 'NON')
            ->find();

        $unpaid = $this->setFees($unpaid);


        $paid = (new FactLiv())
            ->select('
                fact_liv.*,
                fact_liv.id as facture,
                clients.*,
                clients.id client,
                fact_liv_lignes.prix,
                SUM(fact_liv_lignes.prix) as total,
                COUNT(fact_liv_lignes.prix) as tcs
            ')
            ->groupBy('fact_liv.id, fact_liv_lignes.prix')
            ->join('clients', 'clients.id = fact_liv.id_client')
            ->join('fact_liv_lieux', 'fact_liv_lieux.id_fact = fact_liv.id')
            ->join('fact_liv_lignes', 'fact_liv_lieux.id = fact_liv_lignes.id_lieu')
            ->where('paiement', 'OUI')
            ->where('annulation', 'NON')
            ->find();
        $paid = $this->setFees($paid);

        $aborded = (new FactLiv())
            ->select('
                fact_liv.*,
                fact_liv.id as facture,
                clients.*,
                clients.id client,
            ')
            ->join('clients', 'clients.id = fact_liv.id_client')
            ->where('annulation', 'OUI')
            ->find();

        $data = [
            'all' => $all,
            'unpaid' => $unpaid,
            'paid' => $paid,
            'aborded' => $aborded,
        ];
        return view('factures/dashboard', $data);
    }

    protected function setFees(array $data)
    {
        if (!empty($data)) {
            for ($i = 0; $i < sizeof($data); $i++) {
                if ($data[$i]['avec_tva'] == 'OUI') {
                    $data[$i]['total'] += ($data[$i]['total'] * 18 / 100);
                }
                if ($data[$i]['avec_ages'] == 'OUI') {
                    $data[$i]['total'] += ($data[$i]['tcs'] * 1500);
                }
                if ($data[$i]['avec_copie'] == 'OUI') {
                    $data[$i]['total'] += 500;
                }
            }
        }

        return $data;
    }
}
