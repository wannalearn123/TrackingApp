<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePhysicalDataTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'height' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'comment'    => 'Height in cm',
            ],
            'weight' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'comment'    => 'Weight in kg',
            ],
            'bmi' => [
                'type'       => 'DECIMAL',
                'constraint' => '4,2',
                'null'       => true,
            ],
            'bmi_category' => [
                'type'       => 'ENUM',
                'constraint' => ['underweight', 'normal', 'overweight', 'obese'],
                'null'       => true,
            ],
            'recorded_by_admin_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
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
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('recorded_by_admin_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_physical_data');
    }

    public function down()
    {
        $this->forge->dropTable('user_physical_data');
    }
}