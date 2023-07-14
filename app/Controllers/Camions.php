<?php

namespace App\Controllers;

use Exception;
use App\Controllers\BaseController;
use App\Models\Camions as ModelsCamions;

class Camions extends BaseController
{
    public function list()
    {
        session()->p = 'camions';
        $modele = new ModelsCamions();
        $data = [
            'count' => $modele->countAll(),
            'list' => $modele->paginate(25),
            'pager' => $modele->pager
        ];
        return view('camions/list', $data);
    }

    public function delete()
    {
        $data = $this->request->getVar();
        try {
            (new ModelsCamions())->delete($data['id']);
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->with('n', false)
                ->with('m', 'Une erreur est survenue lors de la suppression.');
        }
        return redirect()
            ->back()
            ->with('n', true)
            ->with('m', 'Suppression réussie.');
    }

    public function edit()
    {
        $data = $this->request->getPost();
        $u = (new ModelsCamions())->find($data['id']);
        $rules = [
            'im' => [
                'rules' => 'is_unique[camions.im,im,' . $u['im'] . ']',
                'errors' => [
                    'is_unique' => 'Immatriculation en doublon.'
                ],
            ]
        ];
        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('n', false)
                ->with('m', '<br />' . $this->validator->listErrors());
        } else {
            try {
                $data['im'] = strtoupper($data['im']);
                if (empty($data['vt'])) {
                    unset($data['vt']);
                }
                if (empty($data['as'])) {
                    unset($data['as']);
                }
                (new ModelsCamions())->save($data);
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
                ->with('m', 'Modification réussie.');
        }
    }

    public function add()
    {
        $data = $this->request->getPost();
        $rules = [
            'im' => [
                'rules' => 'is_unique[camions.im]',
                'errors' => [
                    'is_unique' => 'Immatriculation en doublon.'
                ],
            ]
        ];
        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('n', false)
                ->with('m', '<br />' . $this->validator->listErrors());
        } else {
            try {
                $data['im'] = strtoupper($data['im']);
                if (empty($data['vt'])) {
                    unset($data['vt']);
                }
                if (empty($data['as'])) {
                    unset($data['as']);
                }
                (new ModelsCamions())->insert($data);
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
                ->with('m', 'Ajout réussi.');
        }
    }

    public function search()
    {
        $data = $this->request->getGet();
        $s = isset($data['search']) ? $data['search'] : '%';
        if (empty($s)) {
            return redirect()->to(session()->r . '/camions');
        }
        $modele = new ModelsCamions();
        $r = $modele
            ->like('im', $s)
            ->orLike('societe', $s)
            ->orLike('as', $s)
            ->orLike('vt', $s)
            ->paginate(25);
        $data = [
            'count' => sizeof($r),
            'list' => $r,
            'pager' => $modele->pager,
            'search' => $s
        ];
        return view('camions/list', $data);
    }

    public function consCarb($d = null, $w = null, $m = null, $y = null)
    {
        $builder = new ModelsCamions();
        $builder
            ->select('
            camions.im,
            SUM(fact_liv_lieux.carburant) as litrage,
        ')
            ->groupBy('camions.id')
            ->join('livraisons', 'camions.id = livraisons.cam_aller')
            ->join('fact_liv_lignes', 'fact_liv_lignes.id = livraisons.id_fact_ligne')
            ->join('fact_liv_lieux', 'fact_liv_lieux.id = fact_liv_lignes.id_lieu');
        if (!empty($y)) {
            $builder->where('YEAR(livraisons.date_aller)', $y);
        }
        if (!empty($m)) {
            $builder->where('MONTH(livraisons.date_aller)', $m);
        }
        if (!empty($d)) {
            $builder->where('DAY(livraisons.date_aller)', $d);
        }
        if (!empty($w)) {
            $builder->where('WEEK(livraisons.date_aller)', $w);
        }

        return $builder->find();
    }
}
