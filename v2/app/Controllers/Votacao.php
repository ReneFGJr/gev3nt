<?php

namespace App\Controllers;

use App\Models\VotoModel;

helper("sisdoc");
helper("nbr");

class Votacao extends BaseController
{
	public function email()
	{
		$sx = view('header/header');
		if ($_POST)
		{
			$email = get("email");
			$Users = new \App\Models\User\Isko();
			$dt = $Users->where('mb_email', $email)->first();

			if (!$dt) {
				return $sx . view('votacao/mensagem', ['mensagem' => 'Sócio não encontrado']);
			}

			$dt['n_nome'] = $dt['mb_name'];
			$dt['mb_nome'] = $dt['mb_name'];
			$dt['n_email'] = $dt['mb_email'];
			$dt['e_name'] = 'VIII Isko Brasil';
			$dt['e_email'] = 'isko@isko.org.br';
			$dt['n_cpf'] = '';
			$dt['cb_created'] = '';
			$dt['link'] = base_url('votacao/autenticar?id_nb=' . $dt['mb_token']);

			$Message = new \App\Models\Messages\Index();
			$txt = $Message->messages(8, $dt);

			$Email = new \App\Models\IO\EmailX();
			$email = $dt['mb_email'];
			$subject = 'VIII Isko Brasil - Votação para a diretoria';

			$rsp = $Email->sendEmail($email, $subject,$txt);
			$sx .= view('votacao/mensagem', ['mensagem' => 'E-mail enviado com sucesso para ' . $dt['mb_name'] ]);
			return $sx;
		} else {
			return $sx . view('votacao/votacao_email');
		}

	}

	public function index()
	{
		$sx = view('header/header');
		return $sx . view('votacao/login');
	}

	function list()
	{
		$this->codify();
		$sx = view('header/header');
		$data = [];
		$data['navbar'] = view('header/navbar');

		$Isko = new \App\Models\User\Isko();
		$users = $Isko->findAll();

		pre($users);

		return $sx . view('votacao/lista', ['users' => $users]);
	}

	public function codify()
		{
			$users = new \App\Models\User\Isko();
			$dt = $users
				->where('mb_token','')
				->Orwhere('mb_token is null')
				->findAll();

			foreach ($dt as $d) {
				$md5 = md5($d['id_nb'].'key29323d');
				$dd= [];
				$dd['mb_token'] = $md5;
				$users->set($dd)->where('id_nb',$d['id_nb'])->update();
			}
		return '';
		}
	public function autenticar()
	{
		$this->codify();
		$id = get('id_nb');


		$Users = new \App\Models\User\Isko();
		$socio = $Users->where('mb_token', $id)->first();

		$sx = view('header/header');
		$data = [];
		$data['navbar'] = view('header/navbar');

		if ($socio) {
			$votoModel = new \App\Models\VotoModel();
			if ($votoModel->where('id_socio', $id)->first()) {
				return $sx . view('votacao/mensagem', ['mensagem' => 'Você já votou!']);
			}

			session()->set('id_nb', $id);
			$chapaModel = new \App\Models\ChapaModel();
			$chapas = $chapaModel->findAll();

			return $sx . view('votacao/votar', ['chapas' => $chapas, 'socio' => $socio]);
		}

		return view('votacao/mensagem', ['mensagem' => 'Sócio não encontrado']);
	}

	public function votar()
	{
		$sx = '';
		$sx = view('header/header');

		$idChapa = $this->request->getPost('id_chapa');
		$idSocio = get('id_nb');

		$votoModel = new VotoModel();
		try {
			$votoModel->insert(['id_socio' => $idSocio, 'id_chapa' => $idChapa]);
			return $sx . view('votacao/mensagem', ['mensagem' => 'Voto registrado com sucesso!']);
		} catch (\Exception $e) {
			return $sx . view('votacao/mensagem', ['mensagem' => 'Erro: Você já votou.']);
		}
	}
}
