<?php
class Main extends CI_controller
{
	function __construct()
	{
		parent::__construct();
		$this->lang->load("login", "portuguese");
		//$this -> lang -> load("skos", "portuguese");
		//$this -> load -> library('form_validation');
		$this->load->database();
		$this->load->helper('form');
		$this->load->helper('form_sisdoc');
		$this->load->helper('email');
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('tcpdf');
		$this->load->helper('socials');

		if (!isset($_SESSION["CURSO"])) {
			$_SESSION['CURSO'] = 5;
		}
		DEFINE("CURSO", $_SESSION['CURSO']);
		DEFINE("LIBRARY","");

		date_default_timezone_set('America/Sao_Paulo');
		/* Security */
		//		$this -> security();
	}

	function login()
	{
		redirect(base_url('index.php/main'));
	}

	function social($path = '')
	{
		$this->cab();
		$socials = new socials;
		$data['content'] = $socials->social($path);
		$this->load->view("content", $data);
	}

	function index($action = '', $arg = '', $arg2 = '')
	{
		$this->load->model('events');
		$this->events->index($action, $arg, $arg2);
	}

	function evento($action = '', $arg = '', $arg2 = '')
	{
		$this->load->model('events');
		$this->events->index($action, $arg, $arg2);
	}

	private function cab($navbar = 1)
	{
		define("PATH", "index.php/main/");
		define("LIBRARY_NAME", "ebbc");
		$this->load->helper('socials');
		$data['title'] = 'Encontro Brasileiro de Bibliometria e Cientometria ::::';
		$this->load->view('header/header', $data);
		if ($navbar == 1) {
			$this->load->view('header/navbar', null);
		}
	}

	private function foot()
	{
		$this->load->view('header/footer');
	}



	public function contact()
	{
		$this->load->model('comgrads');
		$this->cab();
		$data = array();
		$data['title'] = '';
		$data['content'] = $this->comgrads->contact();
		$this->load->view('content', $data);
	}

	public function about()
	{
		$this->load->model('comgrads');
		$this->cab();
		$data = array();
		$data['title'] = '';
		$data['content'] = $this->comgrads->about();
		$this->load->view('content', $data);
	}

	public function persons($id = '')
	{
		$this->load->model('comgrads');
		$this->load->model('pags');
		$this->cab();
		$form = new form;
		$form->tabela = $this->pags->tabela;
		$form->see = true;
		$form->row = base_url('index.php/main/persons');
		$form->row_view = base_url('index.php/main/person');
		$form->row_edit = base_url('index.php/main/persons');
		$form->edit = False;
		$form->novo = False;
		$form = $this->pags->row($form);

		$data['title'] = 'Estudantes';
		$data['content'] = row($form, $id);
		$this->load->view('content', $data);
	}

	public function contact_ed($id)
	{
		$this->load->model('comgrads');
		$this->cab(0);
		$sx = $this->comgrads->contact_ed($id);
		$data['content'] = $sx;
		$this->load->view('content', $data);
	}

	public function person($id = 0)
	{
		$this->load->model('comgrads');
		$this->load->model('mensagens');
		$this->load->model('pags');
		$this->cab();
		$data = array();

		$data = $this->pags->le($id);
		$total_mensagens = $this->mensagens->mensagens_total($id);

		$data['title'] = $data['p_nome'];
		$data['content'] = $this->load->view('person/show', $data, true);
		$this->load->view('content', $data);

		$sx = '<div class="row">';
		$sx .= '<div class="col-md-3">';
		$sx .= $this->load->view('person/person_contato', $data, true);
		$sx .= '</div>';

		$sx .= '<div class="col-md-3">';
		$sx .= $this->load->view('person/person_curso', $data, true);
		$sx .= '</div>';

		$sx .= '<div class="col-md-3">';
		$sx .= $this->load->view('person/person_creditos', $data, true);
		$sx .= '</div>';

		$sx .= '<div class="col-md-3">';
		$sx .= $this->load->view('person/person_indicadores', $data, true);
		$sx .= '</div>';
		$data['content'] = $sx;
		$this->load->view('content', $data);

		$sx = '<hr>' . $this->mensagens->mostra_mensagens($id);
		$sx .= $this->mensagens->nova_mensagem($id);
		$data['content'] = $sx;
		$this->load->view('content', $data);

		$sx = $this->load->view('person/gr_tim', $data, true);
		$data['content'] = $sx;
		$this->load->view('content', $data);
	}

