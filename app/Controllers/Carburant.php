<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Carte;
use App\Models\Rechargement;

class Carburant extends BaseController
{
    public function index()
    {
        session()->p = 'carburant';

        return view('carburant/index', [
            'carte' => (new Carte())->first(),
            'lastRec' => (new Rechargement())
                ->select('montant, utilisateurs.nom, rechargements.created_at')
                ->orderBy('created_at', 'DESC')
                ->join('utilisateurs', 'utilisateurs.id = utilisateur')
                ->first()
        ]);
    }

    public function recharge()
    {

        //recharge
        $data = $this->request->getPost();
        $data['carte'] = 1;
        $data['utilisateur'] = session()->u['id'];
        (new Rechargement())->save($data);

        //mise à jour du solde
        $carte = (new Carte())->first();
        $carte['solde'] += $data['montant'];
        (new Carte())->save($carte);


        return redirect()
            ->back()
            ->with('n', true)
            ->with('m', 'Nouvelle recharge de ' . $data['montant'] . ' FCFA enregistrée.');
    }
}
