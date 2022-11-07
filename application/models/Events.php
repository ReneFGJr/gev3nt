<?php
define("PATH", "index.php/main/evento/");
define("LIBRARY_NAME", "G-Ev3nto");
class events extends CI_model
{
	var $table = 'events';
	function header($data)
	{
		$sx = '';
		$icone = base_url('img/gev3nt') . '/favicon.png';
		$sx .= '<head>' . cr();
		$sx .= '<title>' . msg("G-Ev3nto") . '</title>';
		$sx .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">' . cr();
		$sx .= '<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>' . cr();
		$sx .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>' . cr();
		$sx .= '' . cr();
		$sx .= '<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>' . cr();
		$sx .= '<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>' . cr();
		$sx .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>' . cr();
		$sx .= '' . cr();
		$sx .= '<link rel="icon" href="' . $icone . '" />';
		$sx .= '<link rel="shortcut icon" type="image/png" href="' . $icone . '" />' . cr();
		$sx .= '</head>';

		if (isset($data['reverse'])) {
			$sx .= '<style> body { background-color: #007F3F; } </style>' . cr();
		}
		$sx .= '<body>';
		return ($sx);
	}

	function cab($data = array())
	{
		$sx = $this->header($data);
		$sx .= $this->navbar($data);
		return ($sx);
	}

	function startpage($tp = 'R')
	{
		$data = array();
		if ($tp == 'R') {
			$data['reverse'] = true;
		}

		$sx = $this->header($data);
		$sx .= $this->navbar($data);
		$sx .= $this->logo($data);
		$sx .= $this->slogan($data);
		return ($sx);
	}

	function logo($data)
	{
		$sx = '';
		$sx .= '<div class="container" style="margin: 20px 10px;">';
		if (isset($data['reverse'])) {
			$sx .= '<img src="' . base_url('img/gev3nt/g-ev3nto-logo-reverse.png') . '" class="img-fluid rounded mx-auto d-block" alt="Logotipo do Site">';
		} else {
			$sx .= '<img src="' . base_url('img/gev3nt/g-ev3nto-logo.png') . '" class="img-fluid rounded mx-auto d-block" alt="Logotipo do Site">';
		}
		$sx .= '</div>';
		return ($sx);
	}
	function navbar($data)
	{
		$this->load->helper('socials');
		$socials = new socials;

		$sx = '
        <!----- NavBar ---->
        <nav class="navbar navbar-expand-lg bg-success navbar-dark">
        <a class="navbar-brand" href="#"><img src="' . base_url('img/gev3nt/favicon.png') . '" width="30" height="30" class="d-inline-block align-top" alt=""> &nbsp; G-Ev3ntos</a><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <!----- NavBar Menus ---->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="' . base_url(PATH) . '">Home <span class="sr-only">(current)</span></a>
                </li>
            ';
		if (perfil("#ADMIN")) {
			$sx .= '
                <li class="nav-item active">
                    <a class="nav-link" href="' . base_url(PATH) . 'events">Eventos <span class="sr-only"></span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="' . base_url(PATH) . 'users">Usuários <span class="sr-only"></span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="' . base_url(PATH) . 'labels">Etiquetas <span class="sr-only"></span></a>
                </li>
                ';
		}
		$sx .= '
            <li class="nav-item active">
                <a class="nav-link" href="' . base_url(PATH) . 'contact">Contato <span class="sr-only"></span></a>
            </li>

            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item navbar-toggler-right">
                ' . $socials->menu_user() . '
                </li>
            </ul>
        </div>
        </nav>' . cr();
		return ($sx);
	}

	function contact()
	{
		$sx = '<h1>Contato</h1>';
		$sx .= 'Contato: renefgj@gmail.com';
		return ($sx);
	}
	function slogan($data)
	{
		$sx = '';
		$sx .= '<div class="container" style="margin: 20px 10px;">';
		$sx .= '<div class="row">';
		if (isset($data['reverse'])) {
			$class = "text-white display-4;";
		} else {
			$class = "";
		}
		$sx .= '<div class="col-12 text-center">';
		$sx .= '<h3 class="' . $class . '">Sistema de Gerenciamento de Eventos</h3>';
		$sx .= '</div>';
		$sx .= '</div></div>';
		return ($sx);
	}

	function index($action = '', $arg = '', $arg2 = '')
	{
		$data = array();
		switch ($action) {
			case 'labels':
				$data['content'] = $this->cab($data);
				$data['content'] .= $this->etiquetas_index();
				break;
			case 'labels_print':
				$this->etiquetas(1);
				break;
			case 'participante':
				$data['content'] = $this->cab($data);
				$data['content'] .= $this->events->new_users_evento($arg);
				break;
			case 'social':
				$data = array('reverse' => true);
				$this->load->helper('socials');
				$socials = new socials;
				$data['content'] = $this->cab($data);
				$this->load->view('content', $data);
				$socials->social($arg, $arg2);
				$data['content'] = '';
				break;
			case 'events':
				$data['content'] = $this->cab($data);
				$data['content'] .= $this->events->row();
				break;
			case 'users':
				$data['content'] = $this->cab($data);
				$data['content'] .= $this->events->row_users();
				break;
			case 'contact':
				$data['content'] = $this->cab($data);
				$data['content'] .= $this->logo($data);
				$data['content'] .= $this->events->contact();
				break;
			case 'show_users':
				$data['content'] = $this->cab($data);
				$data['content'] .= $this->events->show_users($arg, $arg2);
				break;
			case 'send_mail':
				$data['content'] = $this->cab();
				$data['content'] .= $this->send_mail($arg, $arg2);
				break;
			case 'show':
				$data['content'] = $this->cab();
				$data['content'] .= $this->show($arg);
				break;
			case 'edit':
				$data['content'] = $this->cab();
				$data['content'] .= $this->edit($arg);
				break;
			case 'import':
				$data['content'] = $this->cab();
				$data['content'] .= $this->events->inport_event_incritos($arg, $arg2);
				break;
			case 'import_cracha':
				$data['content'] = $this->events->inport_event_cracha($arg, $arg2);
				break;

				/******************** EVENTO */
			case 'assignin':
				$this->cab(0);
				$data['content'] = $this->events->assignin($arg, $arg2);
				$this->load->view("content", $data);
				break;
			case 'select':
				$this->cab(0);
				$data['content'] = $this->events->select($arg, $arg2);
				$this->load->view("content", $data);
				break;
			case 'inscritos':
				$this->cab(0);
				$data['content'] = $this->events->inscritos($arg, $arg2);
				$this->load->view("content", $data);
				break;
			case 'presenca':
				$this->cab(0);
				$data['content'] = $this->events->presenca($arg, $arg2);
				$this->load->view("content", $data);
				break;
			case 'booking':
				$this->cab(0);
				$data['content'] = $this->events->inscricao($arg, $arg2);
				$this->load->view("content", $data);
				break;
			case 'valida':
				$data['content'] = $this->cab();
				$data['content'] .= $this->events->valida($arg, $arg2);
				break;
			case 'edit_certificado':
				$data['content'] = $this->cab(0);
				$data['content'] .= $this->events->edit_certificado($arg, $arg2);
				break;
			case 'checkin':
				$this->cab();
				if (isset($_SESSION['event_id'])) {
					$event = $_SESSION['event_id'];
					$this->events->acao($event);
					$data['content'] = $this->events->event_checkin_form($event);
					$data['content'] .= '<a href="' . base_url('index.php/main/evento/import_cracha') . '">Importar cracha</a>';
				} else {
					redirect('index.php/main/evento/select');
				}

				/*************/
				$CHK = get("checkin");
				if (strlen($CHK . $arg) > 0) {
					/**************************************** CHECKIN REGISTER ********/
					$CHK = get("checkin");
					$data['content'] .= $this->events->event_registra_checkin($CHK, $arg);
					if (strlen($arg) > 0) {
						redirect(base_url('index.php/main/evento/checkin'));
					}
				}
				$data['content'] .= $this->events->lista_inscritos($event);
				$this->load->view("content", $data);
				break;

			case 'print':
				$this->certificado_pdf($arg, $arg2);
				exit;
				break;

			default:
				//$data['content'] = $this -> events -> certificados();
				$data['content'] = $this->startpage();
				$data['content'] .= $this->certificados();
		}
		$this->cab(0);
		$this->load->view('content', $data);
	}

