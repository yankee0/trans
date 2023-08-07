<?php

namespace App\Controllers;

use Exception;
use App\Controllers\BaseController;
use App\Models\Camions;
use App\Models\Chauffeurs as ModelsChauffeurs;

class Chauffeurs extends BaseController
{
    public function list()
    {
        session()->p = 'chauffeurs';
        $modele = new ModelsChauffeurs();
        $list = $modele->findAll();
        for ($i = 0; $i < sizeof($list); $i++) {
            if (!empty($list[$i]['camion'])) {
                $l = (new Camions())->find($list[$i]['camion']);
                if ($l) {
                    $list[$i]['camion'] = $l['im'];
                    $list[$i]['camion_id'] = $l['id'];
                }
            }else{
                $list[$i]['camion'] = null;
                $list[$i]['camion_id'] = null;
            }
        }
        $data = [
            'count' => $modele->countAll(),
            'list' => $list,
            'cam' => (new Camions())->orderBy('im')->findAll()
        ];
        return view('chauffeurs/list', $data);
    }

    public function delete($id = null)
    {
        $data = empty($id) ? $this->request->getVar() : ['id' => $id];
        try {
            (new ModelsChauffeurs())->delete($data['id']);
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
        $u = (new ModelsChauffeurs())->find($data['id']);
        $rules = [
            'tel' => [
                'rules' => 'is_unique[chauffeurs.tel,tel,' . $u['tel'] . ']',
                'errors' => [
                    'is_unique' => 'Numéro de téléphone en doublons.'
                ],
            ],
        ];
        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('n', false)
                ->with('m', '<br />' . $this->validator->listErrors());
        } else {
            try {
                if (empty($data['camion'])) {
                    $data['camion'] = null;
                }
                (new ModelsChauffeurs())->save($data);
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
            'tel' => [
                'rules' => 'is_unique[chauffeurs.tel]',
                'errors' => [
                    'is_unique' => 'Numéro de téléphone en doublons.'
                ],
            ],
        ];
        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('n', false)
                ->with('m', '<br />' . $this->validator->listErrors());
        } else {
            try {
                $data['nom'] = ucwords($data['nom']);
                if (empty($data['camion'])) {
                    unset($data['camion']);
                }
                (new ModelsChauffeurs())->insert($data);
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
            return redirect()->to(session()->r . '/chauffeurs');
        }
        $modele = new ModelsChauffeurs();
        $r = $modele
            ->like('nom', $s)
            ->orLike('tel', $s)
            ->orLike('societe', $s)
            ->orLike('camion', $s)
            ->paginate(25);
        for ($i = 0; $i < sizeof($r); $i++) {
            if (!empty($r[$i]['camion'])) {
                $l = (new Camions())->find($r[$i]['camion']);
                if ($l) {
                    $r[$i]['camion'] = $l['im'];
                }
            }
        }
        $data = [
            'count' => sizeof($r),
            'list' => $r,
            'pager' => $modele->pager,
            'cam' => (new Camions())->orderBy('im')->findAll(),
            'search' => $s
        ];
        return view('chauffeurs/list', $data);
    }
}
