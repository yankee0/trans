<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AjouterDeadline extends Migration
{
    public function up()
    {
        $this->forge->addColumn('fact_liv',[
            'deadline' => [
                'type' => 'DATE',
                'null' => true,
                'default' => null,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('fact_liv', 'deadline');
    }
}
