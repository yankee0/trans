<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Remorques as ModelsRemorques;

class Remorques extends BaseController
{
    public function get()
    {
        $id = $this->request->getVar('index');
        $occ = (new ModelsRemorques())
            ->where('id', $id)
            ->first();
        $this->response->setStatusCode(200);
        $this->response->setJSON($occ);
        $this->response->send();
    }
}
