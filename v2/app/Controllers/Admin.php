<?php

namespace App\Controllers;

helper("sisdoc");
helper("nbr");

class Admin extends BaseController
{
	public function index($a1='',$a2='', $a3=''): string
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
			$ide = 2;
			//redirect()->to('main')->send();
			$id = $UserID['id_n'];
			$data['events'] = $Events->getEvents($id);
			$data['event'] = view('admin/menu', $data);
			$dt = [];

			switch ($a1) {
				case 'inscricoes':
					switch ($a2) {
						case 'validar':
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
							/********************************** Acoes */
							$EventInscritos->where('id_ein', $a3)
								->set('ein_recibo', 1)
								->set('ein_pago', date("Y-m-d H:i:s"))
								->set('ein_pago', 1)
								->update();
							$data['event'] = view('admin/inscricao', $dt);
							break;
						default:

							break;
					}

					break;
				default:
					$data['event'] .= view('admin/main', $data);
					break;
			}

			$sx .= view('main', $data);
		}
		return $sx;
	}


}
