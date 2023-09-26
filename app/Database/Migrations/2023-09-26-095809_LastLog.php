<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LastLog extends Migration
{
    public function up()
    {
        $this->forge->addColumn('utilisateurs', [
            'last_login' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('utilisateurs', 'last_login');
    }
}
