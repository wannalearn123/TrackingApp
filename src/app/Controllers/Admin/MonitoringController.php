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
        $filters = [
            'search'    => $this->request->getGet('search'),
            'date_from' => $this->request->getGet('date_from'),
            'date_to'   => $this->request->getGet('date_to'),
        ];

        $builder = $this->trainingActivityModel->select('training_activities.*, users.username, users.email')
<<<<<<< HEAD
                                                ->join('users', 'training_activities.user_id = users.id')
                                                ->orderBy('training_activities.activity_date', 'DESC');
                                        
=======
                                               ->join('users', 'training_activities.user_id = users.id')
                                               ->orderBy('training_activities.activity_date', 'DESC');

>>>>>>> d92cf03c000faf925a26b9bd262cf32f9ae8e595
        if (!empty($filters['search'])) {
            $builder->groupStart()
                    ->like('users.username', $filters['search'])
                    ->orLike('users.email', $filters['search'])
                    ->groupEnd();
        }

        if (!empty($filters['date_from'])) {
<<<<<<< HEAD
            $builder->where('training_activities.activity_date >=', $filters['date_from'] . ' 00:00:00');
        }

        if (!empty($filters['date_to'])) {
            $builder->where('training_activities.activity_date <=', $filters['date_to'] . ' 23:59:59');
        }
        $activities = $builder->findAll();
        $data = [
            'activities' => $activities,
=======
            $builder->where('DATE(activity_date) >=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $builder->where('DATE(activity_date) <=', $filters['date_to']);
        }

        $data = [
            'activities' => $builder->asArray()->orderBy('training_activities.activity_date', 'DESC')->findAll(),
>>>>>>> d92cf03c000faf925a26b9bd262cf32f9ae8e595
            'filters'    => $filters,
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