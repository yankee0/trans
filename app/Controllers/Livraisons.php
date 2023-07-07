<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Livraisons as ModelsLivraisons;

class Livraisons extends BaseController
{

    public function getLivs()
    {
        $model = new ModelsLivraisons();
        $data = $model
            ->select('
                livraisons.etat,
                fact_liv_lignes.conteneur,
                fact_liv_lignes.type,
                zones.nom AS zone,
                fact_liv_lieux.adresse,
                fact_liv_lieux.carburant,
                clients.nom AS nom_client,
                livraisons.created_at AS date_enregistrement,
                fact_liv.paiement,
                fact_liv.date_pg,
                fact_liv.preget,
                fact_liv.bl
            ')
            ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne','left')
            ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id','left')
            ->join('zones', 'zones.id = fact_liv_lieux.id_zone','left')
            ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact','left')
            ->join('clients', 'clients.id = fact_liv.id_client','left')
            ->where('fact_liv.date_pg !=', null)
            ->orderBy('fact_liv.paiement', 'DESC')
            ->paginate(10);
        $pager = $model->pager;
        return [
            'data' => $data,
            'pager' => $pager    
        ];
    }
}
