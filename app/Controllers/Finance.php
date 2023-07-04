<?php

namespace App\Controllers;

use App\Models\Clients;
use App\Models\FactLiv;
use App\Controllers\BaseController;

class Finance extends BaseController
{
    public function index()
    {
        session()->p = 'dashboard';
        $model_fact_liv = new FactLiv();

        $factLiv = $model_fact_liv
            ->limit(5)
            ->orderBy('created_at', 'DESC')
            ->findAll();
        for ($i = 0; $i < sizeof($factLiv); $i++) {
            $factLiv[$i] = (new Facturations)->FactLivInfos($factLiv[$i]);
        }

        $monthlyFactLivPaid = $model_fact_liv
            ->where('MONTH(created_at)', date('m'))
            ->where('paiement', 'OUI')
            ->find();

        for ($i = 0; $i < sizeof($monthlyFactLivPaid); $i++) {
            $monthlyFactLivPaid[$i] = (new Facturations)
                ->FactLivInfos($monthlyFactLivPaid[$i]);
        }

        $sumFactLiv = 0;
        foreach ($monthlyFactLivPaid as $i) {
            $sumFactLiv += $i['total'];
        }

        $data = [
            'fact_liv_last' => $factLiv,
            'cli' => (new Clients())
                ->countAll(),
            'sumFactLiv' => $sumFactLiv,
            'factLivNotPaid' => sizeof(
                $model_fact_liv
                    ->where('annulation', 'NON')
                    ->where('paiement', 'NON')
                    ->find()
            )


        ];
        return view('finance/dashboard', $data);
    }
}
