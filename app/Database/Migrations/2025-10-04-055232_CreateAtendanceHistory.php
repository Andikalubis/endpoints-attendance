<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAttendanceHistory extends Migration
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
            ],
            'date_attendance' => [
                'type' => 'TIMESTAMP',
            ],
            'attendance_type' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'comment'    => '1 = In, 2 = Out',
            ],
            'description' => [
                'type' => 'TEXT',
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
        $this->forge->addForeignKey('attendance_id', 'attendance', 'attendance_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('attendance_history', true);
    }

    public function down()
    {
        $this->forge->dropTable('attendance_history', true);
    }
}
