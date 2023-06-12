<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Utilisateurs as ModelsUtilisateurs;
use Exception;

class Utilisateurs extends BaseController
{
    public function modifier_mdp()
    {
        $rules = [
            'mdp' => [
                'rules' => 'min_length[7]',
                'errors' => [
                    'min_length' => 'Le mot de passe doit comporter au moins 7 caractères.'
                ],
            ],
            'mdpc' => [
                'rules' => 'matches[mdp]',
                'errors' => [
                    'matches' => 'Les mots de passe saisis sont différents.'
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
            $data = $this->request->getPost();
            $data['mdp'] = sha1($data['mdp']);
            $modele = new ModelsUtilisateurs();
            if (!$modele
                ->where(
                    [
                        'id' => session()->u['id'],
                        'mdp' => sha1($data['mdpa'])
                    ]
                )->find()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('n', false)
                    ->with('m', 'Mot de passe incorrect.');
            } else {
                try {
                    $modele->save($data);
                } catch (\Throwable $th) {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->with('n', false)
                        ->with('m', 'Une erreur est survenue lors de la modification du mot de passe.');
                }
                return redirect()
                    ->back()
                    ->with('n', true)
                    ->with('m', 'Mot de passe modifié.');
            }
        }
    }

    public function list()
    {
        session()->p = 'utilisateurs';
        $modele = new ModelsUtilisateurs();
        $data = [
            'count' => $modele->countAll(),
            'list' => $modele->paginate(100),
            'pager' => $modele->pager
        ];
        return view('utilisateurs/list', $data);
    }

    public function delete()
    {
        $data = $this->request->getVar();
        try {
            (new ModelsUtilisateurs())->delete($data);
            if (in_array(session()->u['id'],$data)) {
                return redirect()->to('deconnexion');
            }
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
                'rules' => 'is_unique[utilisateurs.email]',
                'errors' => [
                    'is_unique' => 'Cet email existe déjà.'
                ]
            ],
            'tel' => [
                'rules' => 'is_unique[utilisateurs.tel,tel,]',
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
                (new ModelsUtilisateurs())->insert($data);
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
                ->with('m', 'Ajout réussie.');
        }
    }
}
