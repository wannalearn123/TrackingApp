<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PhysicalDataModel;
use App\Models\TrainingActivityModel;
use App\Models\NotificationModel;

class DashboardController extends BaseController
{
    protected $userModel;
    protected $physicalDataModel;
    protected $trainingActivityModel;
    protected $notificationModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->physicalDataModel = new PhysicalDataModel();
        $this->trainingActivityModel = new TrainingActivityModel();
        $this->notificationModel = new NotificationModel();
    }

    /**
     * Display user dashboard
     */
    public function index()
    {
        $userId = $this->session->get('user_id');

        // Get user physical data
        $physicalData = $this->physicalDataModel->getLatestByUserId($userId);

        // Get training statistics
        $totalDistance = $this->trainingActivityModel->getTotalDistanceByUser($userId);
        $totalDuration = $this->trainingActivityModel->getTotalDurationByUser($userId);
        
        // Get recent activities
        $recentActivities = $this->trainingActivityModel->getUserHistory($userId, 5);

        // Get monthly statistics for chart
        $monthlyStats = $this->trainingActivityModel->getMonthlyStatistics($userId);

        // Get unread notifications count
        $unreadNotifications = $this->notificationModel->getUnreadCount($userId);

        $totalActivities = count($this->trainingActivityModel->getActivitiesByUser($userId));

        $data = [
            'physicalData'        => $physicalData,
            'totalDistance'       => $totalDistance,
            'totalDuration'       => $totalDuration,
            'recentActivities'    => $recentActivities,
            'monthlyStats'        => $monthlyStats,
            'unreadNotifications' => $unreadNotifications,
            'totalActivities'     => $totalActivities
        ];

        return view('user/dashboard', $data);
    }
}