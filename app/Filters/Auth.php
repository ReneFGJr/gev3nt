<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $uri = service('uri');
        // Permitir acesso livre à página inicial e login
        if ($uri->getPath() === '' || $uri->getPath() === '/' || $uri->getPath() === 'login') {
            return;
        }
        if (!session()->has('usuario')) {
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Não faz nada após
    }
}
