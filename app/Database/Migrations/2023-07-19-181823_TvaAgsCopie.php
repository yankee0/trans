<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TvaAgsCopie extends Migration
{
    public function up()
    {
        $this->forge->addColumn('fact_liv',[
            'avec_tva' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'default' => 'NON'
            ],
            'avec_ages' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'default' => 'OUI'
            ],
            'avec_copie' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'default' => 'NON'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('fact_liv','avec_ages');
        $this->forge->dropColumn('fact_liv','avec_copie');
        $this->forge->dropColumn('fact_liv','avec_tva');
    }
}
