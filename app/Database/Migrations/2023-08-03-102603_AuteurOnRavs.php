<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AuteurOnRavs extends Migration
{
    public function up()
    {
        $this->forge->addColumn('ravitaillements', [
            'auteur' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('ravitaillements','auteur');
    }
}
