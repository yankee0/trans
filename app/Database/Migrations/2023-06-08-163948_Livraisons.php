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
            'id_fact_ligne' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
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
            'etat' => [
                'type' => 'ENUM("MISE À TERRE","SUR PLATEAU","EN COURS","LIVRÉ","ANNULÉ")',
                'default' => 'SUR PLATEAU',
                'null' => false,
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
        $this->forge->addForeignKey('id_fact_ligne', 'fact_liv_lignes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('ch_aller', 'chauffeurs', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('cam_aller', 'camions', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('ch_retour', 'chauffeurs', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('cam_retour', 'camions', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('livraisons', true);
    }

    public function down()
    {
        $this->forge->dropTable('livraisons', true);
    }
}
