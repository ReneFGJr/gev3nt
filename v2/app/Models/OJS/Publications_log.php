<?php

namespace App\Models\OJS;

use CodeIgniter\Model;

class Publications_log extends Model
{
	protected $table            = 'articles_log';
	protected $primaryKey       = 'id_al';
	protected $useAutoIncrement = true;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		'al_log','al_user',
		'al_work'
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

	function show($id = 0)
	{
		$dt = [];
		$dt = $this
			->join('events_names', 'events_names.id_n = articles_log.al_user')
			->where('al_work', $id)
			->findAll();

		$sx = '<table class="table table-striped table-bordered table-hover" style="font-size: 10px;">';
		$sx.= '<tr>';
		$sx.= '<th>Data</th>';
		$sx.= '<th>Log</th>';
		$sx.= '<th>Nome</th>';
		$sx.= '</tr>';
		foreach ($dt as $id => $line) {
			$sx .= '<tr>';
			$sx .= '<td>' . $line['created_at'] . '</td>';
			$sx .= '<td>' . $line['al_log'] . '</td>';
			$sx .= '<td>' . $line['n_nome'] . '</td>';
			$sx .= '</tr>';
		}
		$sx .= '</table>';
		return $sx;
	}

	function log_insert($idw,$log)
	{
		$Users = new \App\Models\User\Users();
		$UserID = $Users->getCookie();

		$dt = [];
		$dt['al_log'] = $log;
		$dt['al_user'] = $UserID['id_n'];
		$dt['al_work'] = $idw;
		$ID = $this->set($dt)->insert();
		return $ID;
	}
}
