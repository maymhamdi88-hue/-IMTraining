<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Verify session exists and is valid
        if (!session()->get('isLoggedIn')) {
            // Clear any remaining session data
            session()->destroy();
            
            return redirect()->to('/Auth/login')
                ->with('error', 'Veuillez vous connecter pour accéder à cette page');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}