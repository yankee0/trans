<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Utilisateurs extends Migration
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
            'profil' => [
                'type' => 'ENUM("ADMIN","FACTURATION","CONTROLE","TRANSPORT","FINANCE","FLOTTE")',
                'null' => true,
            ],
            'tel' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'mdp' => [
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
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('tel');
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('utilisateurs',true);
    }

    public function down()
    {
        $this->forge->dropTable('utilisateurs',true);
    }
}
