<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Ravitaillement;

class Check extends BaseController
{
    public function checkDoubleRav()
    {
        $ravs = (new Ravitaillement())->findAll();
        $double = [];

        foreach ($ravs as $rav) {
            $res = (new Ravitaillement())
                ->where('litres', $rav['litres'])
                ->where('YEAR(created_at)', date('Y', strtotime($rav['created_at'])))
                ->where('MONTH(created_at)', date('m', strtotime($rav['created_at'])))
                ->where('DAY(created_at)', date('d', strtotime($rav['created_at'])))
                ->like("TRIM(REPLACE(imm,' ',''))", trim(str_replace(' ', '', $rav['imm'])))
                ->find();
            if (count($res) > 1) {
                array_push($double, $res);
            }
        }

        dd($double);
    }
}
