<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTrainingActivitiesTable extends Migration
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
            'distance' => [
                'type'       => 'DECIMAL',
                'constraint' => '8,2',
                'comment'    => 'Distance in km',
            ],
            'duration' => [
                'type'    => 'INT',
                'comment' => 'Duration in seconds',
            ],
            'avg_pace' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
                'comment'    => 'Minutes per km',
            ],
            'gps_route' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'JSON array of lat/lng coordinates',
            ],
            'activity_date' => [
                'type' => 'DATETIME',
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
        $this->forge->addKey('activity_date');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('training_activities');
    }

    public function down()
    {
        $this->forge->dropTable('training_activities');
    }
}