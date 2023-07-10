<?php

namespace App\Controllers;

use Exception;
use App\Controllers\BaseController;
use App\Models\Remorques as ModelsRemorques;

class Remorques extends BaseController
{
    public function list()
    {
        session()->p = 'remorques';
        $modele = new ModelsRemorques();
        $data = [
            'count' => $modele->countAll(),
            'list' => $modele->paginate(25),
            'pager' => $modele->pager
        ];
        return view('remorques/list', $data);
    }

    public function delete()
    {
        $data = $this->request->getVar();
        try {
            (new ModelsRemorques())->delete($data['id']);
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
        $u = (new ModelsRemorques())->find($data['id']);
        $rules = [
            'im' => [
                'rules' => 'is_unique[remorques.im,im,' . $u['im'] . ']',
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
                (new ModelsRemorques())->save($data);
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
                'rules' => 'is_unique[remorques.im]',
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
                (new ModelsRemorques())->insert($data);
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
            return redirect()->to(session()->r . '/remorques');
        }
        $modele = new ModelsRemorques();
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
        return view('remorques/list', $data);
    }
}