	function new_users_evento($d1)
	{
		$nome = get("nome");
		$email = get("email");
		$inst = get("inst");
		$cracha = get("cracha");
		$act = get("acao");
		if ($act != '')
			{
				$sql = "select * from events_names where n_email = '$email'";
				$rlt = $this->db->query($sql);
				$rlt = $rlt->result_array();
				if (count($rlt) == 0)
					{
						$sqli = "insert into events_names
							(n_nome, n_email, n_cracha)
							values
							('$nome','$email','$cracha')
							";
						$rlt = $this->db->query($sqli);
						sleep(1);
						$rlt = $this->db->query($sql);
						$rlt = $rlt->result_array();
					}
				$idu = $rlt[0]['id_n'];

				/************* Inscrever */
				$sql = "select * from events_inscritos where i_evento = $d1 and i_user = $idu ";
				$rlt = $this->db->query($sql);
				$rlt = $rlt->result_array();

				if (count($rlt) == 0)
					{
						$sql = "insert into events_inscritos
							(i_evento, i_user, i_titulo_trabalho, i_autores, i_cracha)
							values
							($d1,$idu,'$inst','AAAAAA',0)";
							$rlt = $this->db->query($sql);

							$sx = '<h1>Inserirdo com sucesso</h1>';
							$sx .= '<a href="'.base_url('index.php/main/evento/labels/?evento='.$d1).'">Imprimir Cracha</a>';
							return $sx;
					} else {

					}

			}
		$sx = '<form method="post" action="' . base_url('index.php/main/evento/participante/' . $d1) . '">';
		$sx .= "Evento: " . $d1;
		$sx .= 'Nome completo:<br>';
		$sx .= '<input type="text" class="form-control" name="nome" size="100%" placeholder="Nome" value="' . get("nome") . '">';
		$sx .= 'E-mail:<br>';
		$sx .= '<input type="text" class="form-control" name="email" size="100%" placeholder="E-mail" value="' . get("email") . '">';
		$sx .= 'Instituição (Silga):<br>';
		$sx .= '<input type="text" class="form-control" name="inst" size="100%" placeholder="Instituicao" value="' . get("inst") . '">';
		$sx .= '<input type="hidden" name="cracha" size="100%" value="' . md5(time()) . '">';
		$sx .= '<br>';
		$sx .= '<input type="submit"  class="btn btn-primary" name="acao" value="Cadastrar">';
		return $sx;
	}

	function certificado_pdf($arg, $arg2)
	{
		$mes = array('', 'janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro');
		$chk = checkpost_link($arg);
		if ($chk != $arg2) {
			$sx = '
        <br>
        <div class="alert alert-danger" role="alert">
        Erro de checksum do post
        </div>
        ';
			$data['content'] = $this->cab(0);
			$data['content'] .= $sx;
			$this->load->view('content', $data);
			return ('');
		}

		$line = $this->events->le($arg);
		if (round($line['i_certificado']) == 0) {
			$sql = "update events_inscritos
        set i_certificado = '" . date("Y-m-d H:i_s") . "'
        WHERE id_i = " . $line['id_i'];
			$this->db->query($sql);
		}
		$nr = $line['id_i'];
		$nome = trim($line['n_nome']);
		$titulo = trim($line['i_titulo_trabalho']);
		$autores = trim($line['i_autores']);
		$cidade = trim($line['e_cidade']);
		$evento = trim($line['e_name']);
		$data = sonumero($line['e_data']);
		$img_file = $line['e_background'];
		$tmp = $line['e_templat'];

		$data = substr($data, 6, 2) . ' de ' . $mes[round(substr($data, 4, 2))] . ' de ' . substr($data, 0, 4) . '.';
		$ass_nome = trim($line['e_ass_none_1']);
		$ass_cargo = trim($line['e_ass_cargo_1']);

		// create new PDF document

		if ($tmp == 3) {
			$pdf = new tcpdf('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		} else {
			$pdf = new tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		}


		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor($evento);
		$pdf->SetTitle('Declaração - ' . $evento);
		$pdf->SetSubject($evento);
		$pdf->SetKeywords($evento);

		// set header and footer fonts
		$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);

		// remove default footer
		$pdf->setPrintFooter(false);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set font
		$pdf->SetFont('times', '', 48);

		// add a page
		$pdf->AddPage();

		// -- set new background ---

		// get the current page break margin
		$bMargin = $pdf->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $pdf->getAutoPageBreak();
		// disable auto-page-break
		$pdf->SetAutoPageBreak(false, 0);
		// set bacground image

		if ($tmp == 3) {
			if (strlen($img_file) > 0) {
				$pdf->Image($img_file, 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);
			}
		} else {
			if (strlen($img_file) > 0) {
				$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
			}
		}
		// restore auto-page-break status

		$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$pdf->setPageMark();

		// Print a text
		$pdf->setfont("helvetica");

		$txt1 = $line['e_texto'];
		$txt1 = troca($txt1, '$nome', $nome);
		$txt1 = troca($txt1, '$titulo', $titulo);
		$txt1 = troca($txt1, '$autores', $autores);


		$txt2 = '<br>' . $cidade . ', ' . $data;

		$txt3 = '<br><br><br><br><br><br><br><br>';
		$txt3 .= '<b>' . $ass_nome . '</b>';
		$txt4 = '<br>' . $ass_cargo;

		switch ($tmp) {
			case 3:
				$html = '<br><br><br><br>';
				$html .= '

				<table cellspacing="0" cellpadding="0" border="0" width="100%"  style="margin-top: 200px; font-family: tahoma, arial; color: #333333;text-align:left; font-size:15pt; line-height: 150%;">
				<tr>
				<td rowspan="1" width="100%">' . $txt1 . '</td>
				</tr>
				<tr>
				<td rowspan="1" width="100%" align="right">' . $txt2 . '</td>
				</tr>
				</table>
				';
				break;

			case 5:
				$html = '<br><br><br>';
				$html .= '<span style="font-family: tahoma, arial; color: #333333;text-align:left; font-weight:bold;font-size:30pt;">DECLARAÇÃO</span>';
				$pdf->writeHTML($html, true, false, true, false, '');

				$html = '

				<table cellspacing="0" cellpadding="0" border="0" width="100%"  style="margin-top: 200px; font-family: tahoma, arial; color: #333333;text-align:left; font-size:15pt; line-height: 190%;">
				<tr>
				<td rowspan="1" width="100%">' . $txt1 . '</td>
				</tr>
				<tr>
				<td rowspan="1" width="100%" align="right">' . $txt2 . '</td>
				</tr>
				<tr style="font-family: tahoma, arial; color: #333333;text-align:left; font-size:15pt; line-height: 100%;">
				<td rowspan="1" width="100%" align="center">' . $txt3 . '</td>
				</tr>

				</table>
				';
				break;

			default:
				$html = '<span style="font-family: tahoma, arial; color: #333333;text-align:left; font-weight:bold;font-size:30pt;">DECLARAÇÃO</span>';
				$pdf->writeHTML($html, true, false, true, false, '');

				$html = '
				<table cellspacing="0" cellpadding="0" border="0" width="445"  style="font-family: tahoma, arial; color: #333333;text-align:left; font-size:15pt; line-height: 190%;">
				<tr>
				<td rowspan="1" width="100%">' . $txt1 . '</td>
				</tr>
				<tr>
				<td rowspan="1" width="100%" align="right">' . $txt2 . '</td>
				</tr>
				<tr style="font-family: tahoma, arial; color: #333333;text-align:left; font-size:15pt; line-height: 100%;">
				<td rowspan="1" width="100%" align="center">' . $txt3 . '</td>
				</tr>
				<tr style="font-family: tahoma, arial; color: #333333;text-align:left; font-size:9pt; line-height: 120%;">
				<td rowspan="1" width="100%" align="center">
				' . $txt4 . '</td>
				</tr>
				</table>
				';
				break;
		}

		$img_file = $line['e_ass_img'];
		if (strlen($img_file) > 0) {
			$pdf->Image($img_file, 40, 175, 80, 30, '', '', '', false, 300, '', false, false, 0);
		}

		// QRCODE,Q : QR-CODE Better error correction
		// set style for barcode
		$style = array(
			'border' => 2, 'vpadding' => 'auto', 'hpadding' => 'auto', 'fgcolor' => array(0, 0, 0), 'bgcolor' => false, //array(255,255,255)
			'module_width' => 1, // width of a single module in points
			'module_height' => 1 // height of a single module in points
		);

		/* QRCODE */
		if ($tmp == 3) {
			$pdf->SetXY(150, 150);
			$pdf->SetFont('helvetica', '', 8, '', false);
			$pdf->Text(0, 140, 'validador do certificado');
			$pdf->write2DBarcode('www.ebbc.inf.br/certificados/index.php/main/evento/valida/' . $nr . '/' . checkpost_link($nr), 'QRCODE,Q', 0, 145, 30, 30, $style, 'N');
			$pdf->SetXY(40, 80);
		}

		$pdf->writeHTML($html, true, false, true, false, '');



		if ($tmp != 3) {

			$pdf->write2DBarcode('www.ebbc.inf.br/certificados/index.php/main/evento/valida/' . $nr . '/' . checkpost_link($nr), 'QRCODE,Q', 110, 241, 30, 30, $style, 'N');
			$pdf->SetFont('helvetica', '', 8, '', false);
			$pdf->Text(110, 236, 'validador do certificado');
		}

		// ---------------------------------------------------------

		//Close and output PDF document
		$pdf->Output('UFRGS-Certificado-' . $nome . '-' . $nr . '.pdf', 'I');
	}

