<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Camions as ModelsCamions;

class Camions extends BaseController
{

    public function get()
    {
        $id = $this->request->getVar('index');
        $occ = (new ModelsCamions())
            ->where('id', $id)
            ->find();
        $this->response->setStatusCode(200);
        $this->response->setJSON($occ);
        $this->response->send();
    }
}
