<?php

namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthGuard implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn'))
        {
            return redirect()->to('/signin');
        }

        if (! empty($arguments) && in_array('admin', $arguments))
        {
            if (session()->get('type') != 'admin')
            {
                return redirect()->to('/home');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {

    }
}

?>