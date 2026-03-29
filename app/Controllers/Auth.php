<?php
namespace App\Controllers;

use App\Models\EventInscritosModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        helper(['form']);
        return view('auth/login');
    }

    public function doLogin()
    {
        $session = session();
        $model = new EventInscritosModel();
        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('senha');
        $usuario = $model->where('email', $email)->first();
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $session->set('usuario', [
                'id' => $usuario['id'],
                'nome' => $usuario['nome'],
                'email' => $usuario['email']
            ]);
            return redirect()->to('/');
        } else {
            return redirect()->back()->with('erro', 'E-mail ou senha inválidos.');
        }
    }

    public function logout()
    {
        session()->remove('usuario');
        return redirect()->to('/');
    }

    public function register()
    {
        helper(['form']);
        $instituicaoModel = new \App\Models\InstituicaoModel();
        $instituicoes = $instituicaoModel->orderBy('nome', 'asc')->findAll();
        return view('auth/register', ['instituicoes' => $instituicoes]);
    }

    public function doRegister()
    {
        $model = new EventInscritosModel();
        $nome = $this->request->getPost('nome');
        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('senha');
        $instituicao_id = $this->request->getPost('instituicao_id');
        if ($model->where('email', $email)->first()) {
            return redirect()->back()->with('erro', 'E-mail já cadastrado.');
        }
        $model->insert([
            'nome' => $nome,
            'email' => $email,
            'senha' => password_hash($senha, PASSWORD_DEFAULT),
            'instituicao_id' => $instituicao_id
        ]);
        return redirect()->to('/login')->with('sucesso', 'Conta criada com sucesso! Faça login.');
    }

    public function forgot()
    {
        helper(['form']);
        return view('auth/forgot');
    }

    public function doForgot()
    {
        $model = new EventInscritosModel();
        $email = $this->request->getPost('email');
        $usuario = $model->where('email', $email)->first();
        if (!$usuario) {
            return redirect()->back()->with('erro', 'E-mail não encontrado.');
        }
        // Aqui você pode implementar o envio de e-mail real
        // Por enquanto, apenas simula a ação
        return redirect()->back()->with('sucesso', 'Se o e-mail existir, um link de recuperação foi enviado.');
    }
}
