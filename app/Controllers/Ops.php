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
                    ->select('fact_liv.date_pg')
                    ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
                    ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
                    ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
                    ->where('fact_liv.date_pg !=', null)
                    ->where('DAY(date_pg)', date('d', time()))
                    ->find()
            ),
            'livsWeekyCount' => sizeof(
                (new modeleLiv())
                    ->select('fact_liv.date_pg')
                    ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
                    ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
                    ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
                    ->where('fact_liv.date_pg !=', null)
                    ->where('WEEK(date_pg)', date('W', time()))
                    ->find()
            ),
            'livsMonthlyCount' => sizeof(
                (new modeleLiv())
                    ->select('fact_liv.date_pg')
                    ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
                    ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
                    ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
                    ->where('fact_liv.date_pg !=', null)
                    ->where('MONTH(date_pg)', date('m', time()))
                    ->find()
            ),
            'livsYearlyCount' => sizeof(
                (new modeleLiv())
                    ->select('fact_liv.date_pg')
                    ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
                    ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
                    ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
                    ->where('fact_liv.date_pg !=', null)
                    ->where('YEAR(date_pg)', date('Y', time()))
                    ->find()
            ),
        ];
        return view('ops/dashboard', $data);
    }
}
