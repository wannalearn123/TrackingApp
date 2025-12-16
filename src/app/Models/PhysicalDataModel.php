<?php

namespace App\Models;

use CodeIgniter\Model;

class PhysicalDataModel extends Model
{
    protected $table            = 'user_physical_data';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'height',
        'weight',
        'bmi',
        'bmi_category',
        'recorded_by_admin_id'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'user_id' => 'required|is_not_unique[users.id]',
        'height'  => 'required|decimal|greater_than[0]',
        'weight'  => 'required|decimal|greater_than[0]',
        'recorded_by_admin_id' => 'required|is_not_unique[users.id]',
    ];

    protected $validationMessages = [
        'height' => [
            'required'     => 'Tinggi badan harus diisi',
            'decimal'      => 'Tinggi badan harus berupa angka',
            'greater_than' => 'Tinggi badan harus lebih dari 0',
        ],
        'weight' => [
            'required'     => 'Berat badan harus diisi',
            'decimal'      => 'Berat badan harus berupa angka',
            'greater_than' => 'Berat badan harus lebih dari 0',
        ],
    ];

    protected $skipValidation = false;
    protected $beforeInsert   = ['calculateBMI'];
    protected $beforeUpdate   = ['calculateBMI'];

    /**
     * Calculate BMI before insert/update
     */
    protected function calculateBMI(array $data)
    {
        if (isset($data['data']['height']) && isset($data['data']['weight'])) {
            $height = $data['data']['height'] / 100; // Convert cm to meters
            $weight = $data['data']['weight'];
            
            $bmi = $weight / ($height * $height);
            $data['data']['bmi'] = round($bmi, 2);
            
            // Categorize BMI
            $data['data']['bmi_category'] = $this->categorizeBMI($bmi);
        }
        
        return $data;
    }

    /**
     * Categorize BMI value
     */
    private function categorizeBMI($bmi)
    {
        if ($bmi < 18.5) {
            return 'underweight';
        } elseif ($bmi >= 18.5 && $bmi < 25) {
            return 'normal';
        } elseif ($bmi >= 25 && $bmi < 30) {
            return 'overweight';
        } else {
            return 'obese';
        }
    }

    /**
     * Get latest physical data for user
     */
    public function getLatestByUserId($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->first();
    }

    /**
     * Get BMI statistics
     */
    public function getBMIStatistics()
    {
        return $this->select('bmi_category, COUNT(*) as count')
                    ->groupBy('bmi_category')
                    ->findAll();
    }

    /**
     * Get users with alert-worthy BMI (overweight/obese)
     */
    public function getUsersWithAlertBMI()
    {
        return $this->select('user_physical_data.*, users.username, users.email')
                    ->join('users', 'users.id = user_physical_data.user_id')
                    ->whereIn('bmi_category', ['overweight', 'obese'])
                    ->groupBy('user_id')
                    ->findAll();
    }
}