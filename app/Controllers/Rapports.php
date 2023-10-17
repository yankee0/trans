<?php

namespace App\Controllers;

use App\Controllers\Livraisons;
use App\Controllers\BaseController;
use App\Controllers\Camions as ControllersCamions;
use App\Models\ApproModel;
use App\Models\RavApproModel;

class Rapports extends BaseController
{
    public function __construct()
    {
        session()->p = 'rapports';
    }

    public function index()
    {
        session()->p = 'rapports';
        return view('rapports/dashboard');
    }

    public function index_livraison($data = [])
    {
        session()->p = 'rapports';
        return view('rapports/livraisons/index', $data);
    }

    public function generate_livraison($params = null)
    {
        session()->p = 'rapports';
        $data = $params ?? $this->request->getVar();
        $timestamp = strtotime($data['date']);

        $y = date('Y', $timestamp);
        $m = date('m', $timestamp);
        $d = date('d', $timestamp);
        $w = date('W', $timestamp);

        $ctrl = new Livraisons();
        $sheet = [];
        $name = '';
        switch ($data['type']) {
            case 'j':
                $sheet = $ctrl->getAllLivs($y, $m, $d, $w);
                $name = 'Rapport journalier des livraisons du ' . $data['date'];
                break;
            case 'h':
                $sheet = $ctrl->getAllLivs($y, $m, null, $w);
                $name = 'Rapport hebdomadaire des livraisons  de la semaine ' . $w . ' année ' . $y;
                break;
            case 'm':
                $sheet = $ctrl->getAllLivs($y, $m);
                $name = 'Rapport mensuel des livraisons du ' . $m . 'e mois année ' . $y;
                break;
            case 'a':
                $sheet = $ctrl->getAllLivs($y);
                $name = 'Rapport annuel des livraisons année ' . $y;
                break;

            default:
                return redirect()
                    ->back()
                    ->with('n', false)
                    ->with('m', '499 - Données invalide');
                break;
        }

        return $this->index_livraison(
            [
                'data' => $sheet,
                'type' => $data['type'],
                'date' => $data['date'],
                'name' => $name
            ]
        );
    }

    public function index_carburant($data = [])
    {
        session()->p = 'rapports';
        return view('rapports/carburant/index', $data);
    }

    public function generate_carburant()
    {
        session()->p = 'rapports';
        $data = $this->request->getPost();
        $timestamp = strtotime($data['date']);

        $y = date('Y', $timestamp);
        $m = date('m', $timestamp);
        $d = date('d', $timestamp);
        $w = date('W', $timestamp);

        $ctrl = new ControllersCamions();
        $sheet = [];
        $name = '';
        switch ($data['type']) {
            case 'j':
                $sheet = $ctrl->consCarb($d, $w, $m, $y);
                $name = 'Rapport consommation de carburant journalier lors des livraisons du ' . $data['date'];
                break;
            case 'h':
                $sheet = $ctrl->consCarb(null, $w, $m, $y);
                $name = 'Rapport consommation de carburant hebdomadaire lors des livraisons  de la semaine ' . $w . ' année ' . $y;
                break;
            case 'm':
                $sheet = $ctrl->consCarb(null, null, $m, $y);
                $name = 'Rapport consommation de carburant mensuel lors des livraisons du ' . $m . 'e mois année ' . $y;
                break;
            case 'a':
                $sheet = $ctrl->consCarb(null, null, null, $y);
                $name = 'Rapport consommation de carburant annuel lors des livraisons année ' . $y;
                break;

            default:
                return redirect()
                    ->back()
                    ->with('n', false)
                    ->with('m', '499 - Données invalide');
                break;
        }
        $sum = 0;
        foreach ($sheet as $i) {
            $sum += intval($i['litrage']);
        }
        return $this->index_carburant(
            [
                'data' => $sheet,
                'type' => $data['type'],
                'date' => $data['date'],
                'name' => $name,
                'sum' => $sum
            ]
        );
    }

    public function index_finance($data = [])
    {
        session()->p = 'rapports';
        return view('rapports/finance/index', $data);
    }

