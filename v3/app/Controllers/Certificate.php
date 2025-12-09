<?php

namespace App\Controllers;

helper("sisdoc");
helper("nbr");


class Certificate extends BaseController
{
	public function index($action = ''): string
	{
		$sx = '';
		$Users = new \App\Models\User\Users();
		$UserID = $Users->getCookie();

		$sx .= view('header/header');
		$data = [];
		$data['navbar'] = view('header/navbar');


		switch ($action) {
			case 'import':
				$data['event'] = $this->import_names();
				break;
			case 'admin':
				break;
			case 'emitir':
				$this->emitir();
				break;				
			default:
				if ($UserID == []) {
					$data['event'] = $this->form_events();
				} else {
					//redirect()->to('main')->send();
					$id = $UserID['id_n'];
					$data['event'] = $this->form_events();
				}
				break;
		}


		//$data['event'] = "Dados";

		$sx .= view('main', $data);
		return $sx;
	}

	function emitir()
	{
		$id = get("id");
		$EventCertificateModel = new \App\Models\Certificate\Avulso\EventCertificateModel();
		$EventCertificateModel->emitir($id);
	}	

	function import_names()
	{
		$EventPeopleModel = new \App\Models\Certificate\Avulso\EventPeopleModel();
		$EventCertificateEmitModel = new \App\Models\Certificate\Avulso\EventCertificateEmitModel();
		$certificado_model = 1;

		$sx = '';
		
		$data = get('data');
		$data = troca($data,'"','');
		$data = troca($data,"\t",';');
		$data = troca($data,"\r","\n");

		$row = explode("\n", $data);
		foreach ($row as $r) {
			$col = explode(";", $r);
			if (!isset($col[1])) {
				continue;
			}
			$name = trim($col[0]);
			$email = trim($col[1]);
			if (($name != '') and ($email != '') and (strpos($email,'@') > 0)) {
				$dt = [];
				$dt['name'] = $name;
				$dt['email'] = $email;			
				
				$idp = $EventPeopleModel->add_person($dt);
				$dt['ece_person'] = $idp;
				$dt['ece_certificate'] = $certificado_model;
				$EventCertificateEmitModel->add_certificate($dt);

				$sx .= 'Importado: ' . $name . ' - ' . $email . '<br>';
			}
		}	

		if (isset($data[''])) {
			$sx = view('certificate/avulso/form_import');
		}
		
		return $sx;
	}

	function form_events()
	{
		$sx = view('certificate/avulso/form_events');
		return $sx;
	}
}
