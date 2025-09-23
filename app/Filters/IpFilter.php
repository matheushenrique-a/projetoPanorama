<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class IpFilter implements FilterInterface
{
    private $allowed_ips = ['127.0.0.1', '::1', '177.73.197.2', '2804:33cc:1434:d400:69a0:8e4:2fa5:eb1'];

    public function before(RequestInterface $request, $arguments = null)
    {
        $ip = $request->getIPAddress();

        if (!in_array($ip, $this->allowed_ips)) {
            return service('response')
                ->setStatusCode(403)
                ->setBody(view('errors/custom_403'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
