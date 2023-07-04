<?php

namespace App\Controllers;

use Exception;
use App\Models\Clients;
use App\Models\FactLiv;
use App\Controllers\BaseController;

class Finance extends BaseController
{
    public function index()
    {
        session()->p = 'dashboard';
        $model_fact_liv = new FactLiv();

        //get the last liv invoices
        $factLiv = $model_fact_liv
            ->limit(5)
            ->orderBy('created_at', 'DESC')
            ->findAll();
        for ($i = 0; $i < sizeof($factLiv); $i++) {
            $factLiv[$i] = (new Facturations)->FactLivInfos($factLiv[$i]);
        }

        //get the yearly total amount liv
        $yearlyFactLivPaid = $model_fact_liv
            ->where('YEAR(created_at)', date('Y', time()))
            ->where('paiement', 'OUI')
            ->find();
        for ($i = 0; $i < sizeof($yearlyFactLivPaid); $i++) {
            $yearlyFactLivPaid[$i] = (new Facturations)
                ->FactLivInfos($yearlyFactLivPaid[$i]);
        }
        $sumFactLivY = 0;
        foreach ($yearlyFactLivPaid as $i) {
            $sumFactLivY += $i['total'];
        }

        //get the monthly total amount liv
        $monthlyFactLivPaid = $model_fact_liv
            ->where('MONTH(created_at)', date('m', time()))
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
        $weekyFactLivPaid = $model_fact_liv
            ->where('WEEK(created_at)', date('W', time()))
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
        $dailyFactLivPaid = $model_fact_liv
            ->where('DAY(created_at)', date('d', time()))
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


        $data = [

            //last invoices
            'fact_liv_last' => $factLiv,

            //client count
            'cli' => (new Clients())
                ->countAll(),

            //stats liv
            'sumFactLivY' => $sumFactLivD,
            'sumFactLivM' => $sumFactLivM,
            'sumFactLivW' => $sumFactLivW,
            'sumFactLivD' => $sumFactLivD,
            'factLivNotPaid' => sizeof(
                $model_fact_liv
                    ->where('annulation', 'NON')
                    ->where('paiement', 'NON')
                    ->find()
            )
        ];
        return view('finance/dashboard', $data);
    }

    public function showPay($id)
    {
        session()->p = 'f-liv';

        $invoice = (new Facturations())
            ->FactLivInfos(
                (new FactLiv())
                    ->find($id)
            );

        $data  = [
            'facture' => $invoice,
        ];
        return view('finance/payPage', $data);
    }

    public function managePay($id)
    {
        $data = $this->request->getPost();
        $data['id'] = $id;
        $data['paiement'] = (isset($data['paiement']) and $data['paiement'] == 'on') ? 'OUI' : 'NON';
        $data['reglement'] = !isset($data['reglement']) ? 'NON PAYÉ' : $data['reglement'];
        // dd($data);

        try {
            (new FactLiv())->save($data);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('n', false)
                ->with('m', '<br />' . $e->getMessage());
        }
        return redirect()
            ->back()
            ->with('n', true)
            ->with('m', 'Modification réussie');
    }

    public function showLivs()
    {
        session()->p = 'f-liv';
        $get = $this->request->getGet();
        $modelLiv = new FactLiv();
        if (isset($get['search'])) {
            $facts = $modelLiv
                ->like('bl', $get['search'])
                ->orLike('id_client', $get['search'])
                ->orLike('compagnie', $get['search'])
                ->orLike('created_at', $get['search'])
                ->orderBy('created_at', 'DESC')
                ->paginate(25);
            $data['search'] = $get['search'];
        } else {
            $facts = $modelLiv->paginate(25);
        }
        // dd($facts);
        for ($i = 0; $i < sizeof($facts); $i++) {
            $facts[$i] = (new Facturations)->FactLivInfos($facts[$i]);
        }
        $data =  [
            'facts' => $facts,
            'pager' => $modelLiv->pager
        ];

        return view('finance/livraisons', $data);
    }
}
