<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Camions;
use App\Models\Livraisons;
use App\Models\Utilisateurs;

class Cron extends BaseController
{
    /**
     * Deadline des TC
     */
    public function TCDeadline()
    {
        $modelTC = new Livraisons();
        $tcs = $modelTC
            // ->select('
            //     fact_liv_lignes.conteneur,
            //     fact_liv_lignes.type,
            //     fact_liv.date_pg,
            //     fact_liv.deadline,
            //     fact_liv_lieux.designation,
            //     clients.nom as client,
            //     fact_liv.date_creation,
            //     fact_liv.paiement,
            //     fact_liv.date_paiement,
            // ')
            ->join('fact_liv_lignes', 'fact_liv_lignes.id = id_fact_ligne', 'left')
            ->join('fact_liv_lieux', 'fact_liv_lignes.id_lieu = fact_liv_lieux.id', 'left')
            ->join('fact_liv', 'fact_liv.id = fact_liv_lieux.id_fact', 'left')
            ->join('clients', 'clients.id = fact_liv.id_client', 'left')
            ->where('fact_liv.annulation', 'NON')
            ->where('fact_liv.deadline !=', null)
            ->where('fact_liv.deadline !=', "0000-00-00")
            ->where('fact_liv.pregate','OUI')
            ->where('fact_liv.deadline <=', date('Y-m-d', strtotime('+2 days')))
            ->where('livraisons.etat !=', 'LIVRÉ')
            ->where('livraisons.etat !=', 'EN COURS')
            ->where('livraisons.etat !=', 'ANNULÉ')
            ->orderBy('fact_liv.deadline', 'ASC')
            ->countAllResults();
        if ($tcs > 0) {
            $uModel = new Utilisateurs();
            $us = $uModel
                ->where('profil', 'ADMIN')
                ->orWhere('profil', 'OPS')
                ->orWhere('profil', 'OPS TERRAIN')
                ->find();

            return (new Mailer)->sendTCDealineMail($us, $tcs);
        } else {
            return 'R.A.S.';
        }
    }

    /**
     * Alerts visites techniques
     */
    public function VtAs()
    {
        // $as = (new Camions())
        //     ->where('as !=', null)
        //     ->where('as <=', date('Y-m-d', strtotime('+5 days')))
        //     ->find();
        $vt = (new Camions())
            ->where('vt !=', null)
            ->where('vt <=', date('Y-m-d', strtotime('+5 days')))
            ->find();

        $data = [
            // 'as' => $as,
            'vt' => $vt,
        ];

        if (!empty($data['vt'])) {

            $users = (new Utilisateurs())
                ->where('profil', 'ADMIN')
                ->orWhere('profil', 'OPS')
                ->orWhere('profil', 'OPS TERRAIN')
                ->orWhere('profil', 'FLOTTE')
                ->find();
            return (new Mailer)->sendVTASMail($users, $data);
        } else {
            return "RAS.";
        }
    }
}
