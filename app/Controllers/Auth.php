<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\EventsNamesModel;
use App\Models\UsersModel;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */

helper(['url', 'form']);

class Auth extends BaseController
{
    public function doRegister()
    {
        $model = new UsersModel();
        $nome = $this->request->getPost('n_nome');
        $email = $this->request->getPost('n_email');
        $cracha = $this->request->getPost('n_cracha');
        $cpf = $this->request->getPost('n_cpf');
        $orcid = $this->request->getPost('n_orcid');
        $afiliacao = $this->request->getPost('n_afiliacao');
        $senha = $this->request->getPost('n_password');
        $senha2 = $this->request->getPost('n_password_confirm');

        // Validação básica
        if ($senha !== $senha2) {
            return redirect()->back()->with('erro', 'As senhas não conferem.');
        }
        if ($model->where('n_email', $email)->first()) {
            return redirect()->back()->with('erro', 'E-mail já cadastrado.');
        }
        if ($model->where('n_cpf', $cpf)->first()) {
            return redirect()->back()->with('erro', 'CPF já cadastrado.');
        }

        $dados = [
            'n_nome' => $nome,
            'n_email' => $email,
            'n_cracha' => $cracha,
            'n_cpf' => $cpf,
            'n_orcid' => $orcid,
            'n_afiliacao' => $afiliacao,
            'n_password' => password_hash($senha, PASSWORD_DEFAULT)
        ];

        if ($model->insert($dados)) {
            return redirect()->to('/auth/login')->with('sucesso', 'Cadastro realizado com sucesso! Faça login.');
        } else {
            return redirect()->back()->with('erro', 'Erro ao cadastrar. Tente novamente.');
        }
    }

    public function register()
    {
        $instituicaoModel = new \App\Models\InstituicaoRorModel();
        $instituicoes = $instituicaoModel->orderBy('nome', 'asc')->findAll();
        return view('auth/register', ['instituicoes' => $instituicoes]);
    }

    public function logout()
    {
        $session = session();
        $session->remove('usuario');
        return redirect()->to('/');
    }
    public function doLogin()
    {
        $email = $this->request->getPost('n_email');
        $senha = $this->request->getPost('n_password');
        $model = new UsersModel();
        $usuario = $model->where('n_email', $email)->first();
        if ($usuario && password_verify($senha, $usuario['n_password'])) {
            $session = session();
            $session->set('usuario', [
                'id' => $usuario['id_n'],
                'nome' => $usuario['n_nome'],
                'email' => $usuario['n_email']
            ]);
            return redirect()->to('/');
        } else {
            return redirect()->back()->with('erro', 'E-mail ou senha inválidos.');
        }
    }

    public function doResetPassword()
    {
        $token = $this->request->getPost('token');
        $senha = $this->request->getPost('n_password');
        $senha2 = $this->request->getPost('n_password_confirm');
        if (!$token) {
            return redirect()->to('/auth/login')->with('erro', 'Token inválido.');
        }
        if ($senha !== $senha2) {
            return redirect()->back()->with('erro', 'As senhas não conferem.');
        }
        $model = new UsersModel();
        $usuario = $model->where('reset_token', $token)
            ->where('reset_token_expires >=', date('Y-m-d H:i:s'))
            ->first();
        if (!$usuario) {
            return redirect()->to('/auth/login')->with('erro', 'Token expirado ou inválido.');
        }
        $model->update($usuario['id_n'], [
            'n_password' => password_hash($senha, PASSWORD_DEFAULT),
            'reset_token' => null,
            'reset_token_expires' => null
        ]);
        return redirect()->to('/auth/login')->with('sucesso', 'Senha redefinida com sucesso! Faça login.');
    }

    public function resetPassword()
    {
        $token = $this->request->getGet('token');
        if (!$token) {
            return redirect()->to('/auth/login')->with('erro', 'Token inválido.');
        }
        $model = new UsersModel();
        $usuario = $model->where('reset_token', $token)
            ->where('reset_token_expires >=', date('Y-m-d H:i:s'))
            ->first();
        if (!$usuario) {
            return redirect()->to('/auth/login')->with('erro', 'Token expirado ou inválido.');
        }
        return view('auth/reset_password', ['token' => $token]);
    }

    public function doForgot()
    {
        $model = new UsersModel();
        $email = $this->request->getPost('n_email');
        $usuario = $model->where('n_email', $email)->first();

        if (!$usuario) {
            return redirect()->back()->with('erro', 'E-mail não encontrado.');
        }

        // Gerar token de redefinição
        helper('text');
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $model->update($usuario['id_n'], [
            'reset_token' => $token,
            'reset_token_expires' => $expires
        ]);

        $resetLink = base_url('auth/resetar-senha?token=' . $token);

        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setFrom(getenv('email.fromEmail'), getenv('email.fromName'));
        $emailService->setSubject('Recuperação de senha - Gev3nt');
        $emailService->setMessage(
            '<p>Olá, ' . esc($usuario['n_nome']) . '.</p>' .
                '<p>Você solicitou a redefinição de senha para o sistema Gev3nt.</p>' .
                '<p><a href="' . $resetLink . '" style="background:#1976d2;color:#fff;padding:10px 24px;border-radius:6px;text-decoration:none;">Clique aqui para criar uma nova senha</a></p>' .
                '<p>Este link é válido por 1 hora.</p>' .
                '<p>Se não foi você, ignore este e-mail.</p>'
        );

        if ($emailService->send()) {
            return redirect()->back()->with('sucesso', 'Se o e-mail existir, um link de redefinição foi enviado.');
        } else {
            return redirect()->back()->with('erro', 'Erro ao enviar o e-mail.');
        }
    }

    public function forgot()
    {
        return view('auth/forgot');
    }

    public function login()
    {
        return view('auth/login');
    }
}
