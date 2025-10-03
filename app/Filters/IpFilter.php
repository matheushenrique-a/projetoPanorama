<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class IpFilter implements FilterInterface
{
    private $allowed_ips = ['127.0.0.1', '::1', '177.73.197.2', '162.120.186.81', '2804:33cc:1445:5400:15a1:9185:8523:e95e'];

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
