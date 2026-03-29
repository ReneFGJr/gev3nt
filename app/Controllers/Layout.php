<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Layout extends Controller
{
    public function index()
    {
        $data['title'] = 'Bem-vindo ao Gev3nt';
        return view('layout/header', $data);
    }
}
