<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Clients;

class FactLiv extends BaseController
{
    public function list()
    {
        session()->p = 'f-livraisons';
        return view('facturation/livraisons/list', [
            'cli' => (new Clients())->findAll()
        ]);
    }

    public function add()
    {
        $data = $this->request->getPost();

        //vont dans fact_liv
        $data_liv = [
            'consignataire' => strtoupper($data['consignataire']),
            'id_client' => $data['id_client'],
            'compagnie' => strtoupper($data['compagnie']),
            'bl' => strtoupper($data['bl']),
        ];

        $c_20 = $data['c_20'];
        for ($i = 0; $i < sizeof($c_20); $i++) {
            $c_20[$i] = explode('-', $c_20[$i]);
            for ($j = 0; $j < sizeof($c_20[$i]); $j++) {
                $c_20[$i][$j] = strtoupper($c_20[$i][$j]);
            }
        }

        $c_40 = $data['c_40'];
        for ($i = 0; $i < sizeof($c_40); $i++) {
            $c_40[$i] = explode('-', $c_40[$i]);
            for ($j = 0; $j < sizeof($c_40[$i]); $j++) {
                $c_40[$i][$j] = strtoupper($c_40[$i][$j]);
            }
        }




        for ($i=0; $i < sizeof($data['zone']); $i++) { 
            # code...
        }
    }
}
