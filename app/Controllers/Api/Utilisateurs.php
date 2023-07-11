<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Utilisateurs as ModelsUtilisateurs;

class Utilisateurs extends BaseController
{
    public function get()
    {
        $id = $this->request->getVar('index');
        $occ = (new ModelsUtilisateurs())
            ->where('id', $id)
            ->find();
        $this->response->setStatusCode(200);
        $this->response->setJSON($occ);
        $this->response->send();
    }
}
