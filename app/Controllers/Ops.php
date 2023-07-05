<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Ops extends BaseController
{
    public function index()
    {
        return view('ops/dashboard');
        
    }
}
