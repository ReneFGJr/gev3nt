<?php

namespace App\Controllers;

helper("sisdoc");
helper("nbr");

class Home extends BaseController
{
	public function index(): string
	{
		$sx = '';

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
			$data['event'] = view('event_forgot_login_send.php', $dt);
		}
		$sx .= view('main', $data);
		return $sx;
	}

	function signup($id)
	{
		$sx = '';
		$Events = new \App\Models\Event\Events();
		$Users = new \App\Models\User\Users();
		$CorporateBoard = new \App\Models\User\CorporateBoard();
		$sx .= view('header/header');
		$data = [];


		$dt = $Events->find($id);
		$dt['url'] = 'inscrever/' . $id;
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

		$data['navbar'] = view('header/navbar');
		$data['event'] = view('event_signin.php', $dt);


		if ($dt['check_email'] == 1)
			{
				$RSP = $Users->signin(get('email'), get('password'));
				echo '=========='.$RSP;
			}

		$sx .= view('main', $data);
		return $sx;
	}
}
