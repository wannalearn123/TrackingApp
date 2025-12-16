<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\NotificationModel;

class NotificationController extends BaseController
{
    protected $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    /**
     * Display all notifications
     */
    public function index()
    {
        $userId = $this->session->get('user_id');

        $data = [
            'notifications' => $this->notificationModel->getAllByUser($userId, 50),
            'unreadCount'   => $this->notificationModel->getUnreadCount($userId),
        ];

        return view('user/notifications', $data);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($notificationId)
    {
        $notification = $this->notificationModel->find($notificationId);

        if (!$notification || $notification['user_id'] != $this->session->get('user_id')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Notifikasi tidak ditemukan',
            ]);
        }

        if ($this->notificationModel->markAsRead($notificationId)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Notifikasi ditandai telah dibaca',
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menandai notifikasi',
            ]);
        }
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        $userId = $this->session->get('user_id');

        if ($this->notificationModel->markAllAsReadByUser($userId)) {
            return redirect()->back()->with('success', 'Semua notifikasi telah ditandai dibaca');
        } else {
            return redirect()->back()->with('error', 'Gagal menandai notifikasi');
        }
    }

    /**
     * Get unread count (for AJAX)
     */
    public function getUnreadCount()
    {
        $userId = $this->session->get('user_id');
        $count = $this->notificationModel->getUnreadCount($userId);

        return $this->response->setJSON([
            'success' => true,
            'count'   => $count,
        ]);
    }
}