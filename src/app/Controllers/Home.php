<?php

namespace App\Controllers;

class Home extends BaseController
{
    /**
     * Landing page
     * 
     * @return string|RedirectResponse
     */
    public function index()
    {
        // Redirect jika sudah login
        if ($this->session->get('isLoggedIn')) {
            $role = $this->session->get('role');
            return redirect()->to($role === 'admin' ? '/admin/dashboard' : '/user/dashboard');
        }

        return view('welcome_message');
    }
}