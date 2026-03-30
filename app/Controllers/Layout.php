<?php
namespace App\Controllers;

helper('url');

class Layout extends BaseController
{
    public function contato()
    {
        return view('layout/contato');
    }

    public function index()
    {
        $certificados = [];
        if (session('usuario')) {
            $userId = session('usuario.id_n') ?? session('usuario.id');
            $certModel = new \App\Models\EventsInscritosModel();
            $certificados = $certModel->getCertificadosByUser($userId);
        }
        return view('layout/index', [
            'certificados' => $certificados
        ]);
    }
}
