<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Onlinepay extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('fact_liv',[
            'reglement' => [
                'type' => 'ENUM("NON PAYÉ","PAR CHÈQUE","EN ESPÈCES","À CRÉDIT","PAYTECH")',
                'null' => true,
                'default' => 'NON PAYÉ'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('fact_liv',[
            'reglement' => [
                'type' => 'ENUM("NON PAYÉ","PAR CHÈQUE","EN ESPÈCES","À CRÉDIT")',
                'null' => true,
                'default' => 'NON PAYÉ'
            ],
        ]);
    }
}
