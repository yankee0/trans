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
        // dd($factLiv);
        $data = [
            'fact_liv_count' => $model_fact_liv->countAll(),
            'fact_liv_last' => $factLiv,
            'cli' => (new Clients())->countAll(),
            'liv' => (new FactLiv())
                ->countAll(),
            'liv_preget' => (new FactLiv())
                ->where('preget', 'NON')
                ->findAll(),
            'fact_liv_last' => $factLiv,
        ];
        return view('facturation/dashboard', $data);
    }
}
