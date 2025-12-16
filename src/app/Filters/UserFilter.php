<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class UserFilter implements FilterInterface
{
    /**
     * Check if user is regular user (not admin)
     *
     * @param RequestInterface $request
     * @param array|null $arguments
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // Check if user is logged in
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu');
        }
        
        // Check if user account is approved
        if (!$session->get('is_approved')) {
            return redirect()->to('/waiting-approval')->with('info', 'Akun Anda menunggu persetujuan admin');
        }
        
        // Check if user has user role
        if ($session->get('role') !== 'user') {
            return redirect()->to('/admin/dashboard')->with('error', 'Akses ditolak. Silakan gunakan panel admin');
        }
    }

    /**
     * After action (not used)
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param array|null $arguments
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}