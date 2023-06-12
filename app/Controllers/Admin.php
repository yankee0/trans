<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Admin extends BaseController
{
    public function index()
    {
        session()->p = 'dashboard';
        return view('admin/dashboard');
    }
}
