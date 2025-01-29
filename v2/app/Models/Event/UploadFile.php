<?php

namespace App\Models\Event;

use CodeIgniter\Model;

class UploadFile extends Model
{
	protected $table            = 'events_file';
	protected $primaryKey       = 'if_f';
	protected $useAutoIncrement = true;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		'if_f',
		'f_type',
		'f_doc',
		'f_name'
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

	function recoverDocument($id,$type)
		{
			$dt = $this
			->where('f_doc', $id)
			->where('f_type', $type)
			->findAll();
			return($dt);
		}

	function saveDocument($file, $id, $type)
	{
		$dt = $this->recoverDocument($id, $type);
		if ($dt == []) {
			$dt = [
				'f_type' => $type,
				'f_doc' => $id,
				'f_name' => $file
			];
			$this->insert($dt);
		}
	}

	function valid_type($type, $rule = ['PDF', 'JPG', 'PNG'])
	{
		$ext = explode('/', $type);
		$ext = $ext[1];
		$ext = strtoupper($ext);
		$valid = 0;
		echo $ext;
		switch ($ext) {
			case 'PDF':
			case 'JPG':
			case 'PNG':
				$valid = 1;
				break;
		}
		return ($valid);
	}
}
