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
            
            'recs' => (new Rechargement())
                ->select('rechargements.*, utilisateurs.nom')
                ->join('utilisateurs', 'utilisateur = utilisateurs.id')
                ->orderBy('DATE(rechargements.created_at)', 'desc')
                ->find(),

            'ravs' => (new Ravitaillement())
                ->orderBy('DATE(ravitaillements.created_at)', 'desc')
                ->find()
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
        $data['imm'] = strtoupper($data['imm']);
        $data['prix_litre'] = $prix = $data['type_carb'] == 'ESSENCE' ? 990 : 755;
        (new Ravitaillement())->save($data);

        //debiter la carte
        $carte = (new Carte())->first();
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

    public function modRav()
    {
        $data = $this->request->getPost();
        $data['imm'] = strtoupper($data['imm']);


        //l'ancien montant
        $ancien_montant = (new Ravitaillement())->find($data['id'])['litres'] * (new Ravitaillement())->find($data['id'])['prix_litre'];
        $solde = (new Carte())->first()['solde'];
        (new Carte())->save([
            'id' => 1,
            'solde' => $solde + $ancien_montant
        ]);

        //le nouveau montant
        $data['prix_litre'] = $prix = $data['type_carb'] == 'ESSENCE' ? 990 : 755;
        $nouveau_montant = $data['litres'] * $data['prix_litre'];
        $solde = (new Carte())->first()['solde'];
        (new Carte())->save([
            'id' => 1,
            'solde' => $solde - $nouveau_montant
        ]);

        // Enregistrement
        (new Ravitaillement())->save($data);

        return redirect()
            ->back()
            ->with('n', true)
            ->with('m', 'Modification réussie.');
    }
}
