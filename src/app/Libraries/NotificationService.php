<?php

namespace App\Libraries;

use App\Models\NotificationModel;
use App\Models\UserModel;

class NotificationService
{
    protected $notificationModel;
    protected $userModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
        $this->userModel = new UserModel();
    }

    /**
     * Send inactive user notification
     * 
     * @param int $userId User ID
     * @return bool Success status
     */
    public function sendInactiveNotification(int $userId): bool
    {
        // Check if notification already sent in last 7 days
        $recentNotifications = $this->notificationModel
            ->where('user_id', $userId)
            ->where('type', 'inactive_7days')
            ->where('sent_at >=', date('Y-m-d H:i:s', strtotime('-7 days')))
            ->findAll();
        
        if (!empty($recentNotifications)) {
            return false; // Don't send duplicate notification
        }
        
        $result = $this->notificationModel->createInactiveNotification($userId);
        
        if ($result) {
            // TODO: Implement push notification via Firebase Cloud Messaging (FCM)
            $this->sendPushNotification($userId, 'inactive_7days');
        }
        
        return $result !== false;
    }

    /**
     * Send BMI alert notification
     * 
     * @param int $userId User ID
     * @param string $bmiCategory BMI category
     * @return bool Success status
     */
    public function sendBMIAlert(int $userId, string $bmiCategory): bool
    {
        if (!in_array($bmiCategory, ['overweight', 'obese'])) {
            return false; // Only send for alert-worthy categories
        }
        
        // Check if similar notification already sent today
        $recentNotifications = $this->notificationModel
            ->where('user_id', $userId)
            ->where('type', 'bmi_alert')
            ->where('sent_at >=', date('Y-m-d 00:00:00'))
            ->findAll();
        
        if (!empty($recentNotifications)) {
            return false; // Don't send duplicate notification
        }
        
        $result = $this->notificationModel->createBMIAlertNotification($userId, $bmiCategory);
        
        if ($result) {
            // TODO: Implement push notification via Firebase Cloud Messaging (FCM)
            $this->sendPushNotification($userId, 'bmi_alert');
        }
        
        return $result !== false;
    }

    /**
     * Send push notification (placeholder for FCM implementation)
     * 
     * @param int $userId User ID
     * @param string $type Notification type
     * @return bool Success status
     */
    protected function sendPushNotification(int $userId, string $type): bool
    {
        // TODO: Implement Firebase Cloud Messaging integration
        // This requires:
        // 1. Firebase project setup
        // 2. User device token storage
        // 3. FCM SDK integration
        
        // Placeholder implementation
        log_message('info', "Push notification sent to user {$userId} with type {$type}");
        
        return true;
    }

    /**
     * Get user notification summary
     * 
     * @param int $userId User ID
     * @return array Notification summary
     */
    public function getUserNotificationSummary(int $userId): array
    {
        $unreadCount = $this->notificationModel->getUnreadCount($userId);
        $recentNotifications = $this->notificationModel->getAllByUser($userId, 5);
        
        return [
            'unread_count' => $unreadCount,
            'recent'       => $recentNotifications,
        ];
    }

    /**
     * Bulk send notifications to multiple users
     * 
     * @param array $userIds Array of user IDs
     * @param string $type Notification type
     * @return int Number of notifications sent
     */
    public function bulkSendNotifications(array $userIds, string $type): int
    {
        $sentCount = 0;
        
        foreach ($userIds as $userId) {
            if ($type === 'inactive_7days') {
                if ($this->sendInactiveNotification($userId)) {
                    $sentCount++;
                }
            }
        }
        
        return $sentCount;
    }
}