<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class SearchCertificate extends Controller
{
    public function index()
    {
        $query = $this->request->getGet('query');
        $certificados = [];
        $nome = null;
        $email = null;
        $userId = null;

        if ($query) {
            $UsersModel = new \App\Models\UsersModel();
            // Verifica se é e-mail
            if (filter_var($query, FILTER_VALIDATE_EMAIL)) {
                $user = $UsersModel->where('n_email', $query)->first();
                if ($user) {
                    $nome = $user['n_nome'];
                    $email = $user['n_email'];
                    $userId = $user['id_n'];
                }
            } else {
                // Busca por nome exato
                $user = $UsersModel->where('n_nome', $query)->first();
                if ($user) {
                    $nome = $user['n_nome'];
                    $email = $user['n_email'];
                    $userId = $user['id_n'];
                } else {
                    // Busca por parte do nome
                    $user = $UsersModel->like('n_nome', $query)->first();
                    if ($user) {
                        $nome = $user['n_nome'];
                        $email = $user['n_email'];
                        $userId = $user['id_n'];
                    }
                }
            }

            $EventsInscritosModel = new \App\Models\EventsInscritosModel();
            if ($userId) {
                // Busca certificados pelo ID do usuário
                $certificados = $EventsInscritosModel->getCertificadosByUser($userId);
            } elseif ($nome) {
                // Busca certificados onde o nome aparece nos autores
                $certificados = $EventsInscritosModel
                    ->like('i_autores', $nome)
                    ->findAll();
            }
        }

        return view('search-certificate', [
            'query' => $query,
            'certificados' => $certificados,
            'nome' => $nome,
            'email' => $email
        ]);
    }

    public function search()
    {
        // Para POST, apenas redireciona para GET para manter lógica centralizada
        $query = $this->request->getPost('query');
        return redirect()->to('/search-certificate?query=' . urlencode($query));
    }
}
