<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FactLiv;

class Facturations extends BaseController
{
    public function index()
    {
        $data = [
            'f' => (new FactLiv())->countAll()
        ];
        return view('facturation/dashboard',$data);
    }
}