	public function pag()
	{
		$this->load->model('comgrads');
		$this->load->model('pags');
		$this->cab();
		$data = array();
		$tela = '';

		$data['title'] = 'Comgrad/PAG';
		$file = 'xx';
		if (isset($_FILES['userfile']['tmp_name'])) {
			$file = $_FILES['userfile']['tmp_name'];
		}
		if (file_exists($file)) {
			$data['content'] = $this->pags->inport($file);
			$this->load->view('content', $data);
		}
		if (file_exists($file)) {
			$data['content'] = $this->pags->inport($file);
			$this->load->view('content', $data);
		} else {
			$tela = $this->pags->form_file();
			if (strlen($file) > 0) {
				$tela .= "OPS. file not found " . $file;
			}
		}

		$data['content'] = $tela;
		$data['title'] = 'Importação de Arquivos';
		$this->load->view('content', $data);
	}

	public function persons_list()
	{
		$this->load->model('comgrads');
		$this->load->model('pags');
		$this->cab();

		$data['content'] = $this->pags->list_acompanhamento(999999, 'p_nome');
		$data['title'] = 'lista';
		$this->load->view('content', $data);

		$this->foot();
	}

	public function import_ROD()
	{
		$this->load->model('comgrads');
		$this->load->model('pags');
		$this->cab();
		$data = array();

		$form = new form;
		$cp = array();
		array_push($cp, array('$H8', '', '', false, true));
		array_push($cp, array('$T80:5', '', 'Cracha', True, true));
		$m = 'Informe o número do crachá dos estudantes incluindo um em cada linha, ou utilize o ";" como separador';
		array_push($cp, array('$M', '', $m, false, true));
		$op = '1:Incluir em ROD';
		$op .= '&2:Incluir em Controle de Matricula';
		$op .= '&3:Incluir em Bloqueio';
		array_push($cp, array('$O ' . $op, '', 'Cracha', True, true));
		array_push($cp, array('$B8', '', 'Incluir >>>', False, true));
		$tela = $form->editar($cp, '');
		$data['title'] = 'Comgrad/PAG';
		$data['content'] = $tela;
		$this->load->view('content', $data);

		if ($form->saved > 0) {
			$t = get("dd1");
			$t = troca($t, chr(13), ';');
			$ts = splitx(';', $t);
			for ($r = 0; $r < count($ts); $r++) {
				$this->pags->incluir_acompanhamento($ts[$r], get("dd3"));
			}
		}
		$data['content'] = $this->pags->list_acompanhamento();
		$data['title'] = 'lista';
		$this->load->view('content', $data);
	}

	function campanha_email($arg)
	{
		$this->load->model('comgrads');
		$this->load->model('pags');
		$this->cab();

		$tela = '';

		$data = $this->pags->le_campanha($arg);
		$data = $this->pags->le_campanha($arg);
		$tela .= '<table width="100%" class="table">';
		$tela .= '<tr><td width="10%">Campanha</td>
                            <td style="font-size: 150%; border-bottom: 1px solid #000000;"><b>' . $data['ca_nome'] . '</b></td>
                      </tr>';
		$tela .= '</table>';

		$cp = array();
		array_push($cp, array('$H8', '', '', false, false));
		array_push($cp, array('$S80', '', 'Título do e-mail', true, true));
		array_push($cp, array('$T80:6', '', 'Texto para o e-mail', true, true));
		array_push($cp, array('$B8', '', 'Enviar e-mail >>>', false, true));
		$form = new form;

		$tela .= $form->editar($cp, '');

		if ($form->saved > 0) {
			$title = '[COMGRAD] ' . get("dd1");
			$texto = get("dd2");
			$tela = $this->pags->campanha_enviar_email($arg, $title, $texto);
		}
		$data['content'] = $tela;

		$this->load->view('content', $data);
	}

	function campanha_prepara($id)
	{
		$this->load->model('comgrads');
		$this->load->model('pags');
		$this->cab();

		$data = $this->pags->le_campanha($id);
		$arg2 = $data['ca_acompanhamento'];

		$this->pags->campanha_prepara($id, $arg2);
		redirect(base_url('index.php/main/campanha/' . $id));
	}

	function campanha_selecionar_alunos($arg = '')
	{
		$this->load->model('pags');
		$this->cab();
		$this->pags->alunos_select($arg);
		redirect(base_url('index.php/main/campanha/' . $arg));
	}

	function campanha_xls($arg = '')
	{
		header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
		header("Content-type:   application/x-msexcel; charset=utf-8");
		header("Content-Disposition: attachment; filename=Comgrad_" . date("Ymd-His") . ".xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private", false);

		$this->load->model('comgrads');
		$this->load->model('pags');
		echo utf8_decode($this->pags->export_answer($arg));
	}

