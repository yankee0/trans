<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Livraisons;
use App\Models\Utilisateurs;

class Cron extends BaseController
{
    public function TCDeadline()
    {
        $modelTC = new Livraisons();
        $tcs = $modelTC
            ->select('
                fact_liv_lignes.conteneur,
                fact_liv_lignes.type,
                fact_liv.date_pg,
                fact_liv.deadline,
                fact_liv_lieux.designation,
                clients.nom as client,
                fact_liv.date_creation,
                fact_liv.paiement,
                fact_liv.date_paiement,
            ')
            ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
            ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
            ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
            ->join('clients', 'clients.id = fact_liv.id_client', 'left')
            ->where('fact_liv.annulation', 'NON')
            ->where('fact_liv.deadline' , date('Y-m-d', strtotime('+2 days')))
            ->where('livraisons.etat !=','LIVRÉ')
            ->where('livraisons.etat !=' , 'ANNULÉ')
            ->where('livraisons.etat !=' , 'EN COURS')
            ->orderBy('fact_liv.deadline', 'ASC')
            ->find();
        if (!empty($tcs)) {
            $uModel = new Utilisateurs();
            $us = $uModel
                ->where('profil', 'ADMIN')
                ->orWhere('profil', 'OPS')
                ->find();

            return (new Mailer)->sendTCDealineMail($us, $tcs);
        } else {
            return 'R.A.S.';
        }
    }
}
