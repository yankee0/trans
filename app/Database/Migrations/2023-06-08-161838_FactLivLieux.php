<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FactLivLieux extends Migration
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
            'id_fact' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'id_zone' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'adresse' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'carburant' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'default' => 0
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_fact','fact_liv','id','CASCASE','CASCADE');
        $this->forge->addForeignKey('id_zone','fact_liv','id','CASCASE','SET NULL');
        $this->forge->createTable('fact_liv_lieux',true);
    }
    
    public function down()
    {
        $this->forge->dropTable('fact_liv_lieux',true);
    }
}
