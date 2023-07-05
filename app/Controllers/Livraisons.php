<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FactLiv;
use App\Models\FactLivLieux;
use App\Models\Livraisons as ModelsLivraisons;

class Livraisons extends BaseController
{

    public function getLivs($search = '')
    {

        $builder = new ModelsLivraisons();
        $builder->select('*');
        $builder->join('fact_liv_lignes', 'fact_liv_lignes.id = livraisons.id_fact_ligne');
        $query = $builder->get();
        $data = $query->getResult();

        // return dd($data);

        for ($i = 0; $i < sizeof($data); $i++) {
            $builder = new FactLivLieux();
            $builder->find($data[$i]->id_lieu);
            $builder->select('*');
            $builder->join('zones', 'zones.id = fact_liv_lieux.id_zone');
            $builder->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact');
            $query = $builder->get();
            $data[$i]->info = $query->getResult();
        }

        return dd($data);
    }
}
