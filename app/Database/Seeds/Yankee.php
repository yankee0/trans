<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class Yankee extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nom' => 'Yankee',
                'profil' => 'ADMIN',
                'tel' => '776998882',
                'email' => 'yankee@poly-trans.sn',
                'mdp' => sha1('yankee')
            ],
            [
                'nom' => 'Yankee',
                'profil' => 'FACTURATION',
                'tel' => '776998883',
                'email' => 'facturation@poly-trans.sn',
                'mdp' => sha1('yankee')
            ],
            [
                'nom' => 'Yankee',
                'profil' => 'FINANCE',
                'tel' => '776998884',
                'email' => 'finance@poly-trans.sn',
                'mdp' => sha1('yankee')
            ],
        ];

        
        $this->db->table('utilisateurs')->insertBatch($data);

        

    }
}
