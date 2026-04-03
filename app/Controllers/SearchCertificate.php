<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class SearchCertificate extends Controller
{
    public function index()
    {
        $query = $this->request->getGet('query');
        return view('search-certificate', ['query' => $query]);
    }

    public function search()
    {
        $query = $this->request->getPost('query');
        return view('search-certificate', ['query' => $query]);
    }
}
