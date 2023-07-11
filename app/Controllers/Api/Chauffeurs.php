<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Chauffeurs as ModelsChauffeurs;

class Chauffeurs extends BaseController
{
    public function get()
    {
        $id = $this->request->getVar('index');
        $occ = (new ModelsChauffeurs())
        ->where('id',$id)
        ->first();
        $this->response->setStatusCode(200);
        $this->response->setJSON($occ);
        $this->response->send();
    }
}
