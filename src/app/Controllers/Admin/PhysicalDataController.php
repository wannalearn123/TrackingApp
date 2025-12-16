<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PhysicalDataModel;
use App\Models\AdminActivityLogModel;
use App\Libraries\BMICalculator;
use App\Libraries\NotificationService;

class PhysicalDataController extends BaseController
{
    protected $userModel;
    protected $physicalDataModel;
    protected $activityLogModel;
    protected $notificationService;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->physicalDataModel = new PhysicalDataModel();
        $this->activityLogModel = new AdminActivityLogModel();
        $this->notificationService = new NotificationService();
    }

    /**
     * Display form to input physical data
     */
    public function create($userId)
    {
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }

        // Get existing physical data if any
        $existingData = $this->physicalDataModel->getLatestByUserId($userId);

        $data = [
            'user'         => $user,
            'physicalData' => $existingData,
        ];

        return view('admin/users/physical_data_form', $data);
    }

    /**
     * Store physical data
     */
    public function store()
    {
        $rules = [
            'user_id' => 'required|is_not_unique[users.id]',
            'height'  => 'required|decimal|greater_than[0]',
            'weight'  => 'required|decimal|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId = $this->request->getPost('user_id');
        $height = $this->request->getPost('height');
        $weight = $this->request->getPost('weight');

        // Calculate BMI
        $bmi = BMICalculator::calculate($height, $weight);
        $bmiCategory = BMICalculator::categorize($bmi);

        $data = [
            'user_id'              => $userId,
            'height'               => $height,
            'weight'               => $weight,
            'bmi'                  => $bmi,
            'bmi_category'         => $bmiCategory,
            'recorded_by_admin_id' => $this->session->get('user_id'),
        ];

        if ($this->physicalDataModel->insert($data)) {
            // Log activity
            $this->activityLogModel->logAction(
                $this->session->get('user_id'),
                'updated_physical_data',
                $userId,
                $data
            );

            // Send BMI alert if needed
            if (BMICalculator::requiresAlert($bmiCategory)) {
                $this->notificationService->sendBMIAlert($userId, $bmiCategory);
            }

            return redirect()->to('/admin/users')->with('success', 'Data fisik berhasil disimpan');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data fisik');
        }
    }

    /**
     * Update physical data
     */
    public function update($dataId)
    {
        $rules = [
            'height' => 'required|decimal|greater_than[0]',
            'weight' => 'required|decimal|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $physicalData = $this->physicalDataModel->find($dataId);

        if (!$physicalData) {
            return redirect()->to('/admin/users')->with('error', 'Data fisik tidak ditemukan');
        }

        $height = $this->request->getPost('height');
        $weight = $this->request->getPost('weight');

        // Calculate BMI
        $bmi = BMICalculator::calculate($height, $weight);
        $bmiCategory = BMICalculator::categorize($bmi);

        $data = [
            'height'               => $height,
            'weight'               => $weight,
            'bmi'                  => $bmi,
            'bmi_category'         => $bmiCategory,
            'recorded_by_admin_id' => $this->session->get('user_id'),
        ];

        if ($this->physicalDataModel->update($dataId, $data)) {
            // Log activity
            $this->activityLogModel->logAction(
                $this->session->get('user_id'),
                'updated_physical_data',
                $physicalData['user_id'],
                $data
            );

            // Send BMI alert if needed
            if (BMICalculator::requiresAlert($bmiCategory)) {
                $this->notificationService->sendBMIAlert($physicalData['user_id'], $bmiCategory);
            }

            return redirect()->to('/admin/users')->with('success', 'Data fisik berhasil diupdate');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data fisik');
        }
    }
}