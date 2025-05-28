<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Libraries\ApiLogger;

class ApiRequestLogger implements FilterInterface {

  public function before(RequestInterface $request, $arguments = null) {

    $request    = service('request');
    $method     = strtoupper($request->getMethod());
    $uri        = service('uri')->getPath();
    $uri        = preg_replace('#^index\.php\/#', '', $uri);
    $uri        = ltrim($uri, '/');
    $ip         = $request->getIPAddress();

    if (empty($ip) || $ip === '::1') {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'IP não detectado';
    }

    $userAgent  = $request->getServer('HTTP_USER_AGENT');

    $msg = "[{$method}] {$uri} | IP: {$ip} | Agente: {$userAgent}";

    ApiLogger::info($msg);

    return;

  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
    // Se quiser logar depois do processamento
  }

}
