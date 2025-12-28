<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'email',
        'password_hash',
        'role',
        'is_approved',
        'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username,id,{id}]',
        'email'    => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password_hash' => 'required|min_length[8]',
        'role'     => 'required|in_list[admin,user]',
    ];

    protected $validationMessages = [
        'username' => [
            'required'    => 'Username harus diisi',
            'min_length'  => 'Username minimal 3 karakter',
            'is_unique'   => 'Username sudah digunakan',
        ],
        'email' => [
            'required'     => 'Email harus diisi',
            'valid_email'  => 'Email tidak valid',
            'is_unique'    => 'Email sudah terdaftar',
        ],
    ];

    protected $skipValidation = false;

    /**
     * Get pending approval users
     */
    public function getPendingUsers()
    {
        return $this->where('role', 'user')
                    ->where('is_approved', 0)
                    ->where('is_active', 1)
                    ->findAll();
    }

    /**
     * Get active users count
     */
    public function getActiveUsersCount()
    {
        return $this->select('COUNT(DISTINCT users.id) as active_user_count')
                    ->where('role', 'user')
                    ->where('is_approved', 1)
                    ->where('is_active', 1)
                    ->countAllResults();
    }

    /**
     * Get total users count (including pending)
     */
    public function getTotalUsersCount()
    {
        return $this->where('role', 'user')
                    ->countAllResults();
    }

    /**
     * Get approved users count
     */
    public function getApprovedUsersCount()
    {
        return $this->where('role', 'user')
                    ->where('is_approved', 1)
                    ->where('is_active', 1)
                    ->countAllResults();
    }


    /**
     * Approve user
     */
    public function approveUser($userId)
    {
        return $this->update($userId, ['is_approved' => 1]);
    }

    /**
     * Get users with their latest physical data
     */
    public function getUsersWithPhysicalData()
    {
        return $this->select('users.*, user_physical_data.bmi, user_physical_data.bmi_category, user_physical_data.updated_at as last_physical_update')
                    ->join('user_physical_data', 'user_physical_data.user_id = users.id', 'left')
                    ->where('users.role', 'user')
                    ->where('users.is_approved', 1)
                    // ->groupBy('users.id')
                    ->orderBy('user_physical_data.updated_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get inactive users (no activity for 7 days)
     */
    public function getInactiveUsers($days = 7)
    {
        $dateThreshold = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        
        return $this->select('users.*')
                    ->join('training_activities', 'training_activities.user_id = users.id', 'left')
                    ->where('users.role', 'user')
                    ->where('users.is_approved', 1)
                    // ->groupBy('users.id')
                    ->having('MAX(training_activities.activity_date) <', $dateThreshold)
                    ->orHaving('MAX(training_activities.activity_date) IS NULL')
                    ->findAll();
    }
}