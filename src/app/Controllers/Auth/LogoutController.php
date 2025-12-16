<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;

class LogoutController extends BaseController
{
    /**
     * Process logout
     */
    public function index()
    {
        // Destroy session
        $this->session->destroy();

        return redirect()->to('/login')->with('success', 'Anda telah berhasil logout');
    }
}