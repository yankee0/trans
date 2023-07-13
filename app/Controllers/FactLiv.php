<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Clients;
use App\Models\FactLiv as ModelsFactLiv;
use App\Models\FactLivLieux;
use App\Models\FactLivLignes;
use App\Models\Livraisons;
use App\Models\Zones;
use CodeIgniter\Exceptions\PageNotFoundException;
use Exception;



class FactLiv extends BaseController
{
    public function list()
    {
        session()->p = 'f-livraisons';
        $factLiv = (new ModelsFactLiv())
            ->limit(5)
            ->orderBy('created_at', 'DESC')
            ->findAll();
        for ($i = 0; $i < sizeof($factLiv); $i++) {
            $factLiv[$i] = (new Facturations())->FactLivInfos($factLiv[$i]);
        }

        return view('facturation/livraisons/list', [
            'cli' => (new Clients())
                ->orderBy('nom')
                ->findAll(),
            'fact_liv_last' => $factLiv,

        ]);
    }

    public function add($defined_invoice = null)
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
            if ($defined_invoice == null) {
                $data_liv = [
                    'consignataire' => strtoupper($data['consignataire']),
                    'id_client' => intval($data['id_client']),
                    'compagnie' => strtoupper($data['compagnie']),
                    'bl' => strtoupper($data['bl']),
                    'csrf_test_name' => $data['csrf_test_name'],
                    'copie' => isset($data['copie']) ? 500 : 0,
                    'ages' => isset($data['ages']) ? 1500 : 0,
                    'hammar' => isset($data['hamCheck']) and isset($data['hammar']) ? $data['hammar'] : 0,
                ];
            }
            try {
                $facture = ($defined_invoice == null) ? (new ModelsFactLiv())->insert($data_liv, true) : $defined_invoice;
            } catch (Exception $e) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('n', false)
                    ->with('m', '<br />' . $e->getMessage());
            }
            // dd($facture);
            //conteneurs 20'
            $c_20 = $data['c_20'];
            for ($i = 0; $i < sizeof($c_20); $i++) {
                $c_20[$i] = explode('-', $c_20[$i]);

                //supprimer les cases vides
                for ($j = 0; $j < sizeof($c_20[$i]); $j++) {
                    $c_20[$i][$j] = strtoupper($c_20[$i][$j]);
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
                    $c_40[$i][$j] = strtoupper($c_40[$i][$j]);
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
                        $check = (new FactLivLieux())->where([
                            'id_fact' => intval($facture),
                            'id_zone' => intval($zone['id']),
                        ])->find();

                        if (sizeof($check) != 0) {
                            if ($defined_invoice == null) {
                                (new FactLiv)->delete($facture);
                            }
                            throw new Exception('Un doublon de zone détecté.');
                        }

                        // dd($check);
                        // dd($lieux);
                        $lieux = (new FactLivLieux())->insert([
                            'id_fact' => intval($facture),
                            'id_zone' => intval($zone['id']),
                            'designation' => 'Livraison ' . $zone['nom'],
                            'carburant' => $zone['carburant'],
                            'adresse' => $data['address'][$i],
                        ], true);
                    } catch (Exception $e) {
                        if ($defined_invoice == null) {
                            (new FactLiv)->delete($facture);
                        }
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

                            try {
                                $check = (new FactLivLignes())->where([
                                    'id_lieu' => intval($lieux),
                                    'conteneur' => $trimed,
                                ])->find();

                                if (sizeof($check) != 0) {
                                    if ($defined_invoice == null) {
                                        (new FactLiv)->delete($facture);
                                    }
                                    throw new Exception('Un doublon de conteneur détecté.');
                                }

                                //création de la ligne de facture
                                $ligne = (new FactLivLignes())->insert([
                                    'id_lieu' => intval($lieux),
                                    'conteneur' => $trimed,
                                    'type' => '20',
                                    'prix' => intval($data['ht_20'][$i])
                                ], true);
                            } catch (Exception $e) {
                                return redirect()
                                    ->back()
                                    ->withInput()
                                    ->with('n', false)
                                    ->with('m', '<br />' . $e->getMessage());
                            }


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

                            try {
                                $check = (new FactLivLignes())->where([
                                    'id_lieu' => intval($lieux),
                                    'conteneur' => $trimed,
                                ])->find();

                                if (sizeof($check) != 0) {
                                    if ($defined_invoice == null) {
                                        (new FactLiv)->delete($facture);
                                    }
                                    throw new Exception('Un doublon de conteneur détecté.');
                                }

                                //création de la ligne de facture
                                $ligne = (new FactLivLignes())->insert([
                                    'id_lieu' => intval($lieux),
                                    'conteneur' => $trimed,
                                    'type' => '40',
                                    'prix' => intval($data['ht_40'][$i])
                                ], true);
                            } catch (Exception $e) {
                                return redirect()
                                    ->back()
                                    ->withInput()
                                    ->with('n', false)
                                    ->with('m', '<br />' . $e->getMessage());
                            }
                            //création de la livraison
                            (new Livraisons())->insert([
                                'id_fact_ligne' => $ligne
                            ], true);
                        }
                    }
                }
            } catch (Exception $e) {
                if ($defined_invoice == null) {
                    (new FactLiv)->delete($facture);
                }
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('n', false)
                    ->with('m', '<br />' . $e->getMessage());
            }
            return redirect()
                ->to(session()->r . '/livraisons/edit/' . $facture)
                ->with('n', true)
                ->with('m', 'Enregistrement réussie');
        }
    }

    public function showInvoice($id = null)
    {
        return view('facturation/livraisons/factures', $this->getInvoice($id));
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

    public function search()
    {
        $data = $this->request->getGet();
        $s = isset($data['search']) ? $data['search'] : '%';
        $modele = new ModelsFactLiv();
        $r = $modele
            ->like('bl', $s)
            ->orLike('id_client', $s)
            ->orLike('compagnie', $s)
            ->orLike('created_at', $s)
            ->orderBy('created_at', 'DESC')
            ->paginate(20);
        // if (!empty($r)) {
        //     for ($i = 0; $i < sizeof($r); $i++) {
        //         (new Facturations)->FactLivInfos($r);
        //     }
        // }
        $data = [
            'r' => $r,
            'pager' => $modele->pager,
            'search' => $s
        ];

        return view('facturation/livraisons/search', $data);
    }

    public function getInvoice($id)
    {
        $invoice = (new ModelsFactLiv())->find($id);
        if (empty($invoice)) {
            throw new PageNotFoundException('Facture introuvable ou supprimée.', 404);
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
            $total = $invoice['ages'] + $invoice['hammar'] + $invoice['copie'];

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
        }
        return $data;
    }

    public function showEdit($id)
    {
        $data = $this->getInvoice($id);
        $data['cli'] = (new Clients())
            ->orderBy('nom')
            ->findAll();
        $data['zn'] = (new Zones())
            ->orderBy('nom')
            ->findAll();
        return view('facturation/livraisons/edit', $data);
    }

    public function editFactLiveHeader($id)
    {
        $data = $this->request->getPost();
        $data['id'] = $id;
        if (isset($data['consignataire'])) {
            $data['consignataire'] = strtoupper($data['consignataire']);
        }
        if (isset($data['compagnie'])) {
            $data['compagnie'] = strtoupper($data['compagnie']);
        }
        if (isset($data['bl'])) {
            $data['bl'] = strtoupper($data['bl']);
            //le BL doit etre unique
            $rules = [
                'bl' => [
                    'rules' => 'is_unique[fact_liv.bl,bl,' . strtoupper($data['last_bl']) . ']',
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
            }
        }
        try {
            (new ModelsFactLiv())->save($data);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('n', false)
                ->with('m', '<br />' . $e->getMessage());
        }
        return redirect()
            ->back()
            ->withInput()
            ->with('n', true)
            ->with('m', 'Modification réussie.');
    }

    public function addZone()
    {
        return $this->add($this->request->getVar('facture'));
    }

    public function deleteZone($f, $z)
    {
        // dd($f);
        try {
            (new FactLivLieux())
                ->where('id_fact', $f)
                ->where('id_zone', $z)
                ->delete();
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('n', false)
                ->with('m', '<br />' . $e->getMessage());
        }
        return redirect()
            ->back()
            ->withInput()
            ->with('n', true)
            ->with('m', 'Suppression réussie.');
    }

    public function changeZone()
    {
        $new_zone = (new Zones())->find($this->request->getVar('zone'));
        try {
            (new FactLivLieux())
                ->save([
                    'id' => $this->request->getVar('lastzone'),
                    'id_zone' => $new_zone['id'],
                    'designation' => 'Livraison ' . $new_zone['nom']
                ]);

            //mettre a jour le prix des livraisons
            (new FactLivLignes())
                ->where('id_lieu', $this->request->getVar('lastzone'))
                ->where('type', '20')
                ->set([
                    'prix' => $new_zone['ht_liv_20']
                ])
                ->update();

            (new FactLivLignes())
                ->where('id_lieu', $this->request->getVar('lastzone'))
                ->where('type', '40')
                ->set([
                    'prix' => $new_zone['ht_liv_40']
                ])
                ->update();
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('n', false)
                ->with('m', '<br />' . $e->getMessage());
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('n', true)
            ->with('m', 'Modification réussie.');
    }

    public function editAddress($id)
    {
        $data = $this->request->getPost();
        $data = array_merge($data, ['id' => $id]);
        $data['adresse'] = strtoupper($data['adresse']);
        try {
            (new FactLivLieux())
                ->save($data);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('n', false)
                ->with('m', '<br />' . $e->getMessage());
        }
        return redirect()
            ->back()
            ->withInput()
            ->with('n', true)
            ->with('m', 'Modification réussie.');
    }

    public function editPrice($id)
    {

        $c_20 = (new FactLivLignes())
            ->where('id_lieu', $id)
            ->where('type', '20')
            ->find();
        $c_40 = (new FactLivLignes())
            ->where('id_lieu', $id)
            ->where('type', '40')
            ->find();

        foreach ($c_20 as $c) {
            try {
                (new FactLivLignes())
                    ->update($c['id'], [
                        'prix' => intval($this->request->getVar('prix_20'))
                    ]);
            } catch (Exception $e) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('n', false)
                    ->with('m', '<br />' . $e->getMessage());
            }
        }

        foreach ($c_40 as $c) {
            try {
                (new FactLivLignes())
                    ->update($c['id'], [
                        'prix' => intval($this->request->getVar('prix_40'))
                    ]);
            } catch (Exception $e) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('n', false)
                    ->with('m', '<br />' . $e->getMessage());
            }
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('n', true)
            ->with('m', 'Modification réussie.');
    }

    public function deleteContainer($id)
    {

        try {
            (new FactLivLignes())->delete($id);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('n', false)
                ->with('m', '<br />' . $e->getMessage());
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('n', true)
            ->with('m', 'Suppression réussie.');
    }

    public function editContainer($id)
    {
        $data = $this->request->getPost();
        $data['id'] = $id;

        try {
            (new FactLivLignes())->save($data);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('n', false)
                ->with('m', '<br />' . $e->getMessage());
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('n', true)
            ->with('m', 'Modification réussie.');
    }

    public function addContainer()
    {
        $data = $this->request->getPost();
        $data['conteneur'] = strtoupper($data['conteneur']);
        try {
            $check = (new FactLivLignes())->where([
                'id_lieu' => intval($data['id_lieu']),
                'conteneur' => $data['conteneur'],
            ])->find();

            if (sizeof($check) != 0) {
                throw new Exception('Un doublon de conteneur détecté.');
            }

            $prix = (new FactLivLieux())
                ->where('fact_liv_lieux.id', $data['id_lieu'])
                ->select('
                    zones.ht_liv_20,
                    zones.ht_liv_40,
                ')
                ->join('zones', 'zones.id = fact_liv_lieux.id_zone')
                ->first();

            $data['prix'] = $data['type'] == '20' ? $prix['ht_liv_20'] : $prix['ht_liv_40'];
            // dd($data);
            (new FactLivLignes())->save($data);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('n', false)
                ->with('m', '<br />' . $e->getMessage());
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('n', true)
            ->with('m', 'Ajout réussie.');
    }

    public function abord($id)
    {
        $data = [
            'id' => $id,
            'annulation' => 'OUI',
            'motif' => $this->request->getVar('motif'),
        ];
        // dd($data);

        try {
            (new ModelsFactLiv())->save($data);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('n', false)
                ->with('m', '<br />' . $e->getMessage());
        }

        $lieux = (new FactLivLieux())
            ->where('id_fact', $id)
            ->findAll();
        foreach ($lieux as $l) {
            $livs = (new FactLivLignes())
                ->where('id_lieu', $l['id'])
                ->findAll();

            foreach ($livs as $liv) {
                $datalivs = [
                    'id' => $liv['id'],
                    'etat' => 'ANNULÉ',
                    'motif' => $this->request->getVar('motif'),
                ];
                (new Livraisons())->save($datalivs);
            }
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('n', true)
            ->with('m', 'Facture annulée.');
    }

    public function factInfo($d = null, $w = null, $m = null, $y = null)
    {
        $modele = new ModelsFactLiv();

    }
}
