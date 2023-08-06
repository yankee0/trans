<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Data extends Seeder
{
    public function run()
    {

        for ($i=0; $i < 100; $i++) { 
            $rechargements[] = [
                'montant' => rand(10000,300000),
                'utilisateur' => 1
            ];
        }
        $this->db->table('rechargements')->insertBatch($rechargements);
    }
}
