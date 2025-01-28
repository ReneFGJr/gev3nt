<?php

namespace App\Models\Event;

use CodeIgniter\Model;

class EventInscricoes extends Model
{
    protected $table            = 'event_inscricoes';
    protected $primaryKey       = 'id_ei';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

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


	function lotesInscricoes($id_e)
	{
		$rlt = $this
			->where('ei_event', $id_e)
			->where('ei_data_inicio <=', date("Y-m-d"))
			->where('ei_data_final >=', date("Y-m-d"))
			->orderBy('ei_data_inicio, ei_modalidade')
			->findAll();
		return($rlt);
	}

	function getLote($id)
	{
		$rlt = $this
			->where('id_ei', $id)
			->find();
		return($rlt);
	}
}
