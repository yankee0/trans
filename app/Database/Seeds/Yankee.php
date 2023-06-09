<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Yankee extends Seeder
{
    public function run()
    {
        $this->db->table('utilisateurs')->insertBatch([
            'nom' => 'Yankee',
            'profil' => 'ADMIN',
            'email' => 'yankee@poly-trans.sn',
            'mdp' => sha1('yankee')
        ]);
    }
}
