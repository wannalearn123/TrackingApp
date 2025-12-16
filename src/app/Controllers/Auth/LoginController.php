<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;

class LoginController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Display login form
     */
    public function index()
    {
        // Redirect if already logged in
        if ($this->session->get('isLoggedIn')) {
            $role = $this->session->get('role');
            return redirect()->to($role === 'admin' ? '/admin/dashboard' : '/user/dashboard');
        }

        return view('auth/login');
    }

    /**
     * Process login
     */
    public function authenticate()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required|min_length[8]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Find user by username or email
        $user = $this->userModel->where('username', $username)
                                ->orWhere('email', $username)
                                ->first();

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Username atau email tidak ditemukan');
        }

        // Verify password
        if (!password_verify($password, $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Password salah');
        }

        // Check if account is active
        if (!$user['is_active']) {
            return redirect()->back()->with('error', 'Akun Anda telah dinonaktifkan. Hubungi administrator');
        }

        // Check if user account is approved (for regular users)
        if ($user['role'] === 'user' && !$user['is_approved']) {
            return redirect()->to('/waiting-approval')->with('info', 'Akun Anda menunggu persetujuan admin');
        }

        // Set session data
        $sessionData = [
            'user_id'     => $user['id'],
            'username'    => $user['username'],
            'email'       => $user['email'],
            'role'        => $user['role'],
            'is_approved' => $user['is_approved'],
            'isLoggedIn'  => true,
        ];

        $this->session->set($sessionData);

        // Redirect based on role
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/dashboard')->with('success', 'Selamat datang, Admin!');
        } else {
            return redirect()->to('/user/dashboard')->with('success', 'Selamat datang kembali!');
        }
    }
}