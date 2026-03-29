<?php
namespace App\Controllers;

use App\Models\EventsNamesModel;
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
        $model = new EventsNamesModel();
        $email = $this->request->getPost('n_email');
        $senha = $this->request->getPost('n_password');
        $usuario = $model->where('n_email', $email)->first();
        if ($usuario && password_verify($senha, $usuario['n_password'])) {
            $session->set('usuario', [
                'id' => $usuario['id'],
                'nome' => $usuario['n_nome'],
                'email' => $usuario['n_email']
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
        $model = new EventsNamesModel();
        $nome = $this->request->getPost('n_nome');
        $email = $this->request->getPost('n_email');
        $senha = $this->request->getPost('n_password');
        $senha2 = $this->request->getPost('n_password_confirm');
        $cracha = $this->request->getPost('n_cracha');
        $cpf = $this->request->getPost('n_cpf');
        $orcid = $this->request->getPost('n_orcid');
        $afiliacao = $this->request->getPost('n_afiliacao');
        if ($model->where('n_email', $email)->first()) {
            return redirect()->back()->with('erro', 'E-mail já cadastrado.');
        }
        if ($senha !== $senha2) {
            return redirect()->back()->with('erro', 'As senhas não conferem.');
        }
        $model->insert([
            'n_nome' => $nome,
            'n_email' => $email,
            'n_password' => password_hash($senha, PASSWORD_DEFAULT),
            'n_cracha' => $cracha,
            'n_cpf' => $cpf,
            'n_orcid' => $orcid,
            'n_afiliacao' => $afiliacao
        ]);
        return redirect()->to('/auth/login')->with('sucesso', 'Conta criada com sucesso! Faça login.');
    }

    public function forgot()
    {
        helper(['form']);
        return view('auth/forgot');
    }

    public function doForgot()
    {
        $model = new EventsNamesModel();
        $email = $this->request->getPost('n_email');
        $usuario = $model->where('n_email', $email)->first();

        if (!$usuario) {
            return redirect()->back()->with('erro', 'E-mail não encontrado.');
        }

        // Enviar a senha por e-mail (NUNCA recomendado em produção, apenas para exemplo)
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setFrom(getenv('email.fromEmail'), getenv('email.fromName'));
        $emailService->setSubject('Recuperação de senha - Gev3nt');
        $emailService->setMessage(
            '<p>Olá, ' . esc($usuario['n_nome']) . '.</p>' .
            '<p>Você solicitou a recuperação de senha para o sistema Gev3nt.</p>' .
            '<p><strong>Sua senha criptografada é:</strong></p>' .
            '<p>' . esc($usuario['n_password']) . '</p>' .
            '<p>Se não foi você, ignore este e-mail.</p>'
        );

        if ($emailService->send()) {
            return redirect()->back()->with('sucesso', 'Se o e-mail existir, a senha foi enviada.');
        } else {
            return redirect()->back()->with('erro', 'Erro ao enviar o e-mail.');
        }
    }
}
