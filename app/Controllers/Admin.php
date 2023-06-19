<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Camions;
use App\Models\Chauffeurs;

class Admin extends BaseController
{
    public function index()
    {
        session()->p = 'dashboard';
        return view('admin/dashboard',[
            'chauffeur' => (new Chauffeurs())->countAll(),
            'camion' => (new Camions())->countAll(),
        ]);
    }
}
