<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Clients as ModelsClients;

class Clients extends BaseController
{
    public function get()
    {
        $id = $this->request->getVar('index');
        $occ = (new ModelsClients())
            ->findAll();
        $this->response->setStatusCode(200);
        $this->response->setJSON($occ);
        $this->response->send();
    }
}
