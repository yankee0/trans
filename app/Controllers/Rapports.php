<?php

namespace App\Controllers;

use App\Controllers\BaseController;

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
        return view('rapports/livraisons/index',$data);
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
                $name = 'Rapport journalier des livraisons du '.$data['date'];
                break;
            case 'h':
                $sheet = $ctrl->getAllLivs($y, $m, null, $w);
                $name = 'Rapport hebdomadaire des livraisons  de la semaine '.$w.' année '.$y;
                break;
            case 'm':
                $sheet = $ctrl->getAllLivs($y, $m);
                $name = 'Rapport mensuel des livraisons du '.$m.'e mois année '.$y;
                break;
            case 'a':
                $sheet = $ctrl->getAllLivs($y);
                $name = 'Rapport annuel des livraisons année '.$y;
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

    public function index_carburant()
    {
        session()->p = 'rapports';
        return view('rapports/carburant/index');
    }

    public function index_finance()
    {
        session()->p = 'rapports';
        return view('rapports/finance/index');
    }
}