    public function generate_finance()
    {
        session()->p = 'rapports';
        $data = $this->request->getPost();
        $timestamp = strtotime($data['date']);

        $y = date('Y', $timestamp);
        $m = date('m', $timestamp);
        $d = date('d', $timestamp);
        $w = date('W', $timestamp);

        $ctrl = new FactLiv();
        $sheet = [];
        $name = '';
        switch ($data['type']) {
            case 'j':
                $sheet = $ctrl->factInfo($d, $w, $m, $y);
                $name = 'Rapport finance journalier des livraisons du ' . $data['date'];
                break;
            case 'h':
                $sheet = $ctrl->factInfo(null, $w, $m, $y);
                $name = 'Rapport finance hebdomadaire des livraisons  de la semaine ' . $w . ' année ' . $y;
                break;
            case 'm':
                $sheet = $ctrl->factInfo(null, null, $m, $y);
                $name = 'Rapport finance mensuel des livraisons du ' . $m . 'e mois année ' . $y;
                break;
            case 'a':
                $sheet = $ctrl->factInfo(null, null, null, $y);
                $name = 'Rapport finance annuel des livraisons année ' . $y;
                break;

            default:
                return redirect()
                    ->back()
                    ->with('n', false)
                    ->with('m', '499 - Données invalide');
                break;
        }

        return $this->index_finance(
            [
                'data' => $sheet,
                'type' => $data['type'],
                'date' => $data['date'],
                'name' => $name
            ]
        );
    }

    public function index_pregate($data = [])
    {
        session()->p = 'rapports';
        return view('rapports/pregate/index', $data);
    }

    public function generate_pregate()
    {
        session()->p = 'rapports';
        $data = $this->request->getPost();

        $ctrl = new Livraisons();
        $name = 'Rapports des pregates du ' . $data['from'] . ' au ' . $data['to'] . '.';
        $sheet = $ctrl->getLastpregate($data['from'], $data['to']);


        return $this->index_pregate(
            [
                'data' => $sheet,
                'from' => $data['from'],
                'to' => $data['to'],
                'name' => $name
            ]
        );
    }

    public function index_approvisionnements()
    {
        $model = new RavApproModel();
        $data = [
            'recs' => $model->orderBy('date', 'desc')->find(),
            'res' => [],
        ];
        return view("rapports/approvisionnements/index", $data);
    }

    public function generate_approvisionnements()
    {
        $data = $this->request->getVar();
        $modelAppro = new ApproModel();
        $modelRec = new RavApproModel();

        $recs = $modelRec
            ->where('date >=', $data['from'])
            ->where('date <=', $data['to'])
            ->orderBy('date', 'asc')
            ->findAll();

        $res = [];

        /**
         * Equation de l'approvisionnement
         * 
         *  Sc = So + Roc - Doc
         *  Sd = Sc + Rcd - Dcd
         */
        for ($i = 0; $i < sizeof($recs); $i++) {
            if ($i + 1 < sizeof($recs)) {
                $res[$i]['recharge'] = "Rechargement de " . number_format($recs[$i]['montant']) . " FCFA le " . date('d/m/Y à H:i', strtotime($recs[$i]['date']));

                /**
                 * Solde initial
                 */
                $So = 0.00;

                $Roc = $modelRec
                    ->select('SUM(montant) as montant')
                    ->where('date <=', $recs[$i + 1]['date'])
                    ->find()[0]['montant'];

                $Doc = $modelAppro
                    ->select('SUM(montant) as montant')
                    ->where('date <=', $recs[$i]['date'])
                    ->find()[0]['montant'];

                $Rcd = $modelRec
                    ->select('SUM(montant) as montant')
                    ->where('date <=', $recs[$i]['date'])
                    ->where('date >=', $recs[$i + 1]['date'])
                    ->find()[0]['montant'];

                $Dcd = $modelAppro
                    ->select('SUM(montant) as montant')
                    ->where('date >=', $recs[$i]['date'])
                    ->where('date <=', $recs[$i + 1]['date'])
                    ->find()[0]['montant'];

                $Dcd_liste = $modelAppro
                    ->where('date >=', $recs[$i]['date'])
                    ->where('date <=', $recs[$i + 1]['date'])
                    ->find();

                $res[$i]['solde_init'] = $So + doubleval($Roc) - doubleval($Doc);
                $res[$i]['solde_fin'] = $res[$i]['solde_init'] + doubleval($Rcd) - doubleval($Dcd);

                $res[$i]['appros'] = $Dcd_liste;
            }
        }

        $model = new RavApproModel();
        $data = [
            'recs' => $model->orderBy('date', 'desc')->find(),
            'res' => $res,
            'rechs' => $recs,
        ];
        return view("rapports/approvisionnements/index", $data);
    }
}
