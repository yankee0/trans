<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImg extends Migration
{
    public function up()
    {
        $this->forge->addColumn('appro', [
            'img' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'unique' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('appro', ['img']);
    }
}
