<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Utilisateurs;

class Auth extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function login()
    {
        $data = $this->request->getPost();
        $data['mdp'] = sha1($data['mdp']);
        $modele = new Utilisateurs();
        $occ = $modele
            ->where($data)
            ->first();
        if (!$occ) {
            return redirect()
                ->back()
                ->withInput()
                ->with('n', false)
                ->with('m', 'Identifiants incorrectes');
        } else {
            unset($occ['mdp']);
            session()->set('u', $occ);
            session()->set('p','dashboard');
            switch (session()->u['profil']) {
                case 'ADMIN':
                    session()->set('r', 'admin');
                    return redirect()->to(session()->r);
                    break;

                default:
                    return redirect()
                        ->back()
                        ->withInput()
                        ->with('n', false)
                        ->with('m', 'Profil incorrect, merci de le signaler à la section IT.');
                    break;
            }
        }
    }

    public function logout(){
        session()->remove('u');
        session()->remove('r');
        return redirect()->to('/');
    }
}
