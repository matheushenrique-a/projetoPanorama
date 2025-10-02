<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $params = null)
    {
        $isLoggedIn = session()->get('isLoggedIn');
        $userRoles = session()->get('perfil');

        if (is_string($userRoles) && strpos($userRoles, '[') === 0) {
            $userRoles = json_decode($userRoles, true);
        }

        if (!is_array($userRoles)) {
            $userRoles = [$userRoles];
        }

        $requiredRoles = [];
        if (!empty($params)) {
            $requiredRoles = array_map('strtoupper', explode(',', $params[0]));
        }

        $userRoles = array_map('strtoupper', $userRoles);

        if (!$isLoggedIn || empty(array_intersect($requiredRoles, $userRoles))) {
            return redirect()->to(urlInstitucional)->with('noPermission', true);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
