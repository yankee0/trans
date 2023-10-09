<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RavAppro extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'montant' => [
                'type' => 'DOUBLE',
                'null' => true,
                'default' => 0
            ],
            'auteur' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('rav_appro');
    }

    public function down()
    {
        $this->forge->dropTable('rav_appro');
    }
}
