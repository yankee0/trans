<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FactLiv extends Migration
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
            'id_client' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'consignataire' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'bl' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'compagnie' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'reglement' => [
                'type' => 'ENUM("NON PAYÉ","COMPTANT","À CRÉDIT")',
                'null' => true,
                'default' => 'NON PAYÉ'
            ],
            'paiement' => [
                'type' => 'VARCHAR',
                'type' => 'ENUM("NON","OUI")',
                'null' => true,
                'default' => 'NON'
            ],
            'date_paiement' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'date_creation' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_client','clients','id','CASCADE','SET NULL');
        $this->forge->createTable('fact_liv',true);
    }

    public function down()
    {
        $this->forge->dropTable('fact_liv',true);
    }
}
