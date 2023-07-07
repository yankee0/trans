<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Camions;
use App\Models\Chauffeurs;
use App\Models\Livraisons as modeleLiv;
use App\Controllers\Livraisons;
use App\Models\Remorques;

class Ops extends BaseController
{
    public function index()
    {
        session()->p = 'dashboard';
        $data = [

            //flotte
            'driversCount' => (new Chauffeurs())->countAll(),
            'trucksCount' => (new Camions())->countAll(),
            'trailersCount' => (new Remorques())->countAll(),

            //livraisons
            'livs' => (new Livraisons())->getLivs(),
            'livsDailyCount' => sizeof(
                (new modeleLiv())
                    ->where('DAY(date_retour)', date('d', time()))
                    ->find()
            ),
            'livsWeekyCount' => sizeof(
                (new modeleLiv())
                    ->where('WEEK(date_retour)', date('W', time()))
                    ->find()
            ),
            'livsMonthlyCount' => sizeof(
                (new modeleLiv())
                    ->where('MONTH(date_retour)', date('m', time()))
                    ->find()
            ),
            'livsYearlyCount' => sizeof(
                (new modeleLiv())
                    ->where('YEAR(date_retour)', date('Y', time()))
                    ->find()
            ),
        ];
        return view('ops/dashboard', $data);
    }
}
