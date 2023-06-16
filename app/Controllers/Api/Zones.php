<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Zones as ModelsZones;

class Zones extends BaseController
{
    public function get()
    {
        $id = $this->request->getVar('index');
        $occ = (!empty($id)) ? (new ModelsZones())->find($id) : (new ModelsZones())->findAll();
        $this->response->setStatusCode(200);
        $this->response->setJSON($occ);
        $this->response->send();
    }
}
