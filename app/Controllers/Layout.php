<?php
namespace App\Controllers;

helper('url');

class Layout extends BaseController
{
    public function index()
    {
        return view('layout/index');
    }
}
