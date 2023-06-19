<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Chauffeurs extends Migration
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
            'tel' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'societe' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'camion' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'default' => null
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('tel');
        $this->forge->addForeignKey('camion','camions','id','CASCADE','SET NULL');
        $this->forge->createTable('chauffeurs',true);
    }

    public function down()
    {
        $this->forge->dropTable('chauffeurs',true);
    }
}
