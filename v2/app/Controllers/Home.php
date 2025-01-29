<?php

namespace App\Controllers;

helper("sisdoc");
helper("nbr");

class Home extends BaseController
{
	public function index(): string
	{
		$sx = '';
		$Users = new \App\Models\User\Users();

		$Events = new \App\Models\Event\Events();
		$sx .= view('header/header');
		$data = [];
		$data['navbar'] = view('header/navbar');
		$data['events'] = $Events->getEvents();
		$data['event'] = view('event_mini_show', $data);
		$sx .= view('main', $data);
		return $sx;
	}

	function forgot_user()
	{
		$sx = '';
		$Events = new \App\Models\Event\Events();
		$Users = new \App\Models\User\Users();
		$CorporateBoard = new \App\Models\User\CorporateBoard();
		$sx .= view('header/header');
		$data = [];
		$dt = [];
		$dt['url'] = 'novasenha';
		if (get("email") != '') {
			$dt['check_email'] = $Users->check_email(get('email'));
		} else {
			$dt['check_email'] = -1;
		}

		if (get("cpf") != '') {
			$dt['check_cpf'] = $Users->check_cpf(get('cpf'));
		} else {
			$dt['check_cpf'] = -1;
		}

		$data['navbar'] = view('header/navbar');
		$data['event'] = view('event_forgot_login.php', $dt);

		if ($dt['check_email'] == 1) {
			$key = md5(date("YmdHis") . get('email'));
			$dt['link'] = base_url('setpassword?email=' . get('email') . '&key=' . $key);
			$data['event'] = view('event_forgot_login_send.php', $dt);
		}
		$sx .= view('main', $data);
		return $sx;
	}

	function profile()
	{
		$Users = new \App\Models\User\Users();
		$dt = $Users->getCookie();
		if ($dt == []) {
			redirect(base_url('signin'));
		}
		$id = $dt['id_n'];
		$dt = $Users->getUserId($id);

		$sx = '';
		$sx .= view('header/header');

		$data['navbar'] = view('header/navbar');
		$data['event'] = view('user/profile', $dt);
		$sx .= view('main', $data);

		return $sx;
	}

	function meuseventos_calendar()
	{
		$sx = '';
		$sx .= view('header/header');
		$data = [];
		$data['navbar'] = view('header/navbar');
		$dt = [];
		$dd = [];
		$dd['titulo'] = 'ISKO brasil';
		$dd['descricao'] = 'Evento de teste';
		$dd['data_inicio'] = '2025-02-01';
		$dd['data_fim'] = '2025-02-05';

		$dt['eventos'][] = $dd;
		$data['event'] = view('event/event_meuseventos', $dt);
		$sx .= view('main', $data);
		return $sx;
	}

	function subscribe_confirm($id, $check)
	{
		$sx = '';
		$sx .= view('header/header');
		$data = [];
		$data['navbar'] = view('header/navbar');
		$data['event'] = view('event/event_subscribe_confirm');
		$sx .= view('main', $data);
		return $sx;
	}

	function subscribe($id, $lote = 0)
	{
		$User = new \App\Models\User\Users();
		$Event = new \App\Models\Event\Events();
		$EventInscricoes = new \App\Models\Event\EventInscricoes();
		$EventInscritos = new \App\Models\Event\EventInscritos();

		$UserID = $User->getCookie();
		if ($UserID == [])
		{
			$url = 'signin';
			return redirect()->to($url);
		}

		$dte = $Event->find($id);
		$dti = $EventInscricoes->lotesInscricoes($id);

		$sx = '';
		$sx .= view('header/header');
		$data = [];
		$data['navbar'] = view('header/navbar');
		$dt = [];
		$dt['event'] = $dte;
		$dt['lotes'] = $dti;
		$data['event'] = view('event/event_header', $dt);
		if ($lote == 0) {
			$data['event'] .= view('event/event_iscricoes_lotes', $dt);
		} else {
			$dt['lote'] = $EventInscricoes->getLote($lote);
			$ev = get("lote");
			if ($ev != '') {
				$ok = 1;
				if ($dt['lote'][0]['el_matricula'] == 1) {
					if (!isset($_FILES['comprovante']['tmp_name'])) {
						$ok = 0;
					}
				}
				/******************* Confirma Inscrição */
				if ($ok == 1) {
					$UserData = $User->getCookie();
					$UserId = $UserData['id_n'];
					$rsp = $EventInscritos->subscribe($UserId, $id, $lote);
					if ($rsp > 0) {
						$url = 'subscribe_confirm/' . $rsp . '/' . md5($rsp . $lote);
						return redirect()->to($url);
						exit;
					} else {
						$dt['message'] = 'Problema ao gravar inscrição';
					}
				}
			}
			$data['event'] .= view('event/event_iscricoes_subscript', $dt);
		}

		$sx .= view('main', $data);
		return $sx;
	}


