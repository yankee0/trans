<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Card extends Seeder
{
    public function run()
    {
        $this->db->table('cartes')->insertBatch([
            'nom' => 'Carte de ravitaillement carburant',
            'solde' => 0
        ]);
    }
}
