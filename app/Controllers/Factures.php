<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\FactLiv as ControllersFactLiv;

class Factures extends BaseController
{
    public function dashboard()
    {
        session()->p = 'factures';

        return view('facturation/livraisons/search');
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
