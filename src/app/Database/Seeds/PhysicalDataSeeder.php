<?php


namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PhysicalDataSeeder extends Seeder
{
    public function run()
    {
        // Get an admin user to attribute the data
        $admin = $this->db->table('users')
            ->where('role', 'admin')
            ->get()
            ->getRowArray();
        // Get approved users (skip admin)
        $users = $this->db->table('users')
            ->where('role', 'user')
            ->where('is_approved', 1)
            ->get()
            ->getResultArray();
        

        if (empty($users)) {
            echo "⚠️ No approved users found. Run UserSeeder first.\n";
            return;
        }

        foreach ($users as $user) {
            // Generate realistic physical data
            $height = rand(150, 190); // cm
            $weight = rand(50, 100);  // kg
            $bmi = round($weight / (($height / 100) ** 2), 2);

            $this->db->table('user_physical_data')->insert([
                'user_id'    => $user['id'],
                'height'     => $height,
                'weight'     => $weight,
                'bmi'        => $bmi,
                'recorded_by_admin_id'=> $admin['id'] ?? null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        echo "✅ Physical data seeder completed for " . count($users) . " users\n";
    }
}