<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingActivityModel extends Model
{
    protected $table            = 'training_activities';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'distance',
        'duration',
        'avg_pace',
        'gps_route',
        'activity_date'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'user_id'       => 'required|is_not_unique[users.id]',
        'distance'      => 'required|decimal|greater_than[0]',
        'duration'      => 'required|integer|greater_than[0]',
        'activity_date' => 'required|valid_date',
    ];

    protected $validationMessages = [
        'distance' => [
            'required'     => 'Jarak harus diisi',
            'decimal'      => 'Jarak harus berupa angka',
            'greater_than' => 'Jarak harus lebih dari 0',
        ],
        'duration' => [
            'required'     => 'Durasi harus diisi',
            'integer'      => 'Durasi harus berupa angka',
            'greater_than' => 'Durasi harus lebih dari 0',
        ],
    ];

    protected $skipValidation = false;
    protected $beforeInsert   = ['calculateAvgPace'];
    protected $beforeUpdate   = ['calculateAvgPace'];

    /**
     * Calculate average pace (minutes per km)
     */
    protected function calculateAvgPace(array $data)
    {
        if (isset($data['data']['distance']) && isset($data['data']['duration']) && $data['data']['distance'] > 0) {
            $durationMinutes = $data['data']['duration'] / 60;
            $data['data']['avg_pace'] = round($durationMinutes / $data['data']['distance'], 2);
        }
        
        return $data;
    }

    /**
     * Get user training history
     */
    public function getUserHistory($userId, $limit = 10)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('activity_date', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get total distance by user
     */
    public function getTotalDistanceByUser($userId)
    {
        $result = $this->selectSum('distance')
                       ->where('user_id', $userId)
                       ->first();
        
        return $result['distance'] ?? 0;
    }

    /**
     * Get total training time by user (in hours)
     */
    public function getTotalDurationByUser($userId)
    {
        $result = $this->selectSum('duration')
                       ->where('user_id', $userId)
                       ->first();
        
        return round(($result['duration'] ?? 0) / 3600, 2); // Convert to hours
    }

    /**
     * Get active users today
     */
    public function getActiveUsersToday()
    {
        $today = date('Y-m-d');
        
        return $this->select('COUNT(DISTINCT user_id) as count')
                    ->where('DATE(activity_date)', $today)
                    ->first()['count'];
    }

    /**
     * Get training completion rate (users who trained this week)
     */
    public function getWeeklyCompletionRate()
    {
        $weekAgo = date('Y-m-d H:i:s', strtotime('-7 days'));
        
        $activeUsers = $this->select('COUNT(DISTINCT user_id) as count')
                            ->where('activity_date >=', $weekAgo)
                            ->first()['count'];
        
        $userModel = new UserModel();
        $totalUsers = $userModel->getActiveUsersCount();
        
        if ($totalUsers == 0) return 0;
        
        return round(($activeUsers / $totalUsers) * 100, 2);
    }

    /**
     * Get all activities for admin monitoring (with user info)
     */
    public function getAllActivitiesWithUsers($limit = 50)
    {
        return $this->select('training_activities.*, users.username, users.email')
                    ->join('users', 'users.id = training_activities.user_id')
                    ->orderBy('training_activities.activity_date', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get activities by user for admin view
     */
    public function getActivitiesByUser($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('activity_date', 'DESC')
                    ->findAll();
    }

    /**
     * Get monthly statistics for charts
     */
    public function getMonthlyStatistics($userId = null)
    {
        $builder = $this->builder();
        
        $builder->select("DATE_FORMAT(activity_date, '%Y-%m') as month, 
                         COUNT(*) as total_activities, 
                         SUM(distance) as total_distance, 
                         SUM(duration) as total_duration")
                ->groupBy('month')
                ->orderBy('month', 'DESC')
                ->limit(6);
        
        if ($userId) {
            $builder->where('user_id', $userId);
        }
        
        return $builder->get()->getResultArray();
    }
}