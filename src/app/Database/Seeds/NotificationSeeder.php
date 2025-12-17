<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NotificationSeeder extends Seeder
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

        $notificationTypes = [
            ['type' => 'welcome', 'title' => 'Selamat Datang!', 'message' => 'Akun Anda telah disetujui. Selamat bergabung!'],
            ['type' => 'reminder', 'title' => 'Reminder', 'message' => 'Jangan lupa catat aktivitas latihan hari ini.'],
            ['type' => 'achievement', 'title' => 'Pencapaian', 'message' => 'Selamat! Anda telah menyelesaikan 10 aktivitas.'],
            ['type' => 'bmi_update', 'title' => 'Update BMI', 'message' => 'Saatnya update data fisik Anda.'],
            ['type' => 'inactive', 'title' => 'Tidak Aktif Selama 7 hari', 'message' => 'Kami merindukan Anda! Ayo kembali berlatih.'],
            
        ];

        $insertCount = 0;

        foreach ($users as $user) {
            // Generate 2-4 notifications per user
            $numNotifications = rand(2, 4);
            
            for ($i = 0; $i < $numNotifications; $i++) {
                $notification = $notificationTypes[array_rand($notificationTypes)];
                $isRead = rand(0, 1); // 50% chance read/unread
                
                $this->db->table('notifications')->insert([
                    'user_id'    => $user['id'],
                    'type'       => $notification['type'],
                    'title'      => $notification['title'],
                    'message'    => $notification['message'],
                    'is_read'    => $isRead,
                    'sent_at'   => date('Y-m-d H:i:s', strtotime('-' . rand(1, 14) . ' days')),
                    'created_at' => date('Y-m-d H:i:s', strtotime('-' . rand(1, 14) . ' days')),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                
                $insertCount++;
            }
        }

        echo "✅ Notification seeder completed: $insertCount notifications\n";
    }
}