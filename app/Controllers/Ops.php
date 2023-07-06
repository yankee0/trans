<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Camions;
use App\Models\Chauffeurs;
use App\Models\Remorques;

class Ops extends BaseController
{
    public function index()
    {
        $data = [

            //flotte
            'driversCount' => (new Chauffeurs())->countAll(),
            'trucksCount' => (new Camions())->countAll(),
            'trailersCount' => (new Remorques())->countAll(),

            //livraisons
            'livs' => (new Livraisons())->getLivs()
        ];
        return view('ops/dashboard', $data);
    }
}
