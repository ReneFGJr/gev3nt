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
