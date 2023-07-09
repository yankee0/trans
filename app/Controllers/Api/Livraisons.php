<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Livraisons as ModelsLivraisons;

class Livraisons extends BaseController
{
    public function get()
    {
        $modele = new ModelsLivraisons();
        $res = $modele->find($this->request->getVar('id'));
        $this->response->setJSON($res);
        $this->response->send();
    }
}
