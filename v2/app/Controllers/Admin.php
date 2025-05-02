<?php

namespace App\Controllers;

helper("sisdoc");
helper("nbr");
helper("nbrtitle");

class Admin extends BaseController
{
	public function index($a1 = '', $a2 = '', $a3 = ''): string
	{
		$EventInscritos = new \App\Models\Event\EventInscritos();
		$sx = '';
		$Users = new \App\Models\User\Users();
		$UserID = $Users->getCookie();

		$Events = new \App\Models\Event\Events();
		$sx .= view('header/header');
		$data = [];
		$data['navbar'] = view('header/navbar');
		if ($UserID == []) {
			$sx .= view('login', $data);
		} else {
			if (($UserID['id_n'] != 1) and ($UserID['id_n'] != 239)) {
				echo "Forbiden";
				exit;
			}
			$ide = 2;
			//redirect()->to('main')->send();
			$id = $UserID['id_n'];
			$data['events'] = $Events->getEvents($id);
			$data['event'] = view('admin/menu', $data);
			$dt = [];
			$ev = 2;

			switch ($a1) {
				/**********************	Admin  */
				case 'authors':
					$Publications = new \App\Models\OJS\Publications();
					$data['event'] .= $Publications->authors($ev);
					break;
				case 'import':
					$Publications = new \App\Models\OJS\Publications();
					$data['event'] .= $Publications->import();
					break;
				case 'works':
					$Publications = new \App\Models\OJS\Publications();
					$ev = 2;
					$data['event'] .= $Publications->works($ev);
					break;
				case 'work':
					$Publications = new \App\Models\OJS\Publications();
					$data['event'] .= $Publications->work($a2, $ev);
					$ApiOJS = new \App\Models\OJS\Api();
					if (get("update") != '') {
						$dt = $ApiOJS->updateDB($a2);
						$redirect = '<script>window.location.href ="/admin/work/' . $a2 . '";</script>';
						return $redirect;
					}
					break;
				/**********************	Inscições  */
				case 'inscricoes':
					switch ($a2) {
						case 'validar':
							$dt = [];
							$dt['inscricoes'] = $EventInscritos->getInscritos($ide);
							$data['event'] = view('admin/inscricoes_validar', $dt);
							break;
						case 'check':
							$dt['data'] = $EventInscritos->getInscricao($a3);
							$dt['action'] = true;
							$data['event'] = view('admin/inscricao', $dt);
							break;
						case 'view':
							$dt['data'] = $EventInscritos->getInscricao($a3);
							$dt['action'] = false;
							$data['event'] = view('admin/inscricao', $dt);
							break;

						case 'checked':
							$dt['action'] = false;
							$dt['data'] = $EventInscritos->getInscricao($a3);
							$data['event'] .= view('admin/inscricao', $dt);

							if ($dt['data']['ein_recibo'] == '') {
								/********************************** Acoes */
								/********************************** Enviar e-mail */
								$EmailX = new \App\Models\IO\EmailX();
								$email = $dt['data']['n_email'];
								$txto = $EventInscritos->messages(1, $dt['data']);
								$rsp = $EmailX->sendEmail($email, 'Confirmação de pagamento', $txto);


								/*********************************** Atualiza banco de Dados */
								$EventInscritos->where('id_ein', $a3)
									->set('ein_recibo', 1)
									->set('ein_pago', date("Y-m-d H:i:s"))
									->set('ein_pago', 1)
									->update();
								$data['event'] .= '<li>' . $rsp . '</li>';
								$data['event'] .= '<li>Inscrição confirmada</li>';
							} else {
								$data['event'] .= '<li>Validação de pagamento já realizada</li>';
							}
							break;
						default:
							$data['event'] .= view('admin/main', $data);
							break;
					}
			}
		}

		$sx .= view('main', $data);
		return $sx;
	}
}
