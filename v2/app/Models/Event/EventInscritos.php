<?php

namespace App\Models\Event;

use CodeIgniter\Model;

class EventInscritos extends Model
{
	protected $table            = 'event_inscritos';
	protected $primaryKey       = 'id_ein';
	protected $useAutoIncrement = true;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		'ein_event',
		'ein_tipo',
		'ein_user',
		'ein_data',
		'ein_pago',
		'ein_pago_em',
		'ein_recibo'
	];

	protected bool $allowEmptyInserts = false;
	protected bool $updateOnlyChanged = true;

	protected array $casts = [];
	protected array $castHandlers = [];

	// Dates
	protected $useTimestamps = false;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks = true;
	protected $beforeInsert   = [];
	protected $afterInsert    = [];
	protected $beforeUpdate   = [];
	protected $afterUpdate    = [];
	protected $beforeFind     = [];
	protected $afterFind      = [];
	protected $beforeDelete   = [];
	protected $afterDelete    = [];



	public function summary($ev = 2)
	{
		$dt = $this
			->select('count(*) as total, ei_modalidade, sum(ei_preco) as valor')
			//->join('event', 'ein_event = id_e')
			->join('event_inscricoes', 'ein_tipo = id_ei')
			->where('ein_event', $ev)
			->groupBy('ei_modalidade')
			->findAll();
		$sx = '<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Modalidade</th>
						<th>Total</th>
						<th>Valor</th>
					</tr>
				</thead>
				<tbody>';
		$tot = 0;
		$ins = 0;
		foreach ($dt as $d) {
			$ins += $d['total'];
			$tot += $d['valor'];
			$sx .= '<tr>
							<td>' . $d['ei_modalidade'] . '</td>
							<td align="center">' . $d['total'] . '</td>
							<td align="right">R$ ' . number_format($d['valor'], 2, ',', '.') . '</td>
						</tr>';
		}
		$sx .= '</tbody>';
		$sx .= '<tfoot>
					<tr>
						<th>Total</th>
						<th style="text-align: center">' . $ins . '</th>
						<th style="text-align: right">R$ ' . number_format($tot, 2, ',', '.') . '</th>
					</tr>
				</tfoot>
				</table>';

		$dt = '<div class="row">
					<div class="col-md-12">
						<h4>Resumo de Inscrições</h4>
						' . $sx . '
					</div>';
		return $dt;
	}

	function email_alert($id)
	{
		$dt = $this
			->select('*')
			->join('event', 'ein_event = id_e')
			->join('event_inscricoes', 'ein_tipo = id_ei')
			->join('events_names', 'id_n = ein_user')
			->join('corporatebody', 'n_afiliacao = id_cb', 'left')
			->where('id_ein', $id)
			->first();
		if ($dt == []) {
			return 'Inscrição não encontrada';
		}
		if ($dt['ein_pago'] == 1) {
			return 'Inscrição já validada';
		}
		pre($_POST,false);
		if ($_POST) {
			$dt['type'] = [];
			$dt['type']['1'] = get("email");		# Enviar e-mail de cobrança
			$dt['type']['2'] = get("matricula");	# Solicitar comprovante de matrícula
			$dt['type']['3'] = get("pagamento");	# Solicitar comprovante de pagamento
			$message = $this->messages(3, $dt);
			$email = $dt['n_email'];
			$subject = 'Solicitação de Comprovantes para Validação da Inscrição ' . (string)$dt['e_name'];

			$EmailX = new \App\Models\IO\EmailX();
			$EmailX->sendEmail($email, $subject, $message);
			return "E-mail enviado com sucesso!";
		} else {
			$sx = view('admin/pay/pay_remember', $dt);
		}
		return $sx;

	}

	public function messages($tp = 0, $dt = [])
	{
		switch ($tp) {
			case '3':
			$message = 'Prezado(a) [Nome],
							<br>
							<br>Agradecemos sua inscrição no [Evento]. Entretanto, não identificamos a efetivação do pagamento da sua inscrição. Para darmos continuidade ao processo de validação, solicitamos que nos envie o(s) seguinte(s) documento(s):<ul>';

			if ($dt['type']['2'] == 1) {
				$message .= '<li>Comprovante de Depósito/PIX: referente ao pagamento da inscrição.</li>';
			}
			if ($dt['type']['3'] == 1) {
				$message .= '<li>Comprovante de Matrícula: para inscrições na categoria estudante de graduação ou pós-graduação.</li>';
			}

			$message .= '</ul><br>Pedimos que os documentos sejam encaminhados para o e-mail de contato [EventoEmail], identificando no assunto o seu nome completo e o número da inscrição.';
			$message .= '<p><b>Pagamento Realizado por Terceiros</b>: caso o pagamento tenha sido efetuado por terceiros, como uma fundação, solicitamos que informe o nome da fundação e a data do pagamento.</p>';
			$message .= '<p>Informamos que a programação completa do evento, bem como o status de validação da sua inscrição, estão disponíveis no sistema, por meio do link: [site].
							<br>Caso tenha alguma dúvida ou necessite de suporte, estamos à disposição.
							<br>Agradecemos sua participação e aguardamos o envio dos documentos para finalizarmos sua inscrição.
							</p>
							<br>Atenciosamente,
							<br><b>Comitê Organizador - [Evento]</b>';
							break;

			case '2': /* Confirmação de pagamento */
				$message = 'Prezado(a) [Nome],
							<br>
							<br>Agradecemos sua inscrição [Evento]!
							<br>
							<br>Temos o prazer de confirmar o recebimento de sua inscrição no evento.
							<br>
							<br>Detalhes da Inscrição:
							<br>Nome: [Nome]
							<br>Categoria: [Tipo]
							<br>Valor da inscrição: R$ [Valor]

							<br><b>Informações para pagamento:</b>
							<br>Para efetivar sua inscrição, realize o pagamento de forma rápida e segura via PIX utilizando a Chave PIX: 10.262.169/0001-73 em nome da Sociedade ISKO Brasil.
							<br>
							<br>Ou por meio de depósito bancário:
							<br>Sociedade ISKO Brasil
							<br>Banco do Brasil (Código: 001)
							<br>Agência: 0141-4
							<br>C/C: 70261-7
							<br>CNPJ: 10.262.169/0001-73
							<br>
							<br>
							<br>Próximos Passos:
							<br>📌 Em breve, você receberá mais informações sobre a programação completa e instruções para acessar o evento.
							<br>
							<br>📌 Você pode acompanhar por aqui a efetivação de sua inscrição.
							<br>
							<br>📌 Caso tenha alguma dúvida ou precise de suporte, entre em contato pelo e-mail: [EmailSuporte].
							<br>
							<br>Estamos ansiosos para recebê-lo(a) em nosso evento e proporcionar uma experiência enriquecedora com debates e aprendizados.
							<br>
							<br>Atenciosamente,
							<br><b>Comitê Organizador - [Evento]</b>';
				break;
			case '1': /* Confirmação de inscrição */
				$message = 'Prezado(a) [Nome],
							<br>
							<br>Agradecemos sua inscrição [Evento]!
							<br>
							<br>Temos o prazer de confirmar o recebimento do seu pagamento e sua participação no evento.
							<br>
							<br>Detalhes da Inscrição:
							<br>Nome: [Nome]
							<br>Categoria: [Tipo]
							<br>Valor Pago: R$ [Valor]
							<br>
							<br>Próximos Passos:
							<br>📌 Em breve, você receberá mais informações sobre a programação completa e instruções para acessar o evento.
							<br>📌 Caso tenha alguma dúvida ou precise de suporte, entre em contato pelo e-mail: [EmailSuporte].
							<br>
							<br>Estamos ansiosos para recebê-lo(a) em nosso evento e proporcionar uma experiência enriquecedora com debates e aprendizados.
							<br>
							<br>Atenciosamente,
							<br><b>Comitê Organizador - [Evento]</b>';
				break;
			default:
				$message = 'Nenhuma mensagem definida ' . $tp;
				break;
		}

		$message = str_replace('[Nome]', '<b>' . $dt['n_nome'] . '</b>', $message);
		$message = str_replace('[Evento]', $dt['e_name'], $message);
		$message = str_replace('[EventoEmail]', $dt['e_email'], $message);

		$message = str_replace('[Tipo]', $dt['ei_modalidade'], $message);
		$message = str_replace('[Valor]', number_format($dt['ei_preco'], 2, ',', '.'), $message);
		$message = str_replace('[Data]', $dt['cb_created'], $message);
		$message = str_replace('[EmailSuporte]', 'isko@isko.org.br', $message);

		return $message;
	}

	function myInscritos($UserID)
	{
		$dt = $this
			->select('*')

			->join('event', 'id_e = ein_event')
			->join('event_inscricoes', 'id_ei = ein_tipo')
			//->join('event_tipo', 'event_tipo.id_tipo = event_lotes.el_tipo')
			//->join('event_status', 'event_status.id_status = events.e_status')
			//->join('event_status as status_lote', 'status_lote.id_status = event_lotes.el_status')
			->where('ein_user', $UserID)
			->where('e_data_f >= ', date("Y-m-d"))
			->orderBy('e_data_f', 'DESC')
			->findAll();

		return $dt;
	}

	function getInscricao($id)
	{
		$dt = $this
			->select('*')
			->join('event', 'ein_event = id_e')
			->join('event_inscricoes', 'ein_tipo = id_ei')
			->join('events_names', 'id_n = ein_user')
			->join('corporatebody', 'n_afiliacao = id_cb', 'left')
			->where('id_ein', $id)
			->orderBy('ein_data desc, id_ein desc')
			->first();
		return $dt;
	}

	function getInscritos($id, $tp = 1)
	{
		switch ($tp) {
			case '1':
				$dt = $this
					->select('*')
					->join('event', 'ein_event = id_e')
					->join('event_inscricoes', 'ein_tipo = id_ei')
					->join('events_names', 'id_n = ein_user')
					->join('corporatebody', 'n_afiliacao = id_cb', 'left')
					->where('ein_event', $id)
					->where('ein_status in (1,2)')
					->orderBy('ein_data desc, id_ein desc')
					->findAll();
				break;
			case '2':
				$dt = $this
					->select('*')
					->join('event', 'ein_event = id_e')
					->join('event_inscricoes', 'ein_tipo = id_ei')
					->join('events_names', 'id_n = ein_user')
					->join('corporatebody', 'n_afiliacao = id_cb', 'left')
					->where('ein_event', $id)
					->where('ein_status in (1,2)')
					->orderBy('n_nome')
					->findAll();
				break;
			default:
				break;
		}
		return $dt;
	}

	function getSubscribe($id)
	{
		$dt = $this
			->select('*')
			->join('event', 'ein_event = id_e')
			->join('event_inscricoes', 'ein_tipo = id_ei')
			->where('id_ein', $id)
			->where('ein_status in (1,2)')
			->first();
		return $dt;
	}

	function subscribe($UserId, $id, $lote)
	{
		$PAGO = 0;
		$dt = $this->where('ein_event', $id)
			->where('ein_user', $UserId)
			->where('ein_tipo', $lote)
			->first();
		if ($dt == []) {
			$EventTipo = new \App\Models\Event\EventInscricoes();
			$dataEvent = $EventTipo->find($lote);
			$preco = $dataEvent['ei_preco'];
			if ($preco == 0) {
				$PAGO = 1;
			}

			$data = [
				'ein_event' => $id,
				'ein_user' => $UserId,
				'ein_tipo' => $lote,
				'ein_data' => date("Y-m-d"),
				'ein_pago' => $PAGO,
				'ein_pago_em' => '',
				'ein_recibo' => ''
			];

			/* Email de confirmação */
			$Users = new \App\Models\User\Users();
			$dataUser = $Users->find($UserId);
			$Events = new \App\Models\Event\Events();
			$dataEvent = $Events->find($id);
			$dataModalidade = new \App\Models\Event\EventInscricoes();
			$TipoInscricao = new \App\Models\Event\EventInscricoes();
			$TipoInscricao = $TipoInscricao->find($lote);
			$data = array_merge($data, $dataUser, $dataEvent, $TipoInscricao);
			$data['cb_created'] = date("Y-m-d H:i:s");
			$message = $this->messages(2, $data);

			$email = $data['n_email'];
			$subject = 'Confirmação de inscrição no evento ' . (string)$dataEvent['e_name'];

			$EmailX = new \App\Models\IO\EmailX();
			$EmailX->sendEmail($email, $subject, $message);

			$ID = $this->insert($data);
		} else {
			$ID = $dt['id_ein'];
		}
		if (isset($_FILES['comprovante'])) {
			$dir = '../uploads/';
			// Verifica se o diretório existe antes de criar
			if (!is_dir($dir)) {
				mkdir($dir, 0777, true);
			}

			$fileID = 'doc_' . str_pad($ID, 8, "0", STR_PAD_LEFT);
			move_uploaded_file($_FILES['comprovante']['tmp_name'], $dir . $fileID . '.pdf');
			$UploadFiles = new \App\Models\Event\UploadFile();
			$UploadFiles->saveDocument($dir . $fileID . '.pdf', $ID, 'registration');
		}
		return $ID;
	}
}
