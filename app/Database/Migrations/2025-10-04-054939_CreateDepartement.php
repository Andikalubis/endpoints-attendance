<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDepartement extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
                'unsigned'       => true,
            ],
            'departement_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'max_clock_in_time' => [
                'type' => 'TIME',
                'null' => false,
            ],
            'max_clock_out_time' => [
                'type' => 'TIME',
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('departement', true);
    }

    public function down()
    {
        $this->forge->dropTable('departement', true);
    }
}
