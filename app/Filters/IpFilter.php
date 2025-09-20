<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class IpFilter implements FilterInterface
{
    private $allowed_ips = ['127.0.0.1', '::1', '177.73.197.2', '2804:33cc:1434:d400:28fc:6cf6:678:7816'];

    public function before(RequestInterface $request, $arguments = null)
    {
        $ip = $request->getIPAddress();

        return print_r($ip);

        if (!in_array($ip, $this->allowed_ips)) {
            return service('response')
                ->setStatusCode(403)
                ->setBody(view('errors/custom_403'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
