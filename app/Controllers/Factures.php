<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FactLiv as ModelsFactLiv;

class Factures extends BaseController
{
    public function dashboard()
    {
        session()->p = 'factures';

        $data = $this->request->getGet();
        $s = isset($data['search']) ? $data['search'] : '%';
        $modele = new ModelsFactLiv();
        $r = $modele
            ->select('fact_liv.*, clients.nom')
            ->join('clients', 'clients.id = fact_liv.id_client')
            ->like('fact_liv.id', $s)
            ->orLike('fact_liv.bl', $s)
            ->orLike('compagnie', $s)
            ->orLike('clients.nom', $s)
            ->orWhere('UNIX_TIMESTAMP(fact_liv.date_creation)', strtotime($s))
            ->orderBy('fact_liv.date_creation', 'desc')
            ->paginate(20);
        for ($i = 0; $i < sizeof($r); $i++) {
            $r[$i] = (new Facturations)->FactLivInfos($r[$i]);
        }
        $data = [
            'r' => $r,
            'pager' => $modele->pager,
            'search' => $s
        ];

        return view('facturation/livraisons/search', $data);
    }

    protected function setFees(array $data)
    {
        if (!empty($data)) {
            for ($i = 0; $i < sizeof($data); $i++) {
                if ($data[$i]['avec_tva'] == 'OUI') {
                    $data[$i]['total'] += ($data[$i]['total'] * 18 / 100);
                }
                if ($data[$i]['avec_ages'] == 'OUI') {
                    $data[$i]['total'] += ($data[$i]['tcs'] * 1500);
                }
                if ($data[$i]['avec_copie'] == 'OUI') {
                    $data[$i]['total'] += 500;
                }
            }
        }

        return $data;
    }
}