	function le_aluno($cracha)
	{
		$sqln = "select * from person
    left join person_contato ON ct_person = id_p and ct_tipo = 'E'
    where p_cracha = '" . trim($cracha) . "'";
		$rltx = $this->db->query($sqln);
		$rltx = $rltx->result_array();
		print_r($rltx);
		exit;
	}
	function inport_event_cracha($a = '', $b = '')
	{
		$d1 = get("dd1");
		$cp = array();
		array_push($cp, array('$Q id_e:e_name:select * from events where e_status = 1 order by e_data_i desc', '', 'Evento', true, true));
		array_push($cp, array('$T80:10', '', 'Lista de inscritos', true, true));

		$form = new form;
		$sx = $form->editar($cp, '');
		if ($form->saved > 0) {
			$l = get("dd1");
			$evento = get("dd0");
			$l = troca($l, '	', ';');
			$l = troca($l, chr(8), ';');
			$l = troca($l, chr(9), ';');
			$l = troca($l, chr(13), ';');
			$l = troca($l, chr(10), '');
			$ln = splitx(';', $l);
			for ($r = 0; $r < count($ln); $r++) {
				$cracha = $ln[$r];
				$sql = "select * from events_names where n_cracha = '$cracha' ";
				$rlt = $this->db->query($sql);
				$rlt = $rlt->result_array();
				if (count($rlt) == 0) {
					$email = '[sem email]';
					$nome = '[sem nome]';
					$sqln = "select * from person
                left join person_contato ON ct_person = id_p and ct_tipo = 'E'
                where p_cracha = '" . trim($cracha) . "'";
					$rltx = $this->db->query($sqln);
					$rltx = $rltx->result_array();
					if (count($rltx) > 0) {
						$nome = $rltx[0]['p_nome'];
						$email = $rltx[0]['ct_contato'];
					} else {
						$sx .= "OPS - Não localizado - $cracha<br>";
					}

					/* Busca no cadastro geral */
					$xsql = "insert into events_names
                (n_nome, n_email, n_cracha)
                values
                ('$nome','$email','$cracha')";
					$sx .= '<br>' . $nome . ' (' . $email . ') ';
					$rlt = $this->db->query($xsql);
					$rlt = $this->db->query($sql);
					$rlt = $rlt->result_array();
					$sx .= ' <font color=green>Inserido!</font>';
				} else {
					$nome = $rlt[0]['n_nome'];
					$email = $rlt[0]['n_email'];
					$sx .= '<br>' . $nome . ' (' . $email . ') ';
					$sx .= ' <font color=red>Já existe!</font>';
				}
				echo $sql . '<br>';
				$line = $rlt[0];
				$idu = $line['id_n'];
				$sx .= ' <font color=red>Já existe!</font>';

				$sql = "select * from events_inscritos
            where i_evento = $evento AND i_user = $idu ";
				$zrlt = $this->db->query($sql);
				$zrlt = $zrlt->result_array();
				if (count($zrlt) == 0) {
					$sql = "insert into events_inscritos
                (i_evento, i_user, i_status)
                values
                ($evento,$idu,1) ";
					$erlt = $this->db->query($sql);
					$sx .= ' <font color="green">Inscrito</font>';
				} else {
					$sx .= ' <font color="red">Já inscrito</font>';
				}
			}
		}
		return ($sx);
	}
	function inport_event_incritos($a = '', $b = '')
	{
		$d1 = get("dd1");
		$cp = array();
		array_push($cp, array('$Q id_e:e_name:select * from events where e_status = 1 order by e_data_i desc', '', 'Evento', true, true));
		array_push($cp, array('$T80:10', '', 'Lista de inscritos', true, true));
		$info = 'Ex:<br>Nome;email<br>ou Nome;email;Título do Trabalho;Autores';
		array_push($cp, array('$M', '', $info, false, false));

		$form = new form;
		$sx = $form->editar($cp, '');
		if ($form->saved > 0) {
			$l = get("dd1");
			$evento = get("dd0");
			$l = troca($l, ';', '£');
			$l = troca($l, "\t", '£');
			$l = troca($l, chr(7), ';');
			$l = troca($l, chr(8), ';');
			$l = troca($l, chr(9), ';');
			$l = troca($l, chr(13), ';');
			$l = troca($l, chr(10), '');
			$ln = splitx(';', $l);
			for ($r = 0; $r < count($ln); $r++) {
				$ll = $ln[$r];
				$ll = troca($ll, '£', ';');
				$ll = troca($ll, chr(8), ';');
				$ll = splitx(';', $ll . ';');
				if (!isset($ll[1])) {
					print_r($ll);
					echo '<hr>';
					$ll[1] = $ll[0];
				}
				//if (strpos($ll[1], '@')) {
				if (isset($ll[1])) {
					$email = $ll[1];
					$cracha = md5($email);
					$nome = $ll[0];
					$sx .= '<br>' . $nome . ' (' . $email . ') ';
					$sql = "select * from events_names where (n_email = '$email') or (n_nome = '$email') ";
					$rlt = $this->db->query($sql);
					$rlt = $rlt->result_array();
					if (count($rlt) == 0) {
						if ($nome == $email) {
							$sx .= ' <font color=red class="bg-warning">E-mail inválido (não informado)!</font>';
						} else {
							if (strpos($ll[1], '@')) {
								$xsql = "insert into events_names
                            (n_nome, n_email, n_cracha)
                            values
                            ('$nome','$email','$cracha')";
								$rlt = $this->db->query($xsql);
								$rlt = $this->db->query($sql);
								$rlt = $rlt->result_array();
								$sx .= ' <font color=green>Inserido!</font>';
							} else {
								$sx .= ' <font color=red>E-mail inválido (não reconhecido ' . $email . ')!</font>';
							}
						}
					} else {
						$sx .= ' <font color=red>Já existe!</font>';
					}
					if (count($rlt) > 0) {
						$line = $rlt[0];
						$idu = $line['id_n'];
						$i_titulo = '';
						$i_autores = '';
						$sx .= ' <font color=red>Já existe!</font>';

						$sql = "select * from events_inscritos
                                where i_evento = $evento AND i_user = $idu ";
						if (isset($ll[3])) {
							$sql .= "and i_titulo_trabalho = '" . $ll[2] . "' ";
							$i_autores = $ll[3];
							$i_titulo = $ll[2];
						}
						$zrlt = $this->db->query($sql);
						$zrlt = $zrlt->result_array();
						if (count($zrlt) == 0) {
							$sql = "insert into events_inscritos
                    (i_evento, i_user, i_status, i_titulo_trabalho, i_autores)
                    values
                    ($evento,$idu,1,'$i_titulo','$i_autores') ";
							$erlt = $this->db->query($sql);
							$sx .= ' <font color="green">Inscrito</font>';
						} else {
							$sx .= ' <font color="red">Já inscrito</font>';
						}
					}
				}
			}
		} else {
		}
		return ($sx);
	}

