<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Livraisons as ModelsLivraisons;

class Livraisons extends BaseController
{
    public function get()
    {
        $modele = new ModelsLivraisons();
        $id = $this->request->getVar('id');
        $res = $modele
            ->where('id', $id)
            ->find();
        $this->response->setJSON($res);
        $this->response->send();
    }
}
