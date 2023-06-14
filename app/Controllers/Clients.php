<?php

namespace App\Controllers;

use Exception;
use App\Controllers\BaseController;
use App\Models\Clients as ModelsClients;

class Clients extends BaseController
{
    public function list()
    {
        session()->p = 'clients';
        $modele = new ModelsClients();
        $data = [
            'count' => $modele->countAll(),
            'list' => $modele->paginate(25),
            'pager' => $modele->pager
        ];
        return view('clients/list', $data);
    }

    

    public function delete()
    {
        $data = $this->request->getVar();
        try {
            (new ModelsClients())->delete($data['id']);

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

    public function add()
    {
        $data = $this->request->getPost();
        $rules = [
            'email' => [
                'rules' => 'is_unique[clients.email]',
                'errors' => [
                    'is_unique' => 'Cet email existe déjà.'
                ]
            ],
            'tel' => [
                'rules' => 'is_unique[clients.tel,tel,]',
                'errors' => [
                    'is_unique' => 'Ce numéro de téléphone existe déjà.'
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
            $data['nom'] = ucwords($data['nom']);
            $data['mdp'] = APP_DEFAULT_PWD;
            try {
                (new ModelsClients())->insert($data);
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

    public function edit()
    {
        $data = $this->request->getPost();
        $u = (new ModelsClients())->find($data['id']);
        $rules = [
            'email' => [
                'rules' => 'is_unique[clients.email,email,' . $u['email'] . ']',
                'errors' => [
                    'is_unique' => 'Cet email existe déjà.'
                ]
            ],
            'tel' => [
                'rules' => 'is_unique[clients.tel,tel,' . $u['tel'] . ']',
                'errors' => [
                    'is_unique' => 'Ce numéro de téléphone existe déjà.'
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
            try {
                (new ModelsClients())->save($data);
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

    public function search(){
        $s = $this->request->getVar('search');
        if (empty($s)) {
            return redirect()->to(session()->r.'/clients');
        }
        $modele = new ModelsClients();
        $r = $modele
        ->like('nom',$s)
        ->orLike('profil',$s)
        ->orLike('tel',$s)
        ->orLike('email',$s)
        ->paginate(25);
        $data = [
            'count' => sizeof($r),
            'list' => $r,
            'pager' => $modele->pager,
            'search' => $s
        ];
        return view('clients/list', $data);
    }
}
