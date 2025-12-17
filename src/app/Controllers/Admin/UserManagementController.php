<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\AdminActivityLogModel;

class UserManagementController extends BaseController
{
    protected $userModel;
    protected $activityLogModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->activityLogModel = new AdminActivityLogModel();
    }

    /**
     * Display users list
     */
    public function index()
    {
        $data = [
            'users'         => $this->userModel->getUsersWithPhysicalData(),
            'pending_users' => $this->userModel->getPendingUsers(),
        ];

        return view('admin/users/index', $data);
    }

    /**
     * Approve user
     */
    public function approve($userId)
    {
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        if ($this->userModel->approveUser($userId)) {
            // Log activity
            $this->activityLogModel->logAction(
                $this->session->get('user_id'),
                'approved_user',
                $userId,
                ['username' => $user['username']]
            );

            return redirect()->back()->with('success', 'User berhasil disetujui');
        } else {
            return redirect()->back()->with('error', 'Gagal menyetujui user');
        }
        return redirect()->back();
    }

    /**
     * Deactivate user
     */
    public function deactivate($userId)
    {
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        if ($this->userModel->update($userId, ['is_active' => 0])) {
            // Log activity
            $this->activityLogModel->logAction(
                $this->session->get('user_id'),
                'deactivated_user',
                $userId,
                ['username' => $user['username']]
            );

            return redirect()->back()->with('success', 'User berhasil dinonaktifkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menonaktifkan user');
        }
    }

    /**
     * Activate user
     */
    public function activate($userId)
    {
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        if ($this->userModel->update($userId, ['is_active' => 1])) {
            // Log activity
            $this->activityLogModel->logAction(
                $this->session->get('user_id'),
                'activated_user',
                $userId,
                ['username' => $user['username']]
            );

            return redirect()->back()->with('success', 'User berhasil diaktifkan');
        } else {
            return redirect()->back()->with('error', 'Gagal mengaktifkan user');
        }
    }

    /**
     * Delete user (soft delete)
     */
    public function delete($userId)
    {
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        if ($this->userModel->delete($userId)) {
            // Log activity
            $this->activityLogModel->logAction(
                $this->session->get('user_id'),
                'deleted_user',
                $userId,
                ['username' => $user['username']]
            );

            return redirect()->back()->with('success', 'User berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus user');
        }
    }
}