<?php

namespace App\Controllers;

use App\Models\Carte;
use App\Models\Camions;
use App\Models\Clients;
use App\Models\FactLiv;
use App\Models\Chauffeurs;
use App\Models\Livraisons;
use App\Models\Rechargement;
use App\Controllers\BaseController;
use App\Models\CompteAppro;
use App\Models\RavApproModel;

class Admin extends BaseController
{
    public function index()
    {
        session()->p = 'dashboard';

        //get the yearly total amount liv
        $yearlyFactLivPaid = (new FactLiv())
            ->where('YEAR(date_paiement)', date('Y'))
            ->where('paiement', 'OUI')
            ->find();
        // dd(date('Y'));
        for ($i = 0; $i < sizeof($yearlyFactLivPaid); $i++) {
            $yearlyFactLivPaid[$i] = (new Facturations)
                ->FactLivInfos($yearlyFactLivPaid[$i]);
        }
        $sumFactLivY = 0;
        foreach ($yearlyFactLivPaid as $i) {
            $sumFactLivY += $i['total'];
        }

        //get the monthly total amount liv
        $monthlyFactLivPaid = (new FactLiv())
            ->where('MONTH(date_paiement)', date('m'))
            ->where('YEAR(date_paiement)', date('Y'))
            ->where('paiement', 'OUI')
            ->find();
        for ($i = 0; $i < sizeof($monthlyFactLivPaid); $i++) {
            $monthlyFactLivPaid[$i] = (new Facturations)
                ->FactLivInfos($monthlyFactLivPaid[$i]);
        }
        $sumFactLivM = 0;
        foreach ($monthlyFactLivPaid as $i) {
            $sumFactLivM += $i['total'];
        }

        //get weeky total amount liv
        $weekyFactLivPaid = (new FactLiv())
            ->where('WEEK(date_paiement)', date('W'))
            ->where('YEAR(date_paiement)', date('Y'))
            ->where('paiement', 'OUI')
            ->find();
        for ($i = 0; $i < sizeof($weekyFactLivPaid); $i++) {
            $weekyFactLivPaid[$i] = (new Facturations)
                ->FactLivInfos($weekyFactLivPaid[$i]);
        }
        $sumFactLivW = 0;
        foreach ($weekyFactLivPaid as $i) {
            $sumFactLivW += $i['total'];
        }

        //get daily total amount liv
        $dailyFactLivPaid = (new FactLiv())
            ->where('DAY(date_paiement)', date('d'))
            ->where('MONTH(date_paiement)', date('m'))
            ->where('YEAR(date_paiement)', date('Y'))
            ->where('paiement', 'OUI')
            ->find();
        for ($i = 0; $i < sizeof($dailyFactLivPaid); $i++) {
            $dailyFactLivPaid[$i] = (new Facturations)
                ->FactLivInfos($dailyFactLivPaid[$i]);
        }
        $sumFactLivD = 0;
        foreach ($dailyFactLivPaid as $i) {
            $sumFactLivD += $i['total'];
        }



        return view('admin/dashboard', [

            //stat carburant
            'carte' => (new Carte())->first(),
            'recs' => (new Rechargement())
                ->select('rechargements.*, utilisateurs.nom')
                ->join('utilisateurs', 'utilisateur = utilisateurs.id')
                ->orderBy('created_at', 'DESC')
                ->findAll(),

            //client count
            'cli' => (new Clients())
                ->countAll(),

            //stats liv
            'sumFactLivY' => $sumFactLivY,
            'sumFactLivM' => $sumFactLivM,
            'sumFactLivW' => $sumFactLivW,
            'sumFactLivD' => $sumFactLivD,
            'factLivNotPaid' => sizeof(
                (new FactLiv())
                    ->where('annulation', 'NON')
                    ->where('paiement', 'NON')
                    ->find()
            ),

            // Informarions sur le compte appro
            'cpt_appro' => (new CompteAppro())->first(),
            'recs_appro' => (new RavApproModel())
                ->orderBy('DATE(date)', 'DESC')
                ->findAll(),

            //liv count
            'livsDailyCount' => sizeof(
                (new Livraisons())
                    ->select('fact_liv.date_pg')
                    ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
                    ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
                    ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
                    ->where('fact_liv.date_pg !=', null)
                    ->where('DAY(date_pg)', date('d', time()))
                    ->find()
            ),
            'livsWeekyCount' => sizeof(
                (new Livraisons())
                    ->select('fact_liv.date_pg')
                    ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
                    ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
                    ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
                    ->where('fact_liv.date_pg !=', null)
                    ->where('WEEK(date_pg)', date('W', time()))
                    ->find()
            ),
            'livsMonthlyCount' => sizeof(
                (new Livraisons())
                    ->select('fact_liv.date_pg')
                    ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
                    ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
                    ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
                    ->where('fact_liv.date_pg !=', null)
                    ->where('MONTH(date_pg)', date('m', time()))
                    ->find()
            ),
            'livsYearlyCount' => sizeof(
                (new Livraisons())
                    ->select('fact_liv.date_pg')
                    ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
                    ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
                    ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
                    ->where('fact_liv.date_pg !=', null)
                    ->where('YEAR(date_pg)', date('Y', time()))
                    ->find()
            ),
        ]);
    }
}
