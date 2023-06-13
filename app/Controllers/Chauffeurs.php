<?php

namespace App\Controllers;

use Exception;
use App\Controllers\BaseController;
use App\Models\Chauffeurs as ModelsChauffeurs;

class Chauffeurs extends BaseController
{
    public function list()
    {
        session()->p = 'chauffeurs';
        $modele = new ModelsChauffeurs();
        $data = [
            'count' => $modele->countAll(),
            'list' => $modele->paginate(25),
            'pager' => $modele->pager
        ];
        return view('chauffeurs/list', $data);
    }

    public function delete()
    {
        $data = $this->request->getVar();
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
                'rules' => 'is_unique[chauffeurs.tel,tel,'.$u['tel'].']',
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
                    unset($data['camion']);
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
        $s = $this->request->getVar('search');
        if (empty($s)) {
            return redirect()->to(session()->r . '/chauffeurs');
        }
        $modele = new ModelsChauffeurs();
        $r = $modele
            ->like('nom', $s)
            ->paginate(25);
        $data = [
            'count' => sizeof($r),
            'list' => $r,
            'pager' => $modele->pager,
            'search' => $s
        ];
        return view('chauffeurs/list', $data);
    }
}
