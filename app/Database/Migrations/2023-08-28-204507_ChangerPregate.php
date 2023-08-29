<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ChangerPregate extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('fact_liv', [
            'pregate' => [
                'name' => 'pregate',
                'type' => 'VARCHAR',
                'constraint' => 255, // Ajustez la contrainte en fonction de votre structure
            ]
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('fact_liv', [
            'pregate' => [
                'name' => 'pregate',
                'type' => 'VARCHAR',
                'constraint' => 255, // Ajustez la contrainte en fonction de votre structure
            ]
        ]);
    }
}
