<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\TrainingActivityModel;
use App\Models\PhysicalDataModel;

class TrainingController extends BaseController
{
    protected $trainingActivityModel;
    protected $PhysicalDataModel;

    public function __construct()
    {
        $this->trainingActivityModel = new TrainingActivityModel();
        $this->PhysicalDataModel = new PhysicalDataModel();
    }

    /**
     * Display training start page (with GPS tracking)
     */
    public function start()
    {
        $physicalData = $this->PhysicalDataModel->getLatestByUserId($this->session->get('user_id'));
        return view('user/training/start', ['physicalData' => $physicalData]);
    }

    /**
     * Save training activity
     */
    public function save()
    {
        $rules = [
            'distance'      => 'required|decimal|greater_than[0]',
            'duration'      => 'required|integer|greater_than[0]',
            'gps_route'     => 'permit_empty',
            'activity_date' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        $userId = $this->session->get('user_id');

        $data = [
            'user_id'       => $userId,
            'distance'      => $this->request->getPost('distance'),
            'duration'      => $this->request->getPost('duration'),
            'gps_route'     => $this->request->getPost('gps_route'),
            'activity_date' => $this->request->getPost('activity_date'),
        ];

        if ($this->trainingActivityModel->insert($data)) {
            $activityId = $this->trainingActivityModel->getInsertID();
            
            return $this->response->setJSON([
                'success'     => true,
                'message'     => 'Training berhasil disimpan!',
                'activity_id' => $activityId,
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menyimpan training',
            ]);
        }
    }

    /**
     * Display training summary
     */
    public function summary($activityId)
    {
        $activity = $this->trainingActivityModel->find($activityId);
        if (!$activity || $activity['user_id'] != $this->session->get('user_id')) {
            return redirect()->to('/user/dashboard')->with('error', 'Aktivitas tidak ditemukan');
        }

        $data = [
            'activity' => $activity,

        ];

        return view('user/training/summary', $data);
    }
}