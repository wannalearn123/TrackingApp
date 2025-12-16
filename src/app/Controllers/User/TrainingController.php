<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\TrainingActivityModel;

class TrainingController extends BaseController
{
    protected $trainingActivityModel;

    public function __construct()
    {
        $this->trainingActivityModel = new TrainingActivityModel();
    }

    /**
     * Display training start page (with GPS tracking)
     */
    public function start()
    {
        return view('user/training/start');
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