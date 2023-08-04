<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cartes extends Migration
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
            'nom' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'solde' => [
                'type' => 'FLOAT',
                'constraint' => 11,
                'null' => true,
                'default' => 0.00
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('cartes');
    }

    public function down()
    {
        $this->forge->dropTable('cartes',true);
    }
}
