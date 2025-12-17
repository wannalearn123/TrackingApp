<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin User
        // $this->db->table('users')->insert([
        //     'username'      => 'admin',
        //     'email'         => 'admin@trackingapp.com',
        //     'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
        //     'role'          => 'admin',
        //     'is_approved'   => 1,
        //     'is_active'     => 1,
        //     'created_at'    => date('Y-m-d H:i:s'),
        //     'updated_at'    => date('Y-m-d H:i:s'),
        // ]);

        // Approved Users (5 users)
        $approvedUsers = [
            ['username' => 'john_doe', 'email' => 'john@example.com'],
            ['username' => 'jane_smith', 'email' => 'jane@example.com'],
            ['username' => 'mike_wilson', 'email' => 'mike@example.com'],
            ['username' => 'sarah_jones', 'email' => 'sarah@example.com'],
            ['username' => 'david_brown', 'email' => 'david@example.com'],
        ];

        foreach ($approvedUsers as $user) {
            $this->db->table('users')->insert([
                'username'      => $user['username'],
                'email'         => $user['email'],
                'password_hash' => password_hash('user123', PASSWORD_DEFAULT),
                'role'          => 'user',
                'is_approved'   => 1,
                'is_active'     => 1,
                'created_at'    => date('Y-m-d H:i:s', strtotime('-' . rand(1, 30) . ' days')),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
        }

        // Pending Users (3 users)
        $pendingUsers = [
            ['username' => 'alice_pending', 'email' => 'alice@example.com'],
            ['username' => 'bob_waiting', 'email' => 'bob@example.com'],
            ['username' => 'charlie_new', 'email' => 'charlie@example.com'],
        ];

        foreach ($pendingUsers as $user) {
            $this->db->table('users')->insert([
                'username'      => $user['username'],
                'email'         => $user['email'],
                'password_hash' => password_hash('user123', PASSWORD_DEFAULT),
                'role'          => 'user',
                'is_approved'   => 0, // Pending approval
                'is_active'     => 1,
                'created_at'    => date('Y-m-d H:i:s', strtotime('-' . rand(1, 7) . ' days')),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
        }

        echo "✅ User seeder completed: 1 admin, 5 approved users, 3 pending users\n";
    }
}