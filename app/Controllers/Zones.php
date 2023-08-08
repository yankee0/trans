<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Zones as ModelsZones;
use Exception;

class Zones extends BaseController
{
    public function list()
    {
        session()->p = 'zones';
        $modele = new ModelsZones();
        $data = [
            'count' => $modele->countAll(),
            'list' => $modele->paginate(25),
            'pager' => $modele->pager
        ];
        return view('zones/list', $data);
    }

    public function delete($id = null)
    {
        $data = empty($id) ? $this->request->getVar() : ['id' => $id];
        try {
            (new ModelsZones())->delete($data['id']);
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
        try {
            $data['nom'] = strtoupper($data['nom']);
            (new ModelsZones())->save($data);
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

    public function add()
    {
        $data = $this->request->getPost();
        try {
            $data['nom'] = strtoupper($data['nom']);
            (new ModelsZones())->insert($data);
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

    public function search(){
        $data = $this->request->getGet();
        $s = isset($data['search']) ? $data['search'] : '%';
        if (empty($s)) {
            return redirect()->to(session()->r.'/zones');
        }
        $modele = new ModelsZones();
        $r = $modele
        ->like('nom',$s)
        ->paginate(25);
        $data = [
            'count' => sizeof($r),
            'list' => $r,
            'pager' => $modele->pager,
            'search' => $s
        ];
        return view('zones/list', $data);
    }
}
