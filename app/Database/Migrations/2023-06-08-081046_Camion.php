<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Camion extends Migration
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
            'im' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'societe' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'vt' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'as' => [
                'type' => 'DATE',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('im');
        $this->forge->createTable('camions',true);
    }

    public function down()
    {
        $this->forge->dropTable('camions',true);
    }
}
