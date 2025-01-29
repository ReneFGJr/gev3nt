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

	function myInscritos($UserID)
		{
			$dt = $this
				->select('*')

				->join('events', 'ein_tipo = ein_event')
				->join('event_inscricoes', 'id_ei = ein_tipo')
				//->join('event_tipo', 'event_tipo.id_tipo = event_lotes.el_tipo')
				//->join('event_status', 'event_status.id_status = events.e_status')
				//->join('event_status as status_lote', 'status_lote.id_status = event_lotes.el_status')
				->where('ein_user', $UserID)
				->where('e_data >= ', date("Y-m-d"))
				->orderBy('events.e_data', 'DESC')
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
			$dt = $this->where('ein_event', $id)
				->where('ein_user', $UserId)
				->where('ein_tipo', $lote)
				->first();
			if ($dt == [])
				{
					$data = [
						'ein_event' => $id,
						'ein_user' => $UserId,
						'ein_tipo' => $lote,
						'ein_data' => date("Y-m-d"),
						'ein_pago' => 0,
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
				}
			return $ID;
		}
}
