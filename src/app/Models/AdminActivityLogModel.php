<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminActivityLogModel extends Model
{
    protected $table            = 'admin_activity_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'admin_id',
        'action',
        'target_user_id',
        'details'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';

    // Validation
    protected $validationRules = [
        'admin_id' => 'required|is_not_unique[users.id]',
        'action'   => 'required|max_length[255]',
    ];

    protected $skipValidation = false;

    /**
     * Log admin action
     */
    public function logAction($adminId, $action, $targetUserId = null, $details = null)
    {
        $data = [
            'admin_id'       => $adminId,
            'action'         => $action,
            'target_user_id' => $targetUserId,
            'details'        => is_array($details) ? json_encode($details) : $details,
        ];
        
        return $this->insert($data);
    }

    /**
     * Get recent admin activities
     */
    public function getRecentActivities($limit = 50)
    {
        return $this->select('admin_activity_logs.*, 
                             admins.username as admin_username, 
                             users.username as target_username')
                    ->join('users as admins', 'admins.id = admin_activity_logs.admin_id')
                    ->join('users', 'users.id = admin_activity_logs.target_user_id', 'left')
                    ->orderBy('admin_activity_logs.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get activities by admin
     */
    public function getActivitiesByAdmin($adminId, $limit = 50)
    {
        return $this->where('admin_id', $adminId)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get activities by target user
     */
    public function getActivitiesByTargetUser($userId, $limit = 20)
    {
        return $this->select('admin_activity_logs.*, users.username as admin_username')
                    ->join('users', 'users.id = admin_activity_logs.admin_id')
                    ->where('target_user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}