	function select($id = '')
	{
		if (strlen($id) > 0) {
			$_SESSION['event_id'] = $id;
			redirect(base_url('index.php/main/evento/checkin'));
		}
		$sql = "select * from events where e_status = 1 order by e_data_i";
		$rlt = $this->db->query($sql);
		$rlt = $rlt->result_array();
		$sx = '<div class="container">' . cr();
		$sx .= '<div class="row">' . cr();
		$sx .= '<div class="col-md-12">' . cr();
		$sx .= '<h1>Eventos abertos para inscrição</h1>';
		$sx .= '<ul>' . cr();

		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];

			$sx .= '<li>';
			$sx .= '<a href="' . base_url('index.php/main/evento/select/' . $line['id_e']) . '" style="font-size: 200%;">';
			$sx .= $line['e_name'];
			$sx .= ' (';
			$sx .= stodbr($line['e_data_i']);
			if ($line['e_data_f'] > $line['e_data_i']) {
				$sx .= ' à ';
				$sx .= stodbr($line['e_data_f']);
			}
			$sx .= ')';
			$sx .= '</a>';
			$sx .= '</li>';
		}
		$sx .= '</ul>' . cr();
		$sx .= '</div>' . cr();
		$sx .= '</div>' . cr();
		return ($sx);
	}

	function inscricao($id = '', $arg2 = '')
	{
		$ev = $this->le_event($id);
		$email = get("dd3");
		if (strlen(get("dd8")) > 0) {
			$email = get("dd8");
			$name = get("dd9");
			$cracha = get("dd10");
			$this->register($id, $name, $cracha, $email);
			$tela = '<h1>' . $ev['e_name'] . '</h1>';
			$tela .= bs_alert('success', 'Inscrição realizada com sucesso para ' . $name . ' (' . $email . ')');
			$tela .= '<br>';
			$tela .= '<a href="' . base_url('index.php/main/evento/assignin') . '" class="btn btn-secondary">Voltar</a>';
			return ($tela);
		}

		if ((count($ev) > 0) and ($ev['e_status'] == 1)) {
			$form = new form;
			$cp = array();
			array_push($cp, array('$H8', '', '', false, false));
			array_push($cp, array('$A1', '', 'Inscrições no evento', false, false));
			array_push($cp, array('$A2', '', $ev['e_name'], false, false));
			array_push($cp, array('$S100', '', 'informe seu e-mail', true, true));
			array_push($cp, array('$B8', '', 'Inscrever-se', false, false));
			$tela = $form->editar($cp, '');

			if ($form->saved > 0) {
				$email = get("dd3");
				if (validaemail($email)) {
					$ide = $this->le_email($email);
					if (count($ide) == 0) {
						$tela = bs_alert('warning', 'E-mail não cadastrado');
						$cp = array();
						array_push($cp, array('$H8', '', '', false, false));
						array_push($cp, array('$A1', '', 'Inscrições no evento', false, false));
						array_push($cp, array('$A2', '', $ev['e_name'], false, false));
						array_push($cp, array('$S100', '', 'informe seu e-mail', false, false));
						array_push($cp, array('$S100', '', 'Nome completo (para certificado)', true, true));
						array_push($cp, array('$S100', '', 'Cracha (opcional)', false, true));
						array_push($cp, array('$B8', '', 'Inscrever-se', false, false));
						$tela .= $form->editar($cp, '');
					} else {
						$name = $ide['n_nome'];
						$cracha = $ide['n_cracha'];
						$email = $ide['n_email'];
						$rs = $this->register($id, $name, $cracha, $email);
						$tela = '<h1>' . $ev['e_name'] . '</h1>';
						if ($rs == 2) {
							$tela .= bs_alert('warning', 'Inscrição já havia sido realizada para ' . $name . ' (' . $email . ')');
							$tela .= '<br>';
						} else {
							$tela .= bs_alert('success', 'Inscrição realizada com sucesso  para ' . $name . ' (' . $email . ')');
							$tela .= '<br>';
						}

						$tela .= '<a href="' . base_url('index.php/main/evento/assignin') . '" class="btn btn-secondary">Voltar</a>';
					}
				} else {
					$tela .= '<h2>e-mail inválido</h2>';
				}
			}
		}
		return ($tela);
	}

	function assignin($id = '')
	{
		if (strlen($id) > 0) {
			$_SESSION['event_id'] = $id;
			redirect(base_url('index.php/main/evento/assignin2'));
		}
		$sql = "select * from events where e_status = 1 order by e_data_i";
		$rlt = $this->db->query($sql);
		$rlt = $rlt->result_array();
		$sx = '<div class="container">' . cr();
		$sx .= '<div class="row">' . cr();
		$sx .= '<div class="col-md-12">' . cr();
		$sx .= '<h1>Eventos abertos para inscrição</h1>';
		$sx .= '<ul>' . cr();

		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];

			$sx .= '<li>';
			$sx .= '<a href="' . base_url('index.php/main/evento/booking/' . $line['id_e']) . '" style="font-size: 150%;">';
			$sx .= '';
			$sx .= stodbr($line['e_data_i']);
			if ($line['e_data_f'] > $line['e_data_i']) {
				$sx .= ' à ';
				$sx .= stodbr($line['e_data_f']);
			}
			$sx .= ' - ';
			$sx .= ' ';
			$sx .= $line['e_name'];
			$sx .= '</a>';
			$sx .= '</li>';
		}
		$sx .= '</ul>' . cr();
		$sx .= '</div>' . cr();
		$sx .= '</div>' . cr();
		return ($sx);
	}

	function valida($arg, $arg2)
	{
		$chk = checkpost_link($arg);
		if ($chk != $arg2) {
			$sx = '
            <br>
            <div class="alert alert-danger" role="alert">
            Erro de checksum do post
            </div>
            ';
			return ($sx);
		}

		$data = $this->events->le($arg);
		$sx = '<br><br>';
		$sx .= '<h1>Validação de declaração/certificado</h1>';
		$sx .= '<br><p>';
		$sx .= 'Nome: ' . $data['n_nome'] . '<br>';
		$sx .= 'Evento: ' . $data['e_name'] . '<br>';
		$sx .= 'Título do Trabalho: ' . $data['e_name'] . '<br>';
		$sx .= 'Autores: ' . $data['e_name'] . '<br>';
		$sx .= 'Cidade: ' . $data['e_cidade'] . '<br>';
		$sx .= 'Data: ' . $data['e_data'] . '<br>';

		$sx .= '
            <div class="alert alert-success" role="alert">
            Documento validado com sucesso!
            </div>
            ';
		$data['content'] = $sx;
		$this->load->view('content', $data);
		return ('');
	}

	function le($id)
	{
		$sql = "select * from events_inscritos
            INNER JOIN events_names ON i_user = id_n
            INNER JOIN events ON i_evento = id_e
            where id_i = '$id' ";
		$rlt = $this->db->query($sql);
		$rlt = $rlt->result_array();
		if (count($rlt) > 0) {
			$line = $rlt[0];
			return ($line);
		} else {
			$line = array();
			return ($line);
		}
	}

	function le_email($email)
	{
		$sql = "select * from events_names
            where n_email = '$email' ";
		$rlt = $this->db->query($sql);
		$rlt = $rlt->result_array();
		if (count($rlt) > 0) {
			$line = $rlt[0];
			return ($line);
		} else {
			$line = array();
			return ($line);
		}
	}

	function le_users($id)
	{
		$sql = "select * from events_names
            where id_n = '$id' ";
		$rlt = $this->db->query($sql);
		$rlt = $rlt->result_array();
		if (count($rlt) > 0) {
			$line = $rlt[0];
			return ($line);
		} else {
			$line = array();
			return ($line);
		}
	}

	function inscritos($event)
	{
		$sql = "select * from events_inscritos
    INNER JOIN events_names ON id_n = i_user
    WHERE i_evento = $event
    ORDER BY i_date_in desc ";
		$rlt = $this->db->query($sql);
		$rlt = $rlt->result_array();
		$n = 0;
		$email = '';
		$sx = '<table width="100%" class="table">' . cr();
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$n++;
			$sx .= '<tr>';
			$sx .= '<td width="2%" class="text-center">';
			$sx .= ($r + 1);
			$sx .= '</td>';

			$sx .= '<td>';
			$sx .= $line['n_nome'];
			$sx .= '</td>';

			$sx .= '<td width="10%">';
			$sx .= $line['n_cracha'];
			$sx .= '</td>';

			$sx .= '<td width="15%" class="text-right">';
			$sx .= stodbr($line['i_date_in']);
			$sx .= ' ';
			$sx .= substr($line['i_date_in'], 11, 5);
			$sx .= '</td>';

			$sx .= '<td width="15%" class="text-right">';
			$sx .= stodbr($line['i_certificado']);
			$sx .= ' ';
			$sx .= substr($line['i_certificado'], 11, 5);
			$sx .= '</td>';

			$sx .= '</tr>';
			$sx .= cr();

			$email .= trim($line['n_email']) . '; ';
		}
		$sx .= '</table>';

		$sa = '<br><table width="100%" border="1"><tr><td class="text-center"><h3>' . $n . ' Presente(s)</h3></td></tr></table>';
		return ($sa . $sx . '<h4>e-mail dos inscritos</h4>' . $email);
	}

	function evento_header($event)
	{
		$d = $this->le_event($event);
		$sx = '<h1>' . $d['e_name'] . '</h1>';
		return ($sx);
	}

	function presenca($event)
	{

		$sql = "select * from events_inscritos
    INNER JOIN events_names ON id_n = i_user
    WHERE i_evento = $event
    ORDER BY n_nome ";
		$rlt = $this->db->query($sql);
		$rlt = $rlt->result_array();
		$n = 0;
		$email = '';
		$sx = $this->evento_header($event);
		$sx .= '<table width="100%" class="table">' . cr();
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$n++;
			$sx .= '<tr>';
			$sx .= '<td width="2%" class="text-center">';
			$sx .= ($r + 1);
			$sx .= '</td>';

			$sx .= '<td>';
			$sx .= $line['n_nome'];
			$sx .= '</td>';

			$sx .= '<td width="15%" class="text-right">';
			$sx .= '________________________';
			$sx .= '</td>';

			$sx .= '</tr>';
			$sx .= cr();

			//$email .= trim($line['n_email']) . '; ';
		}
		$sx .= '</table>';
		$sa = $sx;
		$sa .= 'Caso não tenha se inscrito, preencha com seu nome, cracha da UFRGS (se tiver) e seu e-mail para emissão dos certificados de ouvintes.';
		$sa .= '<br>';
		$sa .= '<table width="100%">';
		$sa .= '<tr><th>Nome completo</th><th>Cracha</th><th>e-mail</th></tr>';
		for ($r = 0; $r < 25; $r++) {
			$sa .= '<tr>';
			$sa .= '<td>__________________________</td>';
			$sa .= '<td>___________</td>';
			$sa .= '<td>___________________</td>';
		}
		$sa .= '</table>';
		return ($sa);
	}

	function edit_certificado($id)
	{
		$cp = array();
		array_push($cp, array('$H8', 'id_i', '', false, true));

		array_push($cp, array('$T80:2', 'i_titulo_trabalho', 'Título', false, true));
		array_push($cp, array('$T80:2', 'i_autores', 'Autores', false, true));

		$form = new form;
		$form->id = $id;
		$sx = '<div class="container"><div class="row"><div class="col-md-12">';
		$sx .= $form->editar($cp, 'events_inscritos');
		$sx .= '</div></div></div>';
		if ($form->saved > 0) {
			$dd = $this->le_inscritos($id);

			redirect(base_url(PATH . 'show/' . $dd['i_evento']));
		}
		return ($sx);
	}

	function edit($id)
	{
		$cp = array();
		array_push($cp, array('$H8', 'id_e', '', false, true));
		array_push($cp, array('$S80', 'e_name', 'Nome do evento', true, true));
		array_push($cp, array('$D8', 'e_data_i', 'Data Início', true, true));
		array_push($cp, array('$D8', 'e_data_f', 'Data Fim', true, true));
		array_push($cp, array('$D8', 'e_data', 'Data da Declaração/Certificado', true, true));
		array_push($cp, array('$T80:6', 'e_texto', 'Texto Certificado', true, true));
		$info = '<pre>
    $nome - Nome completo do certificado
    </pre>';
		array_push($cp, array('$M', '', $info, false, true));

		array_push($cp, array('$T80:2', 'e_location', 'Localização', false, true));


		array_push($cp, array('$S80', 'e_cidade', 'Cidade', False, true));
		array_push($cp, array('$S80', 'e_background', 'Imagem de Fundo', False, True));
		array_push($cp, array('$H8', 'e_ass_img', '', False, True));

		array_push($cp, array('$[1-5]', 'e_templat', 'Templat/Layout', True, True));

		array_push($cp, array('$S80', 'e_ass_none_1', 'Assina Certificado', False, true));
		array_push($cp, array('$S80', 'e_ass_cargo_1', 'Função', False, true));

		array_push($cp, array('$S80', 'e_ass_none_2', 'Assina Certificado (1)', False, true));
		array_push($cp, array('$S80', 'e_ass_cargo_2', 'Função (2)', False, true));

		$op = '0:Aberto&1:Encerrado&9:Cancleado';
		array_push($cp, array('$O ' . $op, 'e_status', 'Situação', True, true));

		$form = new form;
		$form->id = $id;
		$sx = '<div class="container"><div class="row"><div class="col-md-12">';
		$sx .= $form->editar($cp, $this->table);
		$sx .= '</div></div></div>';
		if ($form->saved > 0) {
			if ($id > 0) {
				redirect(base_url('index.php/main/evento/show/' . $id));
			} else {
				redirect(base_url('index.php/main/evento/admin/'));
			}
		}
		return ($sx);
	}

	function send_mail($id, $conf)
	{
		$dt = $this->le_event($id);
		$dd = $this->le_event_dados($id);
		$sx = '<ol>';
		for ($r = 0; $r < count($dd); $r++) {
			$line = $dd[$r];
			$email = $line['n_email'];
			$nome = $line['n_nome'];
			$idl = $line['id_i'];
			$texto = '';
			$link = base_url(PATH . 'print/' . $line['id_i'] . '/' . checkpost_link($line['id_i']));
			$texto .= '<center><table width="600">';
			$texto .= '<tr><td>Prezado(a) <b>' . $nome . '</b>,</td></tr>';
			$texto .= '<tr><td>&nbsp;</td></tr>';
			$texto .= '<tr><td>Você está recebendo este e-mail com o certificado do evento "' . $dt['e_name'] . '"</td></tr>';
			$texto .= '<tr><td>Para gerar seu certificado, clique no link abaixo:</td></tr>';
			$texto .= '<tr><td>';
			$texto .= '<a href="' . $link . '">' . $link . '</a>';
			$texto .= '</td></tr>';
			$texto .= '<tr><td>&nbsp;</td></tr>';
			$texto .= '<tr><td align="right">' . $dt['e_cidade'] . ', ' . date("d") . ' de ' . meses(date("m")) . ' de ' . date("Y") . '.</td></tr>';
			$texto .= '<tr><td>&nbsp;</td></tr>';
			$texto .= '<tr><td align="right">Comissão Organizadora</td></tr>';
			$texto .= '</table></center>';

			$texto .= '<br><br><sup><a href="' . base_url(PATH) . '">Sistema: G-Ev3nto v.0.02</a></sup>';
			$texto = utf8_decode($texto);
			enviaremail($email, '[CERTIFICADO] ' . utf8_decode($dt['e_name']), $texto, 2);
			$sx .= '<li>' . $nome . ' &lt;' . $email . '&gt;</li>';
		}
		$sx .= '<ol>';
		return ($sx);
	}

	function show_users($id)
	{
		$dt = $this->le_users($id);
		$form = new form;
		$cp = array();
		array_push($cp, array('$H8', 'id_n', '', false, true));
		array_push($cp, array('$S80', 'n_nome', 'Nome', true, true));
		array_push($cp, array('$S80', 'n_email', 'E-mail', true, true));
		array_push($cp, array('$S50', 'n_cracha', 'Cracha', true, true));

		$form->id = $id;
		$sx = $form->editar($cp, 'events_names');
		if ($form->saved > 0) {
			redirect(base_url(PATH . 'users'));
		}
		return ($sx);
	}

	function show($id)
	{
		$dt = $this->le_event($id);
		$dd = $this->le_event_dados($id);
		$sx = '<div class="container">';
		$sx = '<div class="row">';
		$sx = '<div class="col-md-12">';
		$sx .= '<span class="small">evento</span>';
		$sx .= '<h3>' . $dt['e_name'] . '</h3>';
		$sx .= '<span class="small">' . stodbr($dt['e_data_i']) . ' até ' . stodbr($dt['e_data_f']) . '</span>';
		$sx .= '</div>';

		$sx .= '<div class="col-md-12">';
		$sx .= '<a href="' . base_url('index.php/main/evento/edit/' . $id) . '" class="btn btn-outline-primary">editar</a>';
		$sx .= '</div>';
		/**************************** DADOS */
		$sx .= '<div class="col-md-2 text-center" style="border: 1px solid #000000; border-radius: 5px; margin-top: 20px;">';
		$sx .= '<h1>' . count($dd) . '</h1><span class="small">participantes</span>';
		$sx .= '</div>';

		$sx .= '<a href="' . base_url(PATH . 'import/' . $id) . '">';
		$sx .= '<div class="col-md-2 text-center" style="border: 1px solid #000000; border-radius: 5px; margin-top: 20px;">';
		$sx .= 'Importar Participantes';
		$sx .= '</div>';
		$sx .= '</a>';

		$sx .= '<a href="' . base_url(PATH . 'participante/' . $id) . '">';
		$sx .= '<div class="col-md-2 text-center" style="border: 1px solid #000000; min-height: 50px; background-color: #EEEEFF; border-radius: 5px; margin-top: 20px;">';
		$sx .= 'Inserir Participantes';
		$sx .= '</div>';
		$sx .= '</a>';

		$sx .= '<a href="' . base_url(PATH . 'labels/' . $id) . '">';
		$sx .= '<div class="col-md-2 text-center" style="border: 1px solid #000000; border-radius: 5px; margin-top: 20px;">';
		$sx .= 'Imprimir etiquetas';
		$sx .= '</div>';
		$sx .= '</a>';

		$sx .= '<a href="' . base_url(PATH . 'send_mail/' . $id) . '">';
		$sx .= '<div class="col-md-2 text-center" style="border: 1px solid #000000; border-radius: 5px; margin-top: 20px;">';
		$sx .= 'Enviar Comunicação dos Certificados por e-mail';
		$sx .= '</div>';
		$sx .= '</a>';

		$sx .= '<div class="col-md-12">';
		$sx .= $this->lista_inscritos($id);
		$sx .= '</div>';

		$sx .= '</div>';
		$sx .= '</div>';




		return ($sx);
	}

	function ics($id)
	{
		$data = $this->le_event($id);
		$sx = '';
		$sx .= 'BEGIN:VCALENDAR' . cr();
		$sx .= 'PRODID:-//Google Inc//Google Calendar 70.9054//EN' . cr();
		$sx .= 'VERSION:2.0' . cr();
		$sx .= 'CALSCALE:GREGORIAN' . cr();
		$sx .= 'METHOD:REQUEST' . cr();
		$sx .= 'BEGIN:VEVENT' . cr();
		$sx .= 'DTSTART:20201123T193000Z' . cr();
		$sx .= 'DTEND:20201123T220000Z' . cr();
		$sx .= 'DTSTAMP:20201122T194057Z' . cr();
		$sx .= 'ORGANIZER;CN=marta.valentim@unesp.br:mailto:marta.valentim@unesp.br' . cr();
		$sx .= 'UID:0tm8gaacqqq4j5ejav57uta1vd@google.com' . cr();
		$sx .= 'ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=' . cr();
		$sx .= 'TRUE;CN=renefgj@gmail.com;X-NUM-GUESTS=0:mailto:renefgj@gmail.com' . cr();
		$sx .= 'X-MICROSOFT-CDO-OWNERAPPTID:-1447331192' . cr();
		$sx .= 'CLASS:PUBLIC' . cr();
		$sx .= 'CREATED:20200927T174107Z' . cr();
		$sx .= 'DESCRIPTION:Prezados Associados da ANCIB:<br><br>Convidamos todos para a As' . cr();
		$sx .= 'sembleia Extraordinária\, com pauta única:<br><br>1. Eleição e posse da nov' . cr();
		$sx .= 'a Diretoria da ANCIB - gestão 2020-2022<br><br>Dia: 23/11/2020 (segunda-fei' . cr();
		$sx .= 'ra)<br>Horário: Das 17h00 às 19h00<br>Link Sala Google Meet: <a href="http:' . cr();
		$sx .= '//meet.google.com/pwj-wjfd-qkz">meet.google.com/pwj-wjfd-qkz</a><br><br>Par' . cr();
		$sx .= 'a acessar a Sala do Google Meet você deve aceitar este convite\, clicando e' . cr();
		$sx .= 'm \'yes\' ou \'sim\'.<br><br>Att.\,<br>Oswaldo F. de Almeida Júnior<br>Presiden' . cr();
		$sx .= 'te ANCIB\n\n-::~:~::~:~:~:~:~:~:~:~:~:~:~:~:~:~:~:~:~:~:~:~:~:~:~:~:~:~:~:~' . cr();
		$sx .= ':~:~:~:~:~:~:~:~::~:~::-\nNão edite esta seção da descrição.\n\nEste evento' . cr();
		$sx .= 'tem uma videochamada.\nParticipar: https://meet.google.com/pwj-wjfd-qkz\nV' . cr();
		$sx .= 'eja mais opções de participação: https://tel.meet/pwj-wjfd-qkz?hs=7\n\nVisu' . cr();
		$sx .= 'alize o seu evento em https://calendar.google.com/calendar/event?action=VIE' . cr();
		$sx .= 'W&eid=MHRtOGdhYWNxcXE0ajVlamF2NTd1dGExdmQgcmVuZWZnakBt&tok=MjMjbWFydGEudmFs' . cr();
		$sx .= 'ZW50aW1AdW5lc3AuYnI2MTMyODI0OGQwNWNjOTI4NGYxMjZlZDJhNWYyN2M5ZDg3MTEzNTEz&ct' . cr();
		$sx .= 'z=America%2FSao_Paulo&hl=pt_BR&es=1.\n-::~:~::~:~:~:~:~:~:~:~:~:~:~:~:~:~:~' . cr();
		$sx .= ':~:~:~:~:~:~:~:~:~:~:~:~:~:~:~:~:~:~:~:~:~::~:~::-' . cr();
		$sx .= 'LAST-MODIFIED:20201122T194054Z' . cr();
		$sx .= 'LOCATION:' . $data['e_location'] . cr();
		$sx .= 'SEQUENCE:1' . cr();
		$sx .= 'STATUS:CONFIRMED' . cr();
		$sx .= 'SUMMARY:' . $data['e_name'] . cr();
		return ($sx);
	}

	function row()
	{
		$data = array();
		$data['table'] = 'events';
		$data['where'] = 'e_status = 1';
		$data['page_view'] = base_url('index.php/main/evento/show');
		$data['fields'] = array(0, 1);
		$sx = row3($data);
		$sx .= '<a href="' . base_url(PATH . 'edit/0') . '" class="btn btn-outline-primary">Novo Evento</a>';
		return ($sx);
	}

	function row_users()
	{
		$data = array();
		$data['table'] = 'events_names';
		$data['page_view'] = base_url('index.php/main/evento/show_users');
		$data['fields'] = array(0, 1, 1, 1);
		$sx = row3($data);
		$sx .= '<a href="' . base_url(PATH . 'show_users/0') . '" class="btn btn-outline-primary">Novo Usuário</a>';
		return ($sx);
	}

	function certificados()
	{
		$sx = '<br><br><br><br><br>';
		$sx .= '<div class="row">' . cr();
		$sx .= '<div class="col-md-12">' . cr();
		$sx .= '<h2>Emissão de declarações/certificados</h2>' . cr();
		$sx .= '<p>Informe seu nome completo ou seu e-mail para emissão de sua declaração ou certificado de participação.</p>' . cr();
		$sx .= '<form method="post">' . cr();
		$sx .= '
    <div class="input-group">
    <input type="text" class="form-control" name="dd1" value="' . get("dd1") . '"  placeholder="nome completo, e-mail" aria-label="nome ou e-mail ou cracha">
    <span class="input-group-btn">
    <input type="submit" class="btn btn-danger" type="button" value="Emissão">
    </span>
    </div>
    ' . cr();
		$sx .= '';
		$sx .= '</form>' . cr();
		$sx .= '</div>' . cr();
		$sx .= '</div>' . cr();

		/************************************************************/
		$n = get("dd1");
		if (strlen($n) > 0) {
			$n = trim($n);
			$sql = "select * from events_inscritos
                    INNER JOIN events_names ON i_user = id_n
                    INNER JOIN events ON i_evento = id_e
                    where (n_nome = '$n') OR
                    (n_cracha = '$n') OR
                    (n_email = '$n')
                    order by id_e desc";
			$rlt = $this->db->query($sql);
			$rlt = $rlt->result_array();
			$sx .= '<div class="row">' . cr();
			$sx .= '<div class="col-md-12">' . cr();
			if (count($rlt) == 0) {
				if (strlen($n) > 0) {
					$sx .= '
                <br>
                <div class="alert alert-danger" role="alert">
                Nenhuma declaração ou certificado disponível para "<b>' . $n . '</b>".
                </div>
                ';
				}
			} else {
				$sx .= '<br><br>';
				$sx .= '<h2><b>' . $rlt[0]['n_nome'] . ' (' . $rlt[0]['n_cracha'] . ')</b></h2>';
				$sx .= '<span style="font-size: 75%">&lt;' . $rlt[0]['n_email'] . '&gt;</span><hr>';
				$sx .= 'Certificados / declarações disponíveis:';
			}

			$sx .= '<table class="table" width="100%">' . cr();
			for ($r = 0; $r < count($rlt); $r++) {
				$line = $rlt[$r];
				$id = $line['id_i'];

				$sx .= '
            <tr>
            <td valign="center" style="font-size: 150%;">
            ' . $line['e_name'] . '
            </td>
            <td width="20%">
            <span class="input-group-btn">
            <a href="' . base_url('index.php/main/evento/print/' . $id . '/' . checkpost_link($id)) . '" class="btn btn-danger" target="_new' . $line['id_i'] . '">
            Emitir!
            </a>
            </span>
            </td>
            </tr>
            ';
				$sx .= '</div>';
			}
			$sx .= '</table>' . cr();
			$sx .= '</div>' . cr();
			$sx .= '</div>' . cr();
		}
		return ($sx);
	}

	function create_event()
	{
	}

	function lista_inscritos($event)
	{
		$idu = get('idu');
		if ($idu != '')
			{
				$sql = "update events_inscritos
					set i_cracha = 0
					where id_i = $idu";
				$this->db->query($sql);
			}
		$sql = "select * from events_inscritos
    INNER JOIN events_names ON id_n = i_user
    where i_evento = $event
    ORDER BY i_date_in desc ";
		$rlt = $this->db->query($sql);
		$rlt = $rlt->result_array();
		$n = 0;
		$sx = '<table width="100%" class="table">' . cr();
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$n++;
			$sx .= '<tr>';
			$sx .= '<td width="2%" class="text-center">';
			$sx .= ($r + 1);
			$sx .= '</td>';

			$sx .= '<td>';
			$sx .= $line['n_nome'];
			$sx .= '</td>';

			$sx .= '<td width="10%">';
			$sx .= $line['n_cracha'];
			$sx .= '</td>';

			$sx .= '<td width="15%" class="text-right">';
			$sx .= stodbr($line['i_date_in']);
			$sx .= ' ';
			$sx .= substr($line['i_date_in'], 11, 5);
			$sx .= '</td>';

			$sx .= '<td width="2%" >';
			$sx .= '<a href="' . base_url(PATH . 'print/') . $line['id_i'] . '/' . checkpost_link($line['id_i']) . '" target="_new' . $line['id_i'] . '">C</a>';
			$sx .= '</td>';

			$sx .= '<td width="2%" >';
			$sx .= '<a href="' . base_url(PATH . 'edit_certificado/') . $line['id_i'] . '/' . checkpost_link($line['id_i']) . '" target="_new' . $line['id_i'] . '">[Ed]</a>';
			$sx .= '</td>';
			$linke = '<a href="'. base_url(PATH . 'show/'.$event.'?idu='.$line['id_i']).'">';
			$linka = '</a>';
			if ($line['i_cracha']==1)
				{
					$sx .= '<td>' . $linke . '[etiqueta]' . $linka . '</td>';
				} else {
					$sx .= '<td>Para Imprimir</td>';
				}


			$sx .= '</tr>';
			$sx .= cr();
		}
		$sx .= '</table>';

		$sa = '<br><table width="100%" border="1"><tr><td class="text-center"><h3>' . $n . ' Presente(s)</h3></td></tr></table>';
		return ($sa . $sx);
	}

	function register($event, $name, $cracha, $email = '')
	{
		$sql = "select * from events_names where n_nome = '$name' and n_cracha = '$cracha' ";
		$rlt = $this->db->query($sql);
		$rlt = $rlt->result_array();
		if (count($rlt) == 0) {
			$sqli = "insert into events_names
        (n_nome, n_cracha, n_email)
        values
        ('$name','$cracha','$email')
        ";
			$rlt = $this->db->query($sqli);
			$rlt = $this->db->query($sql);
			$rlt = $rlt->result_array();
		}
		$line = $rlt[0];
		$id_us = $line['id_n'];

		$sql = "select * from events_inscritos where i_evento = $event and i_user = $id_us";
		$rlt = $this->db->query($sql);
		$rlt = $rlt->result_array();

		if (count($rlt) == 0) {
			$sql = "insert into events_inscritos
        ( i_evento, i_user, i_status)
        values
        ( $event, $id_us, 1)
        ";
			$rlt = $this->db->query($sql);
			return (1);
		} else {
			$line = $rlt[0];
			$sql = "update events_inscritos set i_status = 1
        where id_i = " . $line['id_i'];
			$rlt = $this->db->query($sql);
			return (2);
		}
		return (0);
	}

	function cadastra_usuario($nome, $email, $cracha)
	{
		$sql = "select * from events_names where n_email = '$email' ";
		$rlt = $this->db->query($sql);
		$rlt = $rlt->result_array();
		if (count($rlt) > 0) {
			echo "Já existe";
			exit;
		} else {
			$sql = "insert into events_names
        (n_nome, n_cracha, n_email)
        value
        ('$nome','$cracha','$email') ";
			$rlt = $this->db->query($sql);
		}
		return ('');
	}

	function acao()
	{
		/************************/
		if ((strlen(get("action")) > 0) and (strlen(get("dd_nome") . get("dd_cracha")) > 0)) {
			$nome = strtoupper(get("dd_nome"));
			$email = get("dd_email");
			$cracha = get("dd_cracha");
			if (strlen($cracha) < 8) {
				$cracha = strzero($cracha, 8);
			}
			$this->cadastra_usuario($nome, $email, $cracha);
			if (strlen($cracha) > 0) {
				$id = $cracha;
			} else {
				$id = $nome;
			}
			redirect(base_url('index.php/main/evento/checkin/' . $id));
		}
	}

	function event_registra_checkin($id, $arg)
	{
		$event = $_SESSION['event_id'];

		if ((strlen($arg) > 0) and (strlen($id) == 0)) {
			$id = $arg;
		}

		$sql = "insert into events_login
    (el_usca) value ('$id')";
		$rlt = $this->db->query($sql);

		$wh = '';
		$wh2 = '';
		$cracha = '';
		$name = '';

		if (substr($id, 0, 1) == '#') {
			$sa = '';
			$t = troca($id, '#', '');
			$t = splitx(';', $t);
			for ($z = 0; $z < count($t); $z++) {
				$sa .= $this->event_registra_checkin($t[$z], $arg);
			}
			return ($sa);
			exit;
		}

		if ($id == sonumero($id)) {
			$id = strzero($id, 8);
			$wh = " p_cracha = '$id' ";
			$cracha = $id;
		} else {
			$nn = troca($id, ' ', ';');
			$nn = splitx(';', $nn, ';');
			for ($r = 0; $r < count($nn); $r++) {
				if ($r > 0) {
					$wh .= ' AND ';
					$wh2 .= ' AND ';
				}
				$wh .= "(p_nome like '%" . $nn[$r] . "%')";
				$wh2 .= "(ct_contato like '%" . $nn[$r] . "%')";
			}
			$name = $id;
		}
		if (strlen($wh2) > 0) {
			$wh .=  " OR ($wh2)";
		}

		$sql = "select p_nome, p_cracha from person
    LEFT JOIN person_contato ON ct_person = id_p AND ct_tipo = 'E'
    where ($wh)
    group by p_cracha, p_nome
    limit 20
    ";
		$rlt = $this->db->query($sql);
		$rlt = $rlt->result_array();

		if (count($rlt) == 0) {
			if (!isset($nn[0])) {
				redirect('https://www.ufrgs.br/comgradbib/index.php/main/evento/checkin');
			}
			$sql = "select * from
        (select n_nome as p_nome, n_cracha as p_cracha, n_email as ct_contato
        from events_names ) as tabela
        where $wh OR (p_email = '" . $nn[0] . "')
        limit 20
        ";
			$rlt = $this->db->query($sql);
			$rlt = $rlt->result_array();
		}
		$sx = '';

		if (count($rlt) > 0) {
			if (count($rlt) == 1) {
				$p = array();
				$line = $rlt[0];
				$p['name'] = $line['p_nome'];
				$p['cracha'] = $line['p_cracha'];
				$p['email'] = '';
				$ctt = '';
				if (isset($line['ct_contato'])) {
					$ctt = $line['ct_contato'];
				}
				$this->events->register($event, $line['p_nome'], $line['p_cracha'], $ctt);

				$sx = '
            <br>
            <div class="alert alert-success" role="alert">
            <strong>Sucesso!</strong> <a href="#" class="alert-link">' . $p['name'] . ' registrado com sucesso!</a>
            </div>
            ';
			} else {
				$sx .= '<ul>';
				for ($r = 0; $r < count($rlt); $r++) {
					$line = $rlt[$r];
					$sx .= '<li>';
					$sx .= '<a href="' . base_url('index.php/main/evento/checkin/' . $line['p_cracha']) . '">';
					$sx .= $line['p_nome'];
					$sx .= ' (' . $line['p_cracha'] . ')';
					$sx .= '</li>';
				}
				$sx .= '<ul>';
			}
		} else {
			$sx = '
        <br>
        <div class="alert alert-danger" role="alert">
        <strong>Erro!</strong> <a href="#" class="alert-link">Nenhuma ocorrencia para esse nome / cracha. (' . $id . ')</a>
        </div>

        <br>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
        Cadastrar Visitante
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cadastrar Visitante</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form method="post" action="' . base_url('index.php/main/evento/checkin/') . '">
        <div class="modal-body">

        <span>Nome completo</span>
        <input type="text" name="dd_nome" class="form-control" value="' . $name . '" style="text-transform: uppercase;">
        <span>Cracha</span>
        <input type="text" name="dd_cracha" class="form-control" value="' . $cracha . '">
        <span>e-mail</span>
        <input type="text" name="dd_email" class="form-control" style="text-transform: lowercase;">

        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <input type="submit" name="action" class="btn btn-primary" value="salvar">
        </div>
        </form>
        </div>
        </div>
        </div>
        <br>
        ';
		}
		return ($sx);
	}

	function le_event($id)
	{
		$sql = "select * from events where id_e = " . round($id);
		$rlt = $this->db->query($sql);
		$rlt = $rlt->result_array();
		if (count($rlt) > 0) {
			$line = $rlt[0];
			return ($line);
		}
		return (array());
	}

	function le_inscritos($id)
	{
		$sql = "select * from events_inscritos where id_i = " . round($id);
		$rlt = $this->db->query($sql);
		$rlt = $rlt->result_array();
		if (count($rlt) > 0) {
			$line = $rlt[0];
			return ($line);
		}
		return (array());
	}

	function le_event_dados($id)
	{
		$sql = "select * from events_inscritos
                INNER JOIN events_names ON i_user = id_n
                where i_evento = " . round($id);
		$rlt = $this->db->query($sql);
		$rlt = $rlt->result_array();
		return ($rlt);
	}

	function event_checkin($ch)
	{
		$sx = '
    <br>
    <div class="alert alert-danger" role="alert">
    <strong>Erro!</strong> <a href="#" class="alert-link">Nome ou cracha não registrado no sistema.
    </div>
    ';
		return ($sx);
	}

	function event_checkin_form($ev = 0)
	{
		$sx = '<form method="post">';
		$sx .= '
    Informe o nome ou cracha
    <div class="input-group">
    <input id="checkin" name="checkin" type="text" class="form-control" placeholder="Informe o nome ou cracha">
    <span class="input-group-btn">
    <input type="submit" class="btn btn-primary" type="button" value="Check-in">
    </span>
    </div>
    <script>
    jQuery("#checkin").focus();
    </script>
    ';
		$sx .= '</form>';
		return ($sx);
	}

	function etiquetas_index($id = '')
	{
		$sx = '';
		$ev = get("evento");
		if (strlen($ev) == 0) {
			$sql = "select * from events where e_status = 1 order by e_name";
			$rlt = $this->db->query($sql);
			$rlt = $rlt->result_array();
			for ($r = 0; $r < count($rlt); $r++) {
				$line = $rlt[$r];
				$link = '<a href="' . base_url('index.php/main/evento/labels/?evento=' . $line['id_e']) . '">';
				$linka = '</a>';
				$sx .= '<li>' . $link . $line['e_name'] . $linka . '</li>';
			}
		} else {
			$sx .= $this->etiquetas($ev);
		}
		return $sx;
	}

	function etiquetas($id = 1)
	{
		$sql = "select * from events_names
					INNER JOIN events_inscritos ON id_n = i_user
					where i_evento = $id
					and i_cracha = 0
					order by n_nome";
		$db = $this->db->query($sql);
		$db = $db->result_array();
		$this->load->helper("argox");
		$et = new argox();
		$ets = '';

		for ($r = 0; $r < count($db); $r++) {

			//if ($r > 5) { break; }

			$line = $db[$r];
			$nome = ascii($line['n_nome']);
			$nome = troca($nome, 'ñ', 'n');
			$inst = $line['i_titulo_trabalho'];

			$nome = Uppercase($nome);

			$nf = explode(' ', $nome);

			$endf = count($nf) - 1;
			$namef = $nf[0];
			$namel = $nf[$endf];

			switch ($namel) {
				case 'JUNIOR':
					$namel = $nf[$endf - 1] . ' ' . $nf[$endf];
					break;
				case 'NETO':
					$namel = $nf[$endf - 1] . ' ' . $nf[$endf];
					break;
				case 'NETTO':
					$namel = $nf[$endf - 1] . ' ' . $nf[$endf];
					break;
				case 'FILHO':
					$namel = $nf[$endf - 1] . ' ' . $nf[$endf];
					break;
				default:
					break;
			}
			$namex = $namef . ' ' . $namel;
			$tmax = 20;
			$tlen = strlen($namex);
			$tsp = $tmax - $tlen;
			$tsp = round($tsp / 2);
			if ($tsp > 1) {
				$namex = str_repeat(' ', $tsp) . $namex;
			}
			/************************* */
			$tmax = 40;
			$tlen = strlen($inst);
			$tsp = $tmax - $tlen;
			$tsp = round($tsp / 3);
			if ($tsp > 1) {
				$inst = str_repeat(' ', $tsp) . $inst;
			}

			$ets .= $et->start();
			$ets .= 'D22' . chr(13);
			$ets .= '140000000400000' .	$namex . chr(13);
			$ets .= 'D22' . chr(13);
			$ets .= '120000000050000' . $inst . chr(13);
			$ets .= 'Q0001' . chr(13);
			$ets .= 'E' . chr(13);
		}
		if (count($db) == 0) {
			$sx = 'Menhuma etiqueta para imprimir';
		} else {
			$sql = "update events_inscritos set i_cracha=1 where 1=1";
			$this->db->query($sql);

			$et->et_print($ets);
		}
		return $sx;
	}
}
