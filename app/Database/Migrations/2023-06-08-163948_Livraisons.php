<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Livraisons extends Migration
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
            'preget' => [
                'type' => 'ENUM("OUI","NON")',
                'null' => true,
                'default' => "NON"
            ],
            'date_pg' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'ch_aller' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'cam_aller' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'date_aller' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'ch_retour' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'cam_retour' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'date_retour' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'commentaire' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'annulation' => [
                'type' => 'ENUM("OUI","NON")',
                'default' => "NON",
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
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('ch_aller','chauffeurs','id','CASCADE','RESTRICT');
        $this->forge->addForeignKey('cam_aller','camions','id','CASCADE','RESTRICT');
        $this->forge->addForeignKey('ch_retour','chauffeurs','id','CASCADE','RESTRICT');
        $this->forge->addForeignKey('cam_retour','camions','id','CASCADE','RESTRICT');
        $this->forge->createTable('livraisons',true);
    }

    public function down()
    {
        $this->forge->dropTable('livraisons',true);
    }
}
