<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

  class AuthFilter implements FilterInterface {

    public function before(RequestInterface $request, $arguments = null) {

      $token = $request->getHeaderLine('Authorization');
      $expectedToken = 'Bearer ' . env('auth.token');

      if ($token !== $expectedToken) {
        return service('response')
          ->setJSON(['error' => 'Não autorizado'])
          ->setStatusCode(401);
      }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Nada aqui, por enquanto
    }

  }
