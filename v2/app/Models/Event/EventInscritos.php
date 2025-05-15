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
		$Message = new \App\Models\Messages\Index();
		return $Message->messages($tp, $dt);
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
