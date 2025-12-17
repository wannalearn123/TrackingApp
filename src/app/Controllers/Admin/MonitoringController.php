<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\TrainingActivityModel;
use App\Models\PhysicalDataModel;

class MonitoringController extends BaseController
{
    protected $userModel;
    protected $trainingActivityModel;
    protected $physicalDataModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->trainingActivityModel = new TrainingActivityModel();
        $this->physicalDataModel = new PhysicalDataModel();
    }

    /**
     * Display activities list
     */
    public function index()
    {
        $data = [
            'activities' => $this->trainingActivityModel->getAllActivitiesWithUsers(),
        ];
        
        return view('admin/monitoring/activities_list', $data);
    }

    /**
     * Display user detail with activities
     */
    public function userDetail($userId)
    {
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/admin/monitoring')->with('error', 'User tidak ditemukan');
        }

        $data = [
            'user'         => $user,
            'physicalData' => $this->physicalDataModel->getLatestByUserId($userId),
            'activities'   => $this->trainingActivityModel->getActivitiesByUser($userId),
            'totalDistance' => $this->trainingActivityModel->getTotalDistanceByUser($userId),
            'totalDuration' => $this->trainingActivityModel->getTotalDurationByUser($userId),
            'monthlyStats'  => $this->trainingActivityModel->getMonthlyStatistics($userId),
        ];

        return view('admin/monitoring/user_detail', $data);
    }
}