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
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('n', false)
                ->with('m', 'Une erreur est survenue lors de la suppression: <br />'.$e->getMessage());
        }
        return redirect()
            ->back()
            ->with('n', true)
            ->with('m', 'Suppression réussie.');
    }

    public function add()
    {
        $data = $this->request->getPost();
        $data['nom'] = strtoupper($data['nom']);
        try {
            (new ModelsClients())->insert($data);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('n', false)
                ->with('m', '<br />'.$e->getMessage());
        }
        return redirect()
            ->back()
            ->with('n', true)
            ->with('m', 'Ajout réussi.');
    }

    public function edit()
    {
        $data = $this->request->getPost();
        // dd($data);
        try {
            $data['nom'] = strtoupper($data['nom']);
            (new ModelsClients())->update($data['idmod'], $data);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('n', false)
                ->with('m', '<br />'.$e->getMessage());
        }
        return redirect()
            ->back()
            ->with('n', true)
            ->with('m', 'Modification réussie.');
    }

    public function search()
    {
        $data = $this->request->getGet();
        $s = isset($data['search']) ? $data['search'] : '%';
        if (empty($s)) {
            return redirect()->to(session()->r.'/clients');
        }
        $modele = new ModelsClients();
        $r = $modele
            ->like('id', $s)
            ->orLike('nom', $s)
            ->orLike('tel', $s)
            ->orLike('email', $s)
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
