<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Zones extends Migration
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
            'ht_liv_20' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'default' => 0
            ],
            'ham_20' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'default' => 0
            ],
            'ht_liv_40' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'default' => 0
            ],
            'ham_40' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'default' => 0
            ],
            'carburant' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'default' => 0
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('zones',true);
    }

    public function down()
    {
        $this->forge->dropTable('zones',true);
    }
}