	function campanha($arg = '')
	{
		$this->load->model('comgrads');
		$this->load->model('pags');
		$this->cab();

		$tela = '';

		$data = $this->pags->le_campanha($arg);
		$tela .= '<table width="100%" class="table">';
		$tela .= '<tr><td width="10%">Campanha</td>
                            <td style="font-size: 150%; border-bottom: 1px solid #000000;"><b>' . $data['ca_nome'] . '</b></td>
                      </tr>';
		$tela .= '<tr><td></td>
                            <td>
                                <a class="btn btn-secondary" href="' . base_url('index.php/main/campanhas_questionario_edit/' . $arg) . '">Editar Questionário</a>
                                |
                                <a class="btn btn-secondary" href="' . base_url('index.php/main/campanhas_edit/' . $arg) . '">Editar Campanha</a>
                                |
                                <a class="btn btn-secondary" href="' . base_url('index.php/main/campanha_email/' . $arg) . '">Envia e-mail</a>
                                |
                                <a class="btn btn-primary" href="' . base_url('index.php/main/campanha_selecionar_alunos/' . $arg) . '">Marcar Alunos</a>
                                |
                                <a class="btn btn-warning" href="' . base_url('index.php/main/campanha_cancela_alvo/' . $arg) . '">Excluir todos</a>
                            </td>
                      </tr>';
		$tela .= '</table>';

		$tela .= $this->pags->campanha_situacao($arg);

		$data['content'] = $tela;
		$data['title'] = 'lista';
		$this->load->view('content', $data);
		$this->foot();
	}

	function campanha_cancela_alvo($id = '')
	{
		$this->load->model('comgrads');
		$this->load->model('pags');
		$this->cab();

		$this->pags->cancela_campanha($id);
		redirect(base_url('index.php/main/campanha/' . $id));
	}

	function campanhas($id = '')
	{
		$this->load->model('comgrads');
		$this->load->model('pags');
		$this->cab();

		$form = new form;
		$form->tabela = '(select * from campanha inner join person_curso ON ca_curso = id_pc) as camp';
		$form->see = true;
		$form->row = base_url('index.php/main/campanhas');
		$form->row_view = base_url('index.php/main/campanha');
		$form->row_edit = base_url('index.php/main/campanhas_edit');

		$form->edit = True;
		$form->novo = True;
		$form = $this->pags->row_campanhas($form);

		$data['title'] = 'Estudantes';
		$data['content'] = row($form, $id);
		$this->load->view('content', $data);
	}

	function campanhas_edit($id = '', $chk = '')
	{
		$this->load->model('comgrads');
		$this->load->model('pags');
		$this->cab();

		$cp = $this->pags->cp_campanhas($id);
		$form = new form;
		$form->id = $id;
		$data['content'] = $form->editar($cp, 'campanha');
		$data['title'] = msg('campanhas');
		$this->load->view('content', $data);

		if ($form->saved > 0) {
			redirect(base_url('index.php/main/campanhas'));
		}
	}

	function questionario_ver($id = '', $chk = '')
	{
		$this->load->model('comgrads');
		$this->load->model('pags');
		$this->cab(0);

		$chk2 = checkpost_link($id);
		if ($chk2 == $chk) {
			$tela = $this->pags->questionario_ver($id);
			$data['content'] .= $tela;
			$data['title'] = 'lista';
			$this->load->view('content', $data);
		} else {
			echo '=' . $chk . '<br>=' . $chk2;
		}
	}

	function campanhas_questionario_edit($arg1 = '')
	{
		$this->load->model('comgrads');
		$this->load->model('pags');
		$this->cab();
		$data['content'] = $this->pags->questionario_editar($arg1);
		$this->load->view('content', $data);
		$this->foot();
	}

	function campanhas_questionario_editar($arg1 = '', $arg2 = '')
	{
		$this->load->model('comgrads');
		$this->load->model('pags');
		$this->cab(0);
		$data['content'] = $this->pags->questionario_editar_cp($arg2, $arg1);
		$this->load->view('content', $data);
	}

	function questionario($arg1 = '', $arg2 = '', $chk = '')
	{
		$this->load->model('comgrads');
		$this->load->model('pags');
		$this->cab(0);

		$chk2 = checkpost_link($arg1 . $arg2);
		if ($chk2 != $chk) {
			$data['content'] = 'Checksun do link é inválido';
			$this->load->view('errors/error', $data);
			return ("");
		}

		$data['content'] = $this->pags->questionario($arg1, $arg2);
		$data['content'] .= $this->load->view('header/form_style', null, true);
		$data['title'] = 'lista';
		$this->load->view('content', $data);
	}

	function comunicacao()
	{
		$this->cab();
		$this->load->model('comgrads');
		$data['content'] = $this->comgrads->comunicacao();
		$data['title'] = 'Enviar e-mail';
		$this->load->view('content', $data);
	}

