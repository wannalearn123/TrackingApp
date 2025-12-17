<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TrainingActivitySeeder extends Seeder
{
    public function run()
    {
        // Get approved users
        $users = $this->db->table('users')
            ->where('role', 'user')
            ->where('is_approved', 1)
            ->get()
            ->getResultArray();

        if (empty($users)) {
            echo "⚠️ No approved users found. Run UserSeeder first.\n";
            return;
        }

        $activities = ['Running', 'Swimming', 'Cycling', 'Gym', 'Yoga', 'Walking'];
        $statuses = ['completed', 'in_progress', 'planned'];

        $insertCount = 0;

        foreach ($users as $user) {
            // Generate 3-5 activities per user
            $numActivities = rand(3, 5);
            
            for ($i = 0; $i < $numActivities; $i++) {
                $daysAgo = rand(0, 30);
                $duration = rand(20, 120); // minutes
                
                $this->db->table('training_activities')->insert([
                    'user_id'        => $user['id'],
                    'duration'       => $duration,
                    'distance'       => round(rand(1, 15) + (rand(0, 99) / 100), 2), // km
                    'avg_pace'      => round($duration / (rand(1, 15) + (rand(0, 99) / 100)), 2), // min/km
                    'gps_route'     => json_encode([]), // Placeholder for GPS data
                    'activity_date'  => date('Y-m-d', strtotime("-$daysAgo days")),
                    'created_at'     => date('Y-m-d H:i:s'),
                    'updated_at'     => date('Y-m-d H:i:s'),
                ]);
                
                $insertCount++;
            }
        }

        echo "✅ Training activity seeder completed: $insertCount activities\n";
    }
}