<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Carte;
use App\Models\Ravitaillement;
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
                ->first(),
            'ravs' => (new Ravitaillement())->orderBy('created_at', 'DESC')->findAll()
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

    public function ravitaillement()
    {
        //ravitaillement
        $data = $this->request->getPost();
        $data['carte'] = 1;
        $data['auteur'] = session()->u['nom'];
        (new Ravitaillement())->save($data);

        //debiter la carte
        $carte = (new Carte())->first();
        $prix = $data['type_carb'] == 'ESSENCE' ? 990 : 755;
        $debit = $data['litres'] * $prix;
        $carte['solde'] -= $debit;
        (new Carte())->save($carte);


        return redirect()
            ->back()
            ->with('n', true)
            ->with('m', 'Ravitaillement de ' . $debit . 'FCFA enregistré et débité sur la carte.');
    }

    public function supRav($id)
    {

        // calculer le montant à rendre apres supprimer le ravitaillent
        $rav = (new Ravitaillement())->find($id);
        $prix = $rav['type_carb'] == 'ESSENCE' ? 990 : 755;
        $solde = $rav['litres'] * $prix;
        (new Ravitaillement())->delete($id);

        //mise à jour du solde
        $carte = (new Carte())->first();
        $carte['solde'] += $solde;
        (new Carte())->save($carte);

        return redirect()
            ->back()
            ->with('n', true)
            ->with('m', 'Suppression réussie, ' . $solde . ' FCFA retournés à la carte.');
    }
}
