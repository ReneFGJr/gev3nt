<?php

namespace App\Models\Media;

use CodeIgniter\Model;

class Index extends Model
{
    protected $table            = 'indices';
    protected $primaryKey       = 'id';
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

	function index($act,$id)
		{
			switch($act)
				{
					case 'upload':
						$sx = $this->upload();
						break;
					default:
						$ev = 2;
						$sx = '<h4>Midias Zone</h4>';
						$sx.= $this->showZones($ev);
				}
				return $sx;
		}

		function showZones($ev)
		{
			$sx = 'Displaying media zones for event ID: ' . $ev;
			$EventSchedule = new \App\Models\Event\EventSchedule();

			$db = $EventSchedule
				->join('event_schedule', 'esb_day = id_esb')
				->join('event_local', 'esb_local = id_lc')
				->where('esb_event',$ev)
				->orderBy('esb_day, esb_hora_ini','ASC')
				->findAll();
			pre($db);
			// Code to display media zones based on event ID
			// This is a placeholder for the actual logic to retrieve and display media zones
			return $sx;
		}

		function upload()
		{
			// Code to handle file upload
			// This is a placeholder for the actual upload logic
			return 'File upload functionality not implemented yet.';
		}
}
