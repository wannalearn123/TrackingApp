<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;
// use App\Libraries\NotificationService;

class RegisterController extends BaseController
{
    protected $userModel;
    // protected $notificationService;

    public function __construct()
    {
        $this->userModel = new UserModel();
        // $this->notificationService = new NotificationService();
    }
    /**
     * Display registration form
     */
    public function index()
    {
        // Redirect if already logged in
        if ($this->session->get('isLoggedIn')) {
            $role = $this->session->get('role');
            return redirect()->to($role === 'admin' ? '/admin/dashboard' : '/user/dashboard');
        }

        return view('auth/register');
    }

    /**
     * Process registration
     */
    public function store()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
        ];

        $messages = [
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
            'password' => [
                'required'    => 'Password harus diisi',
                'min_length'  => 'Password minimal 8 karakter',
            ],
            'password_confirm' => [
                'required' => 'Konfirmasi password harus diisi',
                'matches'  => 'Konfirmasi password tidak cocok',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username'      => $this->request->getPost('username'),
            'email'         => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'          => 'user',
            'is_approved'   => 0, // Waiting for admin approval
            'is_active'     => 1,
        ];

        if ($this->userModel->insert($data)) {
<<<<<<< HEAD

            // kirim notifikasi selamat datang            
=======
            // Send welcome notification
            // $this->notificationService->sendWelcomeNotification($this->re->());
>>>>>>> d92cf03c000faf925a26b9bd262cf32f9ae8e595
            return redirect()->to('/waiting-approval')->with('success', 'Registrasi berhasil! Menunggu persetujuan admin');
        } else {
            return redirect()->back()->withInput()->with('error', 'Registrasi gagal. Silakan coba lagi');
        }
    }

    /**
     * Waiting approval page
     */
    public function waitingApproval()
    {
        return view('auth/waiting_approval');
    }
}