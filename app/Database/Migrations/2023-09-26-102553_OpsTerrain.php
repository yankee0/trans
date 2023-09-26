<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OpsTerrain extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('utilisateurs', [
            'profil' => [
                'type' => 'ENUM("ADMIN","FACTURATION","FINANCE","FLOTTE","OPS","OPS TERRAIN")',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('utilisateurs', [
            'profil' => [
                'type' => 'ENUM("ADMIN","FACTURATION","FINANCE","FLOTTE","OPS","OPS TERRAIN")',
                'null' => true,
            ],
        ]);
    }
}
