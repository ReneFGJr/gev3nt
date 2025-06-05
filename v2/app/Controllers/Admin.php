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
			$sx .= '<meta http-equiv="refresh" content="0; url=' . base_url('/signin') . '">';
			return $sx;
			exit;
		} else {
			if (($UserID['id_n'] != 1) and ($UserID['id_n'] != 2) and ($UserID['id_n'] != 239)) {
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
				case 'sessions':
					$EventSchedule = new \App\Models\Event\EventSchedule();
					$data['event'] .= $EventSchedule->sessions($ev);
					break;
				case 'session_ed':
					$EventSchedule = new \App\Models\Event\EventSchedule();
					$data['event'] .= $EventSchedule->session_ed($a2, $ev);
					break;
				case 'accepts':
					$ArticleDoc = new \App\Models\Docs\ArticleDoc();
					$data['event'] .= $ArticleDoc->accepts($ev);
					break;
				case 'summary':
					$EventInscritos = new \App\Models\Event\EventInscritos();
					$data['event'] .= $EventInscritos->summary($ev);
					break;
				case 'docs_email':
					$id = get('id');
					$ArticleDoc = new \App\Models\Docs\ArticleDoc();
					$dt = $ArticleDoc->email_enviar($id);
					$redirect = '<script>window.location.href ="' . base_url('/admin/work/' . $id) . '";</script>';
					return $redirect;
					break;

					break;
				case 'docs_emitir':
					$id = get('id');
					$ArticleDoc = new \App\Models\Docs\ArticleDoc();
					$dt = $ArticleDoc->emitir($id);
					$redirect = '<script>window.location.href ="' . base_url('/admin/work/' . $id) . '";</script>';
					return $redirect;
					break;
				/**********************	Admin  */
				case 'authors':
					$Publications = new \App\Models\OJS\Publications();
					$data['event'] .= $Publications->authors($ev);
					break;
				case 'import':
					$Publications = new \App\Models\OJS\Publications();
					$data['event'] .= $Publications->import();
					break;
				case 'import_api':
					$Publications = new \App\Models\OJS\Publications();
					$data['event'] .= $Publications->import_ojs();
					break;
				case 'workEventSchedule':
					$a4 = get('id_esb');
					$Publications = new \App\Models\OJS\Publications();
					$dt = $Publications->workEventSchedule($a2, $a3, $a4);
					$redirect = '<script>window.location.href ="' . base_url('/admin/work/' . $a2) . '";</script>';
					return $redirect;
					break;
				case 'workEventCancel':
					$Publications = new \App\Models\OJS\Publications();
					$dt = $Publications->workEventCancel($a2, $a3);
					$redirect = '<script>window.location.href ="' . base_url('/admin/work/' . $a2) . '";</script>';
					return $redirect;
					break;
				case 'workEvent':
					$Publications = new \App\Models\OJS\Publications();
					$EventSchedule = new \App\Models\Event\EventSchedule();
					$ev = 2;
					/* Aprova os trabalhos com status "Aceito" */
					$Publications->check_status($ev);
					$data['event'] .= $Publications->workHeader($a2,$ev);
					$data['event'] .= $EventSchedule->programSchedule($a2, $ev);
					break;
				case 'works':
					$Publications = new \App\Models\OJS\Publications();
					$ev = 2;
					/* Aprova os trabalhos com status "Aceito" */
					$Publications->check_status($ev);
					$data['event'] .= $Publications->summary($ev);
					$data['event'] .= $Publications->works($ev);
					break;
				case 'work':
					$Publications = new \App\Models\OJS\Publications();
					$data['event'] .= $Publications->work($a2, $ev);
					$ApiOJS = new \App\Models\OJS\Api();
					if (get("update") != '') {
						$dt = $ApiOJS->updateDB($a2);
						$redirect = '<script>window.location.href ="'.base_url('/admin/work/' . $a2) . '";</script>';
						return $redirect;
					}
					break;
				/**********************	Inscições  */
				case 'inscricoes':
					switch ($a2) {
						case 'email_alert':
							$data['event'] .= $EventInscritos->email_alert($a3);
							break;
						case 'validar':
							$dt = [];
							$dt['inscricoes'] = $EventInscritos->getInscritos($ide);
							$data['event'] .= view('admin/inscricoes_validar', $dt);
							break;
						case 'validar2':
							$dt = [];
							$dt['inscricoes'] = $EventInscritos->getInscritos($ide,2);
							$data['event'] .= view('admin/inscricoes_validar_2', $dt);
							break;
						case 'check':
							$Upload = new \App\Models\Docs\UploadDoc();
							$dt['data'] = $EventInscritos->getInscricao($a3);
							$dt['action'] = true;
							$data['event'] .= view('admin/inscricao', $dt);
							$data['event'] .= $Upload->show($a3);
							break;
						case 'view':
							$dt['data'] = $EventInscritos->getInscricao($a3);
							$dt['action'] = false;
							$data['event'] .= view('admin/inscricao', $dt);
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
