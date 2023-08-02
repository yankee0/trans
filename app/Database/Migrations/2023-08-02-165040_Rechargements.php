<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rechargements extends Migration
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
            'carte' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'utilisateur' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'montant' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
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
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('carte','cartes','id','CASCADE','SET NULL');
        $this->forge->addForeignKey('utilisateur','utilisateurs','id','CASCADE','SET NULL');
        $this->forge->createTable('rechargements');
    }

    public function down()
    {
        $this->forge->dropTable('rechargements');
    }
}
