<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Comments extends Migration
{
    public function up()
    {
        $this->forge->addColumn('camions', [
            'commentaire' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
        $this->forge->addColumn('remorques', [
            'commentaire' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('camions');
        $this->forge->dropTable('remorques');
    }
}