	function relatorio($rel = '1', $arg1 = '', $arg2 = '', $arg3 = '')
	{
		$this->load->model('comgrads');
		$this->load->model('pags');
		$this->cab();
		$data = array();
		switch ($rel) {
			case '1':
				$data['content'] = $this->pags->rel_alunos_matriculados();
				$data['title'] = 'lista';
				break;
			case '2':
				$data['content'] = $this->pags->rel_alunos_periodo($arg1, $arg2);
				$data['title'] = 'lista';
				break;
			case '3':
				$data['content'] = $this->pags->rel_tempo_medio_integralizacao($arg1, $arg2);
				$data['title'] = 'lista';
				break;
			case '4':
				$data['content'] = $this->comgrads->rel_bairros($arg1, $arg2);
				$data['title'] = 'lista';
				break;
			case '5':
				$data['content'] = $this->comgrads->rel_email($arg1, $arg2);
				$data['title'] = 'lista';
				break;
			case '6':
				$data['content'] = $this->pags->rel_idade_media($arg1, $arg2);
				$data['title'] = 'Idade Média';
				break;
		}

		$this->load->view('content', $data);
	}

	function cliente_mensagem_edit($id, $cliente)
	{
		$this->load->model('mensagens');
		//$this -> load -> model('clientes');

		$data['nocab'] = true;
		$this->cab($data);

		$cp = $this->mensagens->cp($cliente);
		$form = new form;
		$form->id = $id;
		$data['content'] = $form->editar($cp, $this->mensagens->table);
		$data['title'] = msg('mensagens');
		$this->load->view('content', $data);

		if ($form->saved > 0) {
			if (get("dd5") == '1') {
				$assunto = utf8_decode(get("dd3"));
				$text = utf8_decode(get("dd4"));
				$de = 1;
				$anexos = array();
				$this->clientes->enviaremail_cliente($cliente, $assunto, $text, $de, $anexos);
			}
			$data['content'] .= '<script> wclose(); </script>';
			$this->load->view('content', $data);
		}
	}

	function mailer()
	{
		$this->load->model('mensagens');
		//$this -> load -> model('clientes');

		$data['nocab'] = true;
		$this->cab($data);

		$cp = array();
		array_push($cp, array('$H8', '', '', False, True));
		array_push($cp, array('$T80:6', '', 'Lista de e-mail', True, True));
		array_push($cp, array('$Q id_m:m_descricao:select * from mensagem_own where m_ativo = 1', '', 'Enviador', True, True));
		array_push($cp, array('$S80', '', msg('msg_subject'), True, True));
		array_push($cp, array('$T80:5', '', msg('msg_content'), True, True));
		array_push($cp, array('$O 0:NÃO&1:SIM', '', 'Enviar e-mail ao cliente', True, True));

		$form = new form;
		$data['content'] = $form->editar($cp, '');
		$data['title'] = msg('mensagens');
		$this->load->view('content', $data);

		if ($form->saved > 0) {
			if (get("dd5") == '1') {
				$assunto = utf8_decode(get("dd3"));
				$text = utf8_decode(get("dd4"));
				$de = 1;
				$anexos = array();
				$l = get("dd1");
				$l = troca($l, chr(13), ';');
				$l = troca($l, chr(10), '');
				$ln = splitx(';', $l);
				for ($r = 0; $r < count($ln); $r++) {
					$email = $ln[$r];
					echo '<br>==>' . $email;
					$to = $email;
					$subject = $assunto;
					$message = $text;
					$headers = 'From: PPGCIN-UFRGS<ppgcin@ufrgs.br>' . "\r\n" . 'Reply-To: ppgcin@ufrgs.br' . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1';

					mail($email, $assunto, $text, $headers);
				}
			}
			$data['content'] = '';
			$this->load->view('content', $data);
		}
	}

	function prerequisito_nr($nr)
	{
		$this->load->model('comgrads');
		$this->cab();
		$data = array();
		$data['title'] = '';
		$data['content'] = $this->comgrads->prerequisito_nrs($nr);
		$data['content'] .= $this->comgrads->avaliacao($nr);

		$this->load->view('content', $data);
	}

	function prerequisito()
	{
		$this->load->model('comgrads');
		$this->cab();
		$data = array();
		$data['title'] = '';
		$data['content'] = $this->comgrads->prerequisito_form();

		$this->load->view('content', $data);
	}

	function prerequisito_analise()
	{
		$this->load->model('comgrads');
		$this->cab();
		$data = array();
		$data['title'] = '';
		$data['content'] = $this->comgrads->prerequisito_analise();

		$data['content'] .= '<a href="' . base_url('index.php/main/prerequisito') . '" class="btn btn-secondary">Solicitar quebra</a>';

		$this->load->view('content', $data);
	}

	function show_perfil()
	{
		$id = $_SESSION['id'];
		$this->load->model('socials');

		$this->cab();
		$data['title'] = '';
		$data['content'] = $this->socials->show_perfil($id);
		$this->load->view('content', $data);
	}
}
