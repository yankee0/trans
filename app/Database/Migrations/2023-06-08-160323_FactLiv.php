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
                // 'auto_increment' => true,
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
            'amendement' => [
                'type' => 'ENUM("OUI","NON")',
                'default' => 'NON',
                'null' => true,
            ],
            'compagnie' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'reglement' => [
                'type' => 'ENUM("NON PAYÉ","PAR CHÈQUE","EN ESPÈCES","À CRÉDIT")',
                'null' => true,
                'default' => 'NON PAYÉ'
            ],
            'paiement' => [
                'type' => 'VARCHAR',
                'type' => 'ENUM("NON","OUI")',
                'null' => true,
                'default' => 'NON'
            ],
            'montant_encaissement' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'default' => 0,
                'null' => true,
            ],
            'ages' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'default' => 0,
                'null' => true,
            ],
            'hammar' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'default' => 0,
                'null' => true,
            ],
            'copie' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'default' => 0,
                'null' => true,
            ],
            'date_paiement' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'date_creation' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'preget' => [
                'type' => 'ENUM("OUI","NON")',
                'null' => true,
                'default' => "NON"
            ],
            'date_pg' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'annulation' => [
                'type' => 'ENUM("OUI","NON")',
                'default' => 'NON',
                'null' => true,
            ],
            'motif' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
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
        $this->forge->addUniqueKey('id');
        $this->forge->addUniqueKey('bl');
        $this->forge->addForeignKey('id_client', 'clients', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('fact_liv', true);
    }

    public function down()
    {
        $this->forge->dropTable('fact_liv', true);
    }
}
