<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ApproModel;
use App\Models\CompteAppro;
use App\Models\RavApproModel;

class Appro extends BaseController
{
    public function index()
    {
        return view('appro/index', [
            'carte' => (new CompteAppro())->first(),

            'recs' => (new RavApproModel())
                ->orderBy('DATE(date)', 'desc')
                ->find(),

            'ravs' => (new ApproModel())
                ->orderBy('DATE(date)', 'desc')
                ->find()
        ]);
    }

    public function recharge()
    {
        $data = $this->request->getPost();
        $data['auteur'] = session()->u['nom'];

        $modelRecharge = new RavApproModel();
        $modelRecharge->save($data);

        $modelCompte = new CompteAppro();
        $compte = $modelCompte->first();
        $compte['solde'] = $compte['solde'] + $data['montant'];
        $modelCompte->save($compte);

        return redirect()
            ->back()
            ->with('n', true)
            ->with('m', 'Nouvelle recharge de ' . $data['montant'] . ' FCFA enregistrée.');
    }
}
