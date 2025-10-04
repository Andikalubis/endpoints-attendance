<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAttendance extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'employee_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'attendance_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'unique'     => true,
            ],
            'clock_in' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'clock_out' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('employee_id', 'employee', 'employee_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('attendance', true);
    }

    public function down()
    {
        $this->forge->dropTable('attendance', true);
    }
}
