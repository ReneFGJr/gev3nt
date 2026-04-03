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
                $name = explode(' ', $query);
                foreach ($name as $value) {
                    $value = trim($value);
                    if ($value !== '') {
                        $UsersModel->like('n_nome', $value);
                    }
                }
                $user = $UsersModel->first();
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
            $certificados = [];

            if ($userId) {
                // Busca certificados pelo ID do usuário
                $certificados = $EventsInscritosModel->getCertificadosByUser($userId);
            }

            // Amplia a busca para também pesquisar pelo termo em i_autores
            $certificadosAutoresModel = new \App\Models\EventsInscritosModel();
            $certificadosPorAutores = $certificadosAutoresModel
                ->join('events', 'events_inscritos.i_evento = events.id_e')
                ->like('i_autores', $query)
                ->findAll();

            if (!empty($certificadosPorAutores)) {
                $mapa = [];
                foreach ($certificados as $cert) {
                    $mapa[$cert['id_i']] = $cert;
                }
                foreach ($certificadosPorAutores as $cert) {
                    $mapa[$cert['id_i']] = $cert;
                }
                $certificados = array_values($mapa);
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
