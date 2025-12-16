<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PhysicalDataModel;
use App\Models\TrainingActivityModel;

class DashboardController extends BaseController
{
    protected $userModel;
    protected $physicalDataModel;
    protected $trainingActivityModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->physicalDataModel = new PhysicalDataModel();
        $this->trainingActivityModel = new TrainingActivityModel();
    }

    /**
     * Display admin dashboard
     */
    public function index()
    {
        // Get statistics
        $data = [
            'total_users'       => $this->userModel->getTotalUsersCount(),
            'pending_users'     => count($this->userModel->getPendingUsers()),
            'approved_users'    => $this->userModel->getApprovedUsersCount(),
            'active_users'      => $this->trainingActivityModel->getActiveUsersToday(),
            'completion_rate'   => $this->trainingActivityModel->getWeeklyCompletionRate(),
            'bmi_stats'         => $this->physicalDataModel->getBMIStatistics(),
            'recent_activities' => $this->trainingActivityModel->getAllActivitiesWithUsers(10),
            'alert_users'       => $this->physicalDataModel->getUsersWithAlertBMI(),
        ];

        return view('admin/dashboard', $data);
    }
}