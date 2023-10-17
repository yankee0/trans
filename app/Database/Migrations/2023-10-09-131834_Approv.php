<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Approv extends Migration
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
            'date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'nature' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'auteur' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'montant' => [
                'type' => 'DOUBLE',
                'null' => true,
                'default' => 0
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('appro');
    }

    public function down()
    {
        $this->forge->dropTable('appro');
    }
}
