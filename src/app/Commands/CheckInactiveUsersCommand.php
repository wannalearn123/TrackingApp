<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\UserModel;
use App\Libraries\NotificationService;

class CheckInactiveUsersCommand extends BaseCommand
{
    protected $group       = 'app';
    protected $name        = 'check:inactive';
    protected $description = 'Check for inactive users (no training for 7 days) and send notifications';

    public function run(array $params)
    {
        CLI::write('Checking for inactive users...', 'yellow');

        $userModel = new UserModel();
        $notificationService = new NotificationService();

        // Get inactive users (no activity for 7 days)
        $inactiveUsers = $userModel->getInactiveUsers(7);

        if (empty($inactiveUsers)) {
            CLI::write('No inactive users found.', 'green');
            return;
        }

        $sentCount = 0;

        foreach ($inactiveUsers as $user) {
            if ($notificationService->sendInactiveNotification($user['id'])) {
                CLI::write("Notification sent to: {$user['username']}", 'green');
                $sentCount++;
            }
        }

        CLI::write("Total notifications sent: {$sentCount}", 'green');
        CLI::write('Task completed!', 'green');
    }
}