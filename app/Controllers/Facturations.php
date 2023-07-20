<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Clients;
use App\Models\FactLiv;
use App\Models\FactLivLieux;
use App\Models\FactLivLignes;

class Facturations extends BaseController
{
    public function index()
    {
        session()->p = 'dashboard';
        $model_fact_liv = new FactLiv();
        $factLiv = $model_fact_liv
            ->limit(5)
            ->orderBy('date_creation', 'DESC')
            ->findAll();
            // dd($factLiv);
        for ($i = 0; $i < sizeof($factLiv); $i++) {
            $factLiv[$i] = $this->FactLivInfos($factLiv[$i]);
        }
        // dd($factLiv);
        $data = [
            'fact_liv_count' => $model_fact_liv->countAll(),
            'fact_liv_last' => $factLiv,
            'cli' => (new Clients())->countAll(),
            'liv' => (new FactLiv())
                ->countAll(),
            'liv_preget' => (new FactLiv())
                ->where('preget', 'NON')
                ->findAll(),
            'fact_liv_last' => $factLiv,
            'avec_tva' => (isset($data['tva'])) ? 'OUI' : 'NON'
        ];
        return view('facturation/dashboard', $data);
    }

    public function FactLivInfos(array $factLiv)
    {

        //recuperation des zones
        $zones = (new FactLivLieux())
            ->where('id_fact', $factLiv['id'])
            ->find();

        //total
        //il sera définie d'une maniere bizarre
        //se referer au digramme de classe ok
        $total = 0;

        //nombre de 20pieds
        $n20 = 0;
        for ($i = 0; $i < sizeof($zones); $i++) {
            $c = (new FactLivLignes())
                ->where('id_lieu', $zones[$i]['id'])
                ->where('type', '20')
                ->find();
            $n20 += sizeof($c);

            //la bizarrerie du total
            foreach ($c as $item) {
                $total += intval($item['prix']);
            }
        }
        $factLiv['n20'] = $n20;

        //nombre de 40pieds
        $n40 = 0;
        for ($i = 0; $i < sizeof($zones); $i++) {
            $c = (new FactLivLignes())
                ->where('id_lieu', $zones[$i]['id'])
                ->where('type', '40')
                ->find();
            $n40 += sizeof($c);

            //la bizarrerie du total
            foreach ($c as $item) {
                $total += intval($item['prix']);
            }
        }
        $factLiv['n40'] = $n40;

        //ainsi le total + tva
        $tva = $factLiv['avec_tva'] == 'OUI' ? 18 / 100 : 0;
        $ags = $factLiv['avec_ages'] == 'OUI' ? $factLiv['ages'] : 0;
        $copie = $factLiv['avec_copie'] == 'OUI' ? $factLiv['copie'] : 0;
        $total = $total + $ags + $copie + $factLiv['hammar'];
        $factLiv['total'] = $total + ($total * $tva);

        return $factLiv;
    }
}
