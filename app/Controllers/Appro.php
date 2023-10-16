<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ApproModel;
use App\Models\CompteAppro;
use App\Models\RavApproModel;
use CodeIgniter\Files\File;

class Appro extends BaseController
{

    public function __construct()
    {
        session()->p = 'approvisionnements';
    }

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

    public function appro()
    {
        $img = $this->request->getFile('img');
        $data = $this->request->getPost();
        //Record file
        if ($img->getSize() > 0) {
            $img->move(ROOTPATH . '/public/images/approvisionnements');
            $data['img'] = $img->getName();
        }
        $data['auteur'] = session()->u['nom'];

        $modelAppro = new ApproModel();
        $modelAppro->save($data);

        $modelCompte = new CompteAppro();
        $compte = $modelCompte->first();
        $compte['solde'] = $compte['solde'] - $data['montant'];
        $modelCompte->save($compte);

        return redirect()
            ->back()
            ->with('n', true)
            ->with('m', 'Nouvel approvision de ' . $data['montant'] . 'FCFA enregistré.');
    }

    public function modifierAppro()
    {
        $data = $this->request->getPost();
        //Record file
        $img = $this->request->getFile('img');
        if ($img->getSize() > 0) {
            $img->move(ROOTPATH . '/public/images/approvisionnements');
            $data['img'] = $img->getName();
        }
        $data['auteur'] = session()->u['nom'];

        $modelAppro = new ApproModel();
        $anc_appro = $modelAppro->find($data['id']);

        $modelCompte = new CompteAppro();
        $compte = $modelCompte->first();
        $compte['solde'] = $compte['solde'] + $anc_appro['montant'] - $data['montant'];
        $modelCompte->save($compte);

        $modelAppro->save($data);

        return redirect()
            ->back()
            ->with('n', true)
            ->with('m', 'Modification approvision de ' . $data['montant'] . 'FCFA enregistrée.');
    }

    public function supprimerAppro()
    {
        $data = $this->request->getPost();

        $modelAppro = new ApproModel();
        $anc_appro = $modelAppro->find($data['id']);

        $modelCompte = new CompteAppro();
        $compte = $modelCompte->first();
        $compte['solde'] = $compte['solde'] + $anc_appro['montant'];
        $modelCompte->save($compte);

        $modelAppro->delete($data['id']);
        return redirect()
            ->back()
            ->with('n', true)
            ->with('m', 'Suppression approvision de ' . $anc_appro['montant'] . 'FCFA.');
    }
}
