<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Clients;
use App\Models\FactLiv as ModelsFactLiv;
use App\Models\FactLivLieux;
use App\Models\FactLivLignes;
use App\Models\Livraisons;
use App\Models\Zones;
use Exception;

class FactLiv extends BaseController
{
    public function list()
    {
        session()->p = 'f-livraisons';
        $factLiv = (new ModelsFactLiv())->limit(5)->findAll();
        for ($i = 0; $i < sizeof($factLiv); $i++) {
            $factLiv[$i] = (new Facturations())->FactLivInfos($factLiv[$i]);
        }

        return view('facturation/livraisons/list', [
            'cli' => (new Clients())->findAll(),
            'fact_liv_last' => $factLiv,

        ]);
    }

    public function add()
    {
        $data = $this->request->getPost();

        // Zones de livraisons requises
        if (!isset($data['zone'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with('n', false)
                ->with('m', 'Facturation incorrecte.');
        }

        //le BL doit etre unique
        $rules = [
            'bl' => [
                'rules' => 'is_unique[fact_liv.bl]',
                'errors' => [
                    'is_unique' => 'BL en doublon.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('n', false)
                ->with('m', '<br />' . $this->validator->listErrors());
        } else {

            //creation de la facture
            $data_liv = [
                'consignataire' => strtoupper($data['consignataire']),
                'id_client' => intval($data['id_client']),
                'compagnie' => strtoupper($data['compagnie']),
                'bl' => strtoupper($data['bl']),
                'csrf_test_name' => $data['csrf_test_name']
            ];
            try {
                $facture = (new ModelsFactLiv())->insert($data_liv, true);
            } catch (Exception $e) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('n', false)
                    ->with('m', '<br />' . $e->getMessage());
            }

            //conteneurs 20'
            $c_20 = $data['c_20'];
            for ($i = 0; $i < sizeof($c_20); $i++) {
                $c_20[$i] = explode('-', $c_20[$i]);

                //supprimer les cases vides
                for ($j = 0; $j < sizeof($c_20[$i]); $j++) {
                    if (empty($c_20[$i][$j])) {
                        unset($c_20[$i][$j]);
                    }
                }
            }

            //conteneurs 40'
            $c_40 = $data['c_40'];
            for ($i = 0; $i < sizeof($c_40); $i++) {
                $c_40[$i] = explode('-', $c_40[$i]);

                //supprimer les cases vides
                for ($j = 0; $j < sizeof($c_40[$i]); $j++) {
                    if (empty($c_40[$i][$j])) {
                        unset($c_40[$i][$j]);
                    }
                }
            }

            try {
                //traitement
                for ($i = 0; $i < sizeof($data['zone']); $i++) {

                    // recuperation des infos de la zones
                    $zone = (new Zones())->find($data['zone'][$i]);
                    if (empty($zone)) {
                        $zone['id'] = null;
                    }
                    // dd($zone['id']);
                    //création de la relation facture-zone (lieux de livraisons)
                    try {

                        $lieux = (new FactLivLieux())->insert([
                            'id_fact' => intval($facture),
                            'id_zone' => intval($zone['id']),
                            'designation' => 'LIVRAISON ' . $zone['nom'],
                            'carburant' => $zone['carburant'],
                            'adresse' => $data['address'][$i],
                        ], true);
                        // dd($lieux);
                    } catch (Exception $e) {
                        (new ModelsFactLiv())->delete($facture);
                        return redirect()
                            ->back()
                            ->withInput()
                            ->with('n', false)
                            ->with('m', '<br />' . $e->getMessage());
                    }

                    //pour les 20'
                    foreach ($c_20[$i] as $c) {

                        if (!empty($c)) {
                            $trimed = trim($c);

                            //création de la ligne de facture
                            $ligne = (new FactLivLignes())->insert([
                                'id_lieu' => intval($lieux),
                                'conteneur' => $trimed,
                                'type' => '20',
                                'prix' => intval($data['ht_20'][$i])
                            ], true);

                            //création de la livraison
                            (new Livraisons())->insert([
                                'id_fact_ligne' => $ligne
                            ], true);
                        }
                    }

                    //pour les 40'
                    foreach ($c_40[$i] as $c) {

                        if (!empty($c)) {
                            $trimed = trim($c);

                            //création de la ligne de facture
                            $ligne = (new FactLivLignes())->insert([
                                'id_lieu' => intval($lieux),
                                'conteneur' => $trimed,
                                'type' => '40',
                                'prix' => intval($data['ht_40'][$i])
                            ], true);

                            //création de la livraison
                            $livraison = (new Livraisons())->insert([
                                'id_fact_ligne' => $ligne
                            ], true);
                        }
                    }
                }
            } catch (Exception $e) {
                (new ModelsFactLiv())->delete($facture);
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('n', false)
                    ->with('m', '<br />' . $e->getMessage());
            }
            return redirect()
                ->to(session()->r . '/livraisons/details/' . $facture)
                ->with('n', true)
                ->with('m', 'Enregistrement réussie');
        }
    }

    public function showInvoice($id = null)
    {
        $invoice = (new ModelsFactLiv())->find($id);
        if (empty($invoice)) {
            return view('errors/cli/error_404', [
                'm' => 'La facture que vous cherchez n\'existe pas ou a été supprimée.',
                'code' => 404
            ]);
        } else {
            $zones = (new FactLivLieux())
                ->where('id_fact', $invoice['id'])
                ->find();

            // juste pour rajouter le nom de la zone,
            // ca peut servir plutard
            // for ($i=0; $i < sizeof($zones); $i++) { 
            //     $zitem = (new Zones())
            //     ->where('id',$zones[$i]['id_zone'])
            //     ->first();
            //     $zones[$i]['zone'] = (empty($zitem)) ? 'INCONNUE' : $zitem['nom']; 
            // }


            //le total
            $total = 0;

            for ($i = 0; $i < sizeof($zones); $i++) {
                $c_20 = (new FactLivLignes())
                    ->where('id_lieu', $zones[$i]['id'])
                    ->where('type', '20')
                    ->find();
                if (!empty($c_20)) {
                    $total += (sizeof($c_20) * $c_20[0]['prix']);
                }
                $zones[$i]['c_20'] = [];
                $zones[$i]['c_20'] = array_merge($zones[$i]['c_20'], $c_20);
                $c_40 = (new FactLivLignes())
                    ->where('id_lieu', $zones[$i]['id'])
                    ->where('type', '40')
                    ->find();
                if (!empty($c_40)) {
                    $total += (sizeof($c_40) * $c_40[0]['prix']);
                }
                $zones[$i]['c_40'] = [];
                $zones[$i]['c_40'] = array_merge($zones[$i]['c_40'], $c_40);
            }
            $data = [
                'facture' => $invoice,
                'zones' => $zones,
                'total' => $total,
                'taxe' => $total * 18 / 100,
                'ttc' => $total + $total * 18 / 100,
            ];

            return view('facturation/livraisons/factures', $data);
        }
    }

    public function delete($seg)
    {
        $data = explode(' ', $seg);
        $id = $data[1];
        try {
            (new ModelsFactLiv())->delete($id);
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
            ->with('m', 'Suppression réussie');
    }
}
