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

	public function messages($tp = 0,$dt=[])
	{
		switch($tp)
			{
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
							<br>Data do Pagamento: [Data]
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
					$message = 'Nenhuma mensagem definida '.$tp;
					break;
			}

			$message = str_replace('[Nome]','<b>'.$dt['n_nome'].'</b>',$message);
			$message = str_replace('[Evento]',$dt['e_name'],$message);

			$message = str_replace('[Tipo]',$dt['ei_modalidade'],$message);
			$message = str_replace('[Valor]',number_format($dt['ei_preco'],2,',','.'),$message);
			$message = str_replace('[Data]',$dt['cb_created'],$message);
			$message = str_replace('[EmailSuporte]','isko@isko.org.br',$message);

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
		->join('corporatebody', 'n_afiliacao = id_cb','left')
		->where('id_ein', $id)
		->orderBy('ein_data desc, id_ein desc')
		->first();
		return $dt;
	}

	function getInscritos($id)
		{
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
			if ($dt == [])
				{
					$EventTipo = new \App\Models\Event\EventInscricoes();
					$dataEvent = $EventTipo->find($lote);
					$preco = $dataEvent['ei_preco'];
					if ($preco == 0)
						{
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
					$ID = $this->insert($data);
				} else {
					$ID = $dt['id_ein'];
				}
			if (isset($_FILES['comprovante']))
				{
					$dir = '../uploads/';
					// Verifica se o diretório existe antes de criar
					if (!is_dir($dir)) {
						mkdir($dir, 0777, true);
					}

					$fileID = 'doc_'.str_pad($ID, 8, "0", STR_PAD_LEFT);
					move_uploaded_file($_FILES['comprovante']['tmp_name'], $dir . $fileID . '.pdf');
					$UploadFiles = new \App\Models\Event\UploadFile();
					$UploadFiles->saveDocument($dir . $fileID.'.pdf', $ID, 'registration');
				}
			return $ID;
		}
}
