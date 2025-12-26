<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table            = 'notifications';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'type',
        'title',
        'message',
        'is_read',
        'sent_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'user_id' => 'required|is_not_unique[users.id]',
        'type'    => 'required|in_list[inactive_7days,bmi_alert]',
        'title'   => 'required|max_length[255]',
        'message' => 'required',
        'sent_at' => 'required|valid_date',
    ];

    protected $skipValidation = false;

    /**
     * Create welcome notification
     */
    // public function createWelcomeNotification($userId)
    // {
    //     $data = [
    //         'user_id' => $userId,
    //         'type'    => 'welcome',
    //         'title'   => 'Selamat Datang di Aplikasi Tracking Latihan!',
    //         'message' => 'Terima kasih telah bergabung. Mulailah mencatat latihan Anda untuk mencapai tujuan kebugaran Anda.',
    //         'is_read' => 0,
    //         'sent_at' => date('Y-m-d H:i:s'),
    //     ];
        
    //     return $this->insert($data);
    // }

    /**
     * Create notification for inactive user
     */
    public function createInactiveNotification($userId)
    {
        $data = [
            'user_id' => $userId,
            'type'    => 'inactive_7days',
            'title'   => 'Sudah Lama Tidak Berlatih!',
            'message' => 'Anda sudah tidak melakukan latihan selama 7 hari. Yuk mulai lagi untuk menjaga kesehatan!',
            'is_read' => 0,
            'sent_at' => date('Y-m-d H:i:s'),
        ];
        
        return $this->insert($data);
    }

    /**
     * Create BMI alert notification
     */
    public function createBMIAlertNotification($userId, $bmiCategory)
    {
        $messages = [
            'overweight' => 'BMI Anda menunjukkan kategori overweight. Konsultasikan dengan admin untuk program latihan yang sesuai.',
            'obese'      => 'BMI Anda menunjukkan kategori obese. Sangat disarankan untuk berkonsultasi dengan admin mengenai program kesehatan.',
        ];
        
        $data = [
            'user_id' => $userId,
            'type'    => 'bmi_alert',
            'title'   => 'Peringatan BMI',
            'message' => $messages[$bmiCategory] ?? 'BMI Anda memerlukan perhatian khusus.',
            'is_read' => 0,
            'sent_at' => date('Y-m-d H:i:s'),
        ];
        
        return $this->insert($data);
    }

    /**
     * Get unread notifications by user
     */
    public function getUnreadByUser($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('is_read', 0)
                    ->orderBy('sent_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get all notifications by user
     */
    public function getAllByUser($userId, $limit = 20)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('sent_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($notificationId)
    {
        return $this->update($notificationId, ['is_read' => 1]);
    }

    /**
     * Mark all user notifications as read
     */
    public function markAllAsReadByUser($userId)
    {
        return $this->where('user_id', $userId)
                    ->set(['is_read' => 1])
                    ->update();
    }

    /**
     * Get unread count
     */
    public function getUnreadCount($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('is_read', 0)
                    ->countAllResults();
    }

    /**
     * Delete old notifications (older than 30 days)
     */
    public function deleteOldNotifications($days = 30)
    {
        $dateThreshold = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        
        return $this->where('sent_at <', $dateThreshold)
                    ->delete();
    }
}