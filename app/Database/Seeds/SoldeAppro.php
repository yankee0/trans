<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SoldeAppro extends Seeder
{
    public function run()
    {
        $this->db->table('compte_appro')->insertBatch([
            'id' => 1,
        ]);
    }
}
