<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FactLivLignes extends Migration
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
            'id_lieu' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'designation' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'conteneur' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'type' => [
                'type' => 'ENUM("20","40")',
                'null' => true,
            ],
            'prix' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_lieu', 'fact_liv_lieux', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('fact_liv_lignes', true);
    }

    public function down()
    {
        $this->forge->dropTable('fact_liv_lignes', true);
    }
}
