<?php

namespace App\Controllers;

use App\Controllers\Livraisons;
use App\Controllers\BaseController;
use App\Controllers\Camions as ControllersCamions;

class Rapports extends BaseController
{
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

    public function generate_livraison()
    {
        session()->p = 'rapports';
        $data = $this->request->getPost();
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
        return view('rapports/carburant/index',$data);
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
        $sum = 0 ;
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
        return view('rapports/pregates/index', $data);
    }

    public function generate_pregate()
    {
        session()->p = 'rapports';
        $data = $this->request->getPost();
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
                $sheet = $ctrl->getLastpregates($d, $w, $m, $y);
                $name = 'Rapport pregates journaliers du ' . $data['date'];
                break;
            case 'h':
                $sheet = $ctrl->getLastpregates(null, $w, $m, $y);
                $name = 'Rapport pregates hebdomadaires de la semaine ' . $w . ' année ' . $y;
                break;
            case 'm':
                $sheet = $ctrl->getLastpregates(null, null, $m, $y);
                $name = 'Rapport pregates mensuels du ' . $m . 'e mois année ' . $y;
                break;
            case 'a':
                $sheet = $ctrl->getLastpregates(null, null, null, $y);
                $name = 'Rapport pregates annuels année ' . $y;
                break;

            default:
                return redirect()
                    ->back()
                    ->with('n', false)
                    ->with('m', '499 - Données invalide');
                break;
        }

        return $this->index_pregate(
            [
                'data' => $sheet,
                'type' => $data['type'],
                'date' => $data['date'],
                'name' => $name
            ]
        );
    }
}
