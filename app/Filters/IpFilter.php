<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class IpFilter implements FilterInterface
{
    private $allowed_ips = ['127.0.0.1', '::1','2804:33cc:1434:d400:34e2:4ddc:c9c0:3e9', '177.73.197.2', '162.120.186.81', '2804:33cc:1420:1200:cda9:7453:8828:5372'];

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
