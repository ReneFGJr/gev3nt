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
		$UserID = $Users->getCookie();

		$Events = new \App\Models\Event\Events();
		$sx .= view('header/header');
		$data = [];
		$data['navbar'] = view('header/navbar');
		if ($UserID == []) {
			$data['events'] = $Events->getEvents(0);
			$data['event'] = view('event_mini_show', $data);
		} else {
			//redirect()->to('main')->send();
			$id = $UserID['id_n'];
			$data['events'] = $Events->getEvents($id);
			$data['event'] = view('event_mini_show', $data);
		}

		$EventInscricoes = new \App\Models\Event\EventInscricoes();
		$data['event'] .= $EventInscricoes->showTypeInscricoes(2);

		$sx .= view('main', $data);
		return $sx;
	}

	function downloadDoc()
	{
		$ArticleDoc = new \App\Models\Docs\ArticleDoc();
		$id = get('doc');
		$idX = get('id');
		$ev = get('ev');
		$check = get('check');

		if ($id == '') {
			echo "ID do arquivo não encontrado";
			exit;
		}
		//$check = $ArticleDoc->md5check($file);

		if ($check != $check) {
			echo "Arquivo não encontrado";
			exit;
		}

		$dt = $ArticleDoc->where('id_doc', $id)->first();
		$file = $dt['doc_url'];
		if (!file_exists($file)) {
			echo "Arquivo não encontrado";
			exit;
		}

		header('Content-Type: application/pdf');
		header('Content-Disposition: attachment; filename="' . $file . '"');
		header('Content-Length: ' . filesize($file));
		readfile($file);
		exit;
	}

	function download()
		{
			$UploadDoc = new \App\Models\Docs\UploadDoc();
			$file = get('file');
			$check = get('check');
			$check2 = $UploadDoc->md5check($file);

			if ($check != $check2) {
				echo "Arquivo não encontrado";
				exit;
			}
			$dir = $UploadDoc->directory();
			$file = $dir . $file;
			if (!file_exists($file)) {
				echo "Arquivo não encontrado";
				exit;
			}

			header('Content-Type: application/pdf');
			header('Content-Disposition: attachment; filename="' . $file . '"');
			//header('Content-Transfer-Encoding: binary');
			header('Content-Length: ' . filesize($file));
			//header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Expires: 0');
			readfile($file);
			exit;
;
		}

	function sample($id=10)
	{
		// 1) Buscar dados (opcional)
		//$model = new WordAproved();
		//$data  = $model->find($id);
		$data = [];

		// 2) Caminhos para PEMs
		// Caminhos dos seus arquivos de chave/certificado e selo
		$certPem   = 'e:/certs/cert.pem';
		$keyPem    = 'e:/certs/key.pem';
		$keyPass   = '';               // vazio se sua chave não tiver senha
		$sealImage = 'e:/certs/selo.png';


		// 3) Verificação de leitura da chave privada
		$keyContents = file_get_contents($keyPem);
		if ($keyContents === false) {
			throw new \RuntimeException("Não conseguiu ler key.pem em {$keyPem}");
		}
		$private = openssl_pkey_get_private($keyContents, $keyPass);
		if ($private === false) {
			$err = openssl_error_string();
			throw new \RuntimeException("Falha ao carregar chave privada: {$err}");
		}
		// opcional: libera o recurso
		openssl_pkey_free($private);

		// 4) Instanciar TCPDF
		$pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator('Seu Sistema');
		$pdf->SetAuthor('Rene Faustino Gabriel Junior');
		$pdf->SetTitle('Trabalho #' . $id);
		$pdf->SetSubject('PDF Assinado Gov.br');

		$pdf->SetMargins(20, 20, 20);
		$pdf->SetAutoPageBreak(true, 20);
		$pdf->AddPage();

		// 5) Conteúdo do PDF
		$html  = '<h1>' . esc($data['titulo'] ?? 'Sem título') . '</h1>';
		$html .= '<p>Autor(es): ' . esc($data['autor'] ?? 'Desconhecido') . '</p>';
		$pdf->writeHTML($html, true, false, true, false, '');

		// 6) Dados da assinatura
		$info = [
			'Name'        => 'Rene Faustino Gabriel Junior',
			'Location'    => 'Porto Alegre, RS',
			'Reason'      => 'Assinatura Digital Gov.br',
			'ContactInfo' => 'rene.gabriel@ufrgs.br',
		];

		// 7) Configura assinatura com os arquivos PEM
		$pdf->setSignature(
			'file://' . realpath($certPem),
			'file://' . realpath($keyPem),
			$keyPass,
			'',
			2,
			$info
		);

		// placeholder visual
		$pdf->addEmptySignatureAppearance(15, 240, 50, 30);

		// Insere selo no canto inferior direito da página 1
		$pdf->Image($sealImage, 140, 240, 50, 50, 'PNG');

		// 8) Gera e retorna o PDF
		$output = $pdf->Output('', 'S');
		return $this->response
			->setHeader('Content-Type', 'application/pdf')
			->setBody($output);
	}

	function emailtest()
	{
		$EmailX = new \App\Models\IO\EmailX();
		echo $EmailX->sendEmail('renefgj@gmail.com', 'Teste de e-mail', 'Este é um teste de e-mail');
	}

	function payment($id)
	{
		$sx = '';
		$Events = new \App\Models\Event\Events();
		$Users = new \App\Models\User\Users();
		$CorporateBoard = new \App\Models\User\CorporateBoard();
		$EventInscritos = new \App\Models\Event\EventInscritos();
		$UploadFiles = new \App\Models\Event\UploadFile();

		$sx .= view('header/header');
		$data = [];
		$dt = [];
		$dt['url'] = 'payment';

		/************** Salva documento */
		if (isset($_FILES) and (count($_FILES) > 0)) {
			$valid_type = $UploadFiles->valid_type($_FILES['payment_proof']['type']);
			if ($valid_type == 1) {
				$dir = '../uploads/';
				// Verifica se o diretório existe antes de criar
				if (!is_dir($dir)) {
					mkdir($dir, 0777, true);
				}

				$fileID = 'payment_proof_' . str_pad($id, 8, "0", STR_PAD_LEFT). '.pdf';
				move_uploaded_file($_FILES['payment_proof']['tmp_name'], $dir . $fileID);
				$UploadFiles->saveDocument($dir . $fileID, $id, 'payment_proof');
			}
		}

		/****** Monta tela */
		$doc = $UploadFiles->recoverDocument($id, 'payment_proof');
		if ($doc != []) {
			$dtf = [];
			$dtf['files'] = $doc;
			$data['event'] = view('event/event_files', $dtf);
		} else {
			$dt['subscribe'] = $EventInscritos->getSubscribe($id);
			$data['event'] = view('event/event_comprovante_pagamento', $dt);
		}

		$data['navbar'] = view('header/navbar');

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

			/************** EMAIL */
			$EmailX = new \App\Models\IO\EmailX();
			$dataUser = $Users->getByEmail(get('email'));
			$dataUser['link'] = $dt['link'];

			$data['email'] = view('event/event_forgot_login_email', $dataUser);
			$EmailX->sendEmail(get('email'), 'Recuperação de senha', $data['email']);
		} else {
			if (get("email") != '') {
				$data['event'] .= '<div class="alert alert-danger">E-mail não encontrado - faça o <a href="'.base_url('signup'). '">cadastro</a>.</div>';
			}
		}
		$sx .= view('main', $data);
		return $sx;
	}

	function media($act='',$id='')
		{
			$sx = '';
			$Users = new \App\Models\User\Users();
			$UserID = $Users->getCookie();

			$Events = new \App\Models\Event\Events();
			$sx .= view('header/header');
			$data = [];
			$data['navbar'] = view('header/navbar');
			$Media = new \App\Models\Media\Index();
			$data['event'] = $Media->index($act, $id);

			$sx .= view('main', $data);
			return $sx;
		}


		function upload_presentation($id = 0)
	{
		$sx = '';
		$Users = new \App\Models\User\Users();
		$UserID = $Users->getCookie();

		$Events = new \App\Models\Event\Events();
		$sx .= view('header/header');
		$data = [];
		$data['navbar'] = view('header/navbar');

		$Media = new \App\Models\Media\Index();
		$data['event'] = $Media->index('upload', $id);

		if (isset($_FILES['media_file']) and (count($_FILES['media_file']) > 0)) {
			$valid_type = $Media->valid_type($_FILES['media_file']['type']);
			if ($valid_type == 1) {
				$dir = '../uploads/';
				// Verifica se o diretório existe antes de criar
				if (!is_dir($dir)) {
					mkdir($dir, 0777, true);
				}
				$IDf = 1;
				$fileID = 'presentation_' . str_pad($id, 8, "0", STR_PAD_LEFT) . '_' . $IDf . '.pdf';

				while (file_exists($dir . $fileID)) {
					$IDf++;
					$fileID = 'presentation_' . str_pad($id, 8, "0", STR_PAD_LEFT) . '_' . $IDf . '.pdf';
				}
				move_uploaded_file($_FILES['media_file']['tmp_name'], $dir . $fileID);
				$data['event'] .= '<div class="alert alert-success">Arquivo enviado com sucesso: ' . $fileID . '</div>';
				// Salva o documento
				$Media->saveDocument($dir . $fileID, $id, 'presentation');
				$data['event'] .= '<meta http-equiv="refresh" content="0;url=' . base_url('upload_presentation/' . $id) . '">';
			} else {
				$data['event'] .= '<div class="alert alert-danger">Tipo de arquivo inválido. Apenas PDF é permitido.</div>';
			}
		}

		$data['event'] .= $Media->upload_list($id);

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

		if ($dt == []) {
			$url = 'logoff';
			return redirect()->to($url);
		}

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

	function made_certificate($id)
		{
			$ev = 2;
			$Certificate = new \App\Models\Certificate\Index();
			$Certificate->makeCertificate($id, $ev);
			exit;
		}

	function made_certificate_other($id)
		{
			$ev = 2;
			$Certificate = new \App\Models\Certificate\CertificadoOutros();
			$Certificate->makeCertificate($id, $ev);
			exit;
		}

	function presentations($d1='', $d2='')
		{
			$sx = '';
			$sx = view('header/header');
			$sx .= view('header/event_header');

			switch ($d1) {
				case 'finished':

				case 'list':
					$Media = new \App\Models\Media\Index();
					$sx .= $Media->index('list', $d2);
					break;
				case 'upload':
					$Media = new \App\Models\Media\Index();
					$sx .= $Media->index('upload', $d2);
					break;
				case 'block':
					$Media = new \App\Models\Media\Index();
					$sx .= $Media->index('block', $d2);
					break;
				default:
					$Media = new \App\Models\Media\Index();
					$sx .= $Media->index('blocks', $d2);
			}

		return $sx;
		}

	function certificate()
		{
			$ev = 2;
			$Certificate = new \App\Models\Certificate\Index();
			$CertificadoOutros = new \App\Models\Certificate\CertificadoOutros();
			$sx = '';
			$sx .= view('header/header');
			$data = [];
			if (get("type") == '') { $_GET['type'] = '1'; }
			$data['navbar'] = view('header/navbar');
			$data['event'] = view('event/certificate/search');
			$ss = $Certificate->searchName(get('search'),$ev);
			$ss .= $CertificadoOutros->searchName(get('search'), $ev);
			$kw = get('search');

			if ($ss == '') {
				$ss = '<div class="alert alert-warning">Nenhum certificado encontrado com o nome "' . $kw . ', tente inserir somente a primeira letra do nome em maiúscula, ex: "João"</div>';
			}
			$data['event'] .= $ss;

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

		if ($UserID == []) {
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
		$idev = 2;
		$Events = new \App\Models\Event\Events();
		$sx = '';
		$sx .= view('header/header');
		$data = [];
		$data['navbar'] = view('header/navbar');

		$dt = $Events->programEvents($idev);

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
			if ($pass1 != '') {
				$data['event'] .= '<div class="alert alert-danger">As senhas não conferem</div>';
			}
			if ((strlen($pass1) < 6) and ($pass1 != '')) {
				$data['event'] .= '<div class="alert alert-danger">Senha muito curta</div>';
			}
		}
		$sx .= view('main', $data);
		return $sx;
	}

	function logoff()
	{
		$Users = new \App\Models\User\Users();
		$Users->logoff();
		$url = '';
		$sx = '';
		$sx .= view('header/header');
		$data = [];

		$dt = [];

		$data['navbar'] = view('header/navbar');
		$data['event'] = view('event_logoff.php', $dt);
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
			$dt['check_email'] = $Users->check_email(get('email'));
			$dt['check_cpf'] = $Users->check_cpf(get('cpf'));
			if (get("extrangeiro") == 1) {
				$dt['check_cpf'] = 0;
			}

			$data['navbar'] = view('header/navbar');

			if (($dt['check_email'] == 0) and ($dt['check_cpf'] == 0)) {
				$dt['n_nome'] = get('name');
				$dt['n_email'] = get('email');
				if (get('extrangeiro') == 1)
					{
						$dt['n_extrangeiro'] = 0;
						$dt['n_cpf'] = 'Extrangeiro';
					} else {
						$dt['n_extrangeiro'] = 0;
						$dt['n_cpf'] = get('cpf');
					}
				$dt['n_afiliacao'] = get('institution');
				$dt['n_badge_name'] = get('badge_name');

				$dt['n_password'] = md5(date("YmfHis") . get('email'));
				$dt['apikey'] = md5(date("YmfHis") . get('email'));
				$Users->set($dt)->insert();

				/************** EMAIL */
				$key = md5(date("YmdHis") . get('email'));
				$dt['link'] = base_url('setpassword?email=' . get('email') . '&key=' . $key);

				$EmailX = new \App\Models\IO\EmailX();
				$dataUser = $Users->getByEmail(get('email'));
				$dataUser['link'] = $dt['link'];

				$data['email'] = view('event/event_user_welcome_email', $dataUser);
				$data['event'] = view('event/event_user_welcome', $dataUser);
				$EmailX->sendEmail(get('email'), 'Cadastro de novo usuário', $data['email']);

				$sx .= view('main', $data);
				return $sx;
			}

		}

		/* CPF já existe */
		$data['navbar'] = view('header/navbar');
		$data['event'] = view('event/event_signup', $dt);
		if ($dt['check_email'] == 1) {
			$data['event'] .= '<div class="alert alert-danger">E-mail já cadastrado</div>';
		}
		if ($dt['check_cpf'] == 1) {
			$data['event'] .= '<div class="alert alert-danger">CPF já cadastrado</div>';
		}

		if ($dt['check_cpf'] == 9) {
			$data['event'] .= '<div class="alert alert-danger">CPF Inválido</div>';
		}
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
		if ($UserID == []) {
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
		$data['event'] = view('event/event_minhainscricoes', $dt);
		$data['event'] .= view('widget/icone_create', $dt);

		$sx .= view('main', $data);
		return $sx;
	}

	function signin()
	{
		$sx = '';
		$Events = new \App\Models\Event\Events();
		$Users = new \App\Models\User\Users();
		$CorporateBoard = new \App\Models\User\CorporateBoard();

		$dtu = $Users->getCookie();
		/************ Já esta logado */
		if ($dtu != []) {
			$url = '';
			return redirect()->to($url);
		}

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
		if ($dt['check_password'] == 1) {
			//$url = 'main';
			//return redirect()->to($url);
			$data['event'] = view('event_signin_ok.php', $dt);
		} else {
			if (get("email") != '') {
				$data['event'] .= '<div class="alert alert-danger">Usuário ou senha inválidos</div>';
			}
		}

		$sx .= view('main', $data);
		return $sx;
	}
}
