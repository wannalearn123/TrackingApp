<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\TrainingActivityModel;
use App\Models\PhysicalDataModel;

class HistoryController extends BaseController
{
    protected $trainingActivityModel;
    protected $physicalDataModel;

    public function __construct()
    {
        $this->trainingActivityModel = new TrainingActivityModel();
        $this->physicalDataModel = new PhysicalDataModel();
    }

    /**
     * Display training history
     */
    public function index()
    {
        $userId = $this->session->get('user_id');

        // Get all activities
        $activities = $this->trainingActivityModel->getUserHistory($userId, 50);

        // Get statistics
        $totalDistance = $this->trainingActivityModel->getTotalDistanceByUser($userId);
        $totalDuration = $this->trainingActivityModel->getTotalDurationByUser($userId);

        // Get monthly statistics
        $monthlyStats = $this->trainingActivityModel->getMonthlyStatistics($userId);

        // Get physical data history (untuk lihat progress berat badan)
        $physicalData = $this->physicalDataModel->getLatestByUserId($userId);

        $data = [
            'activities'    => $activities,
            'totalDistance' => $totalDistance,
            'totalDuration' => $totalDuration,
            'monthlyStats'  => $monthlyStats,
            'physicalData'  => $physicalData,
            'filters'        => $this->request->getGet('filter') ?? 'all',
        ];

        return view('user/history', $data);
    }

    /**
     * View single activity detail
     */
    public function detail($activityId)
    {
        $activity = $this->trainingActivityModel->find($activityId);

        if (!$activity || $activity['user_id'] != $this->session->get('user_id')) {
            return redirect()->to('/user/history')->with('error', 'Aktivitas tidak ditemukan');
        }

        $data = [
            'activity' => $activity,
        ];

        return view('user/training/detail', $data);
    }

    /**
     * Delete activity
     */
    public function delete($activityId)
    {
        $activity = $this->trainingActivityModel->find($activityId);

        if (!$activity || $activity['user_id'] != $this->session->get('user_id')) {
            return redirect()->to('/user/history')->with('error', 'Aktivitas tidak ditemukan');
        }

        if ($this->trainingActivityModel->delete($activityId)) {
            return redirect()->to('/user/history')->with('success', 'Aktivitas berhasil dihapus');
        } else {
            return redirect()->to('/user/history')->with('error', 'Gagal menghapus aktivitas');
        }
    }
}