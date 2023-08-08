<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropUniqueKeyOnClients extends Migration
{
    public function up()
    {
        $this->db->query('ALTER TABLE clients DROP INDEX email');
        $this->db->query('ALTER TABLE clients DROP INDEX tel');
    }

    public function down()
    {
        //
    }
}