	function meuseventos()
	{
		$sx = '';
		$sx .= view('header/header');
		$data = [];
		$data['navbar'] = view('header/navbar');
		$dt = [];

		$data['event'] = view('event/event_meuseventos', $dt);
		$sx .= view('main', $data);
		return $sx;
	}

	function setpassword()
	{
		$sx = '';
		$Events = new \App\Models\Event\Events();
		$Users = new \App\Models\User\Users();
		$CorporateBoard = new \App\Models\User\CorporateBoard();
		$sx .= view('header/header');
		$data = [];
		$dt = $Users->getByEmail(get('email'));

		$dt['url'] = 'setpassword';
		$dt['check_email'] = 0;
		$dt['check_cpf'] = 0;
		$dt['check_key'] = 0;

		$data['navbar'] = view('header/navbar');
		$dt['check_password'] = -1;

		if (get("email") != '') {
			$dt['check_email'] = $Users->check_email(get('email'));
		} else {
			$dt['check_email'] = -1;
		}

		$pass1 = get("pass1");
		$pass2 = get("pass2");
		if (($pass1 == $pass2) and (strlen($pass1) >= 6)) {
			$dt['check_password'] = 1;
			$Users->updatePassword($dt['id_n'], md5($pass1));
			$data['event'] = view('event_set_password_send', $dt);
		} else {
			$data['event'] = view('event_set_password', $dt);
			if ($pass1 != '')
				{
					$data['event'] .= '<div class="alert alert-danger">As senhas não conferem</div>';
				}
			if (strlen($pass1) < 6)
				{
					$data['event'] .= '<div class="alert alert-danger">Senha muito curta</div>';
				}
		}
		$sx .= view('main', $data);
		return $sx;
	}

	function signup()
	{
		$sx = '';
		$Events = new \App\Models\Event\Events();
		$Users = new \App\Models\User\Users();
		$CorporateBoard = new \App\Models\User\CorporateBoard();
		$sx .= view('header/header');
		$data = [];


		$dt = [];
		$dt['url'] = 'signup';
		$dt['check_email'] = 0;
		$dt['check_cpf'] = 0;

		$dt['corporateBoard'] = $CorporateBoard->select(get("institution"));

		/************** Regras */
		/* E-mail já existe */
		if ($_POST != []) {
			$_POST['name'] = nbr_author(get("name"), 7);
			$dt['check_email'] = $Users->check_email($_POST['email']);
			$dt['check_cpf'] = $Users->check_cpf($_POST['cpf']);
		}

		/* CPF já existe */

		$data['navbar'] = view('header/navbar');
		$data['event'] = view('event_cadastro.php', $dt);
		$sx .= view('main', $data);
		return $sx;
	}

	function main()
		{
			$sx = '';
			$Events = new \App\Models\Event\Events();
			$Users = new \App\Models\User\Users();
			$CorporateBoard = new \App\Models\User\CorporateBoard();
			$EventInscritos = new \App\Models\Event\EventInscritos();
			$UserID = $Users->getCookie();
			if ($UserID == [])
			{
				$url = 'signin';
				return redirect()->to($url);
			}
			$sx .= view('header/header');
			$data = [];
			$dt = [];
			$dt['url'] = 'main';

			$data['navbar'] = view('header/navbar');

			$dt = [];
			$dt['futureEvents'] = $EventInscritos->myInscritos($UserID['id_n']);
			$data['event'] = view('event/event_minhainscricoes',$dt);
			$data['event'] .= view('widget/icone_create',$dt);

			$sx .= view('main', $data);
			return $sx;
		}

	function signin()
	{
		$sx = '';
		$Events = new \App\Models\Event\Events();
		$Users = new \App\Models\User\Users();
		$CorporateBoard = new \App\Models\User\CorporateBoard();
		$sx .= view('header/header');
		$data = [];
		$dt = [];
		$dt['url'] = 'signin';
		$dt['check_email'] = $Users->check_email(get('email'));
		$dt['check_password'] = 0;

		$data['navbar'] = view('header/navbar');

		if ($dt['check_email'] == 1) {
			$dt['check_password'] = $Users->signin(get('email'), get('password'));
			$data['event'] = view('event_signin.php', $dt);
		} else {
			$data['event'] = view('event_signin.php', $dt);
		}
		if ($dt['check_password'] == 1)
			{
				$url = 'main';
				return redirect()->to($url);
			}

		$sx .= view('main', $data);
		return $sx;
	}
}
