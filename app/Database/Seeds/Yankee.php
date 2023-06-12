<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class Yankee extends Seeder
{
    public function run()
    {
        $profiles = ["ADMIN","FACTURATION","CONTROLE","TRANSPORT","FINANCE","FLOTTE"];
        $data[] = [];
        $data[0] = [
            'nom' => 'Yankee',
            'profil' => 'ADMIN',
            'tel' => '776998882',
            'email' => 'yankee@poly-trans.sn',
            'mdp' => sha1('yankee')
        ];
        $faker = Factory::create();
        for ($i=1; $i < 100; $i++) { 
            $data[$i] = [
                'nom' => $faker->name(),
                'profil' => array_rand($profiles),
                'email' => $faker->email(),
                'tel' => $faker->phoneNumber(),
                'mdp' => sha1('yankee'),
            ];
        }
        $this->db->table('utilisateurs')->insertBatch($data);

        $zones[] = [];
        $tva = [
            '18','0' 
        ];
        for ($i=0; $i < 100; $i++) { 
            $zones[$i] = [
                'nom' => $faker->address(),
                'tva' => array_rand($tva),
                'ht_20' => $faker->numberBetween(100000,300000),
                'ht_40' => $faker->numberBetween(100000,300000),
                'carburant' => $faker->numberBetween(20,400),
            ];
        }

        $this->db->table('zones')->insertBatch($zones);
    }
}
