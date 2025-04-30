<?php

namespace App\Models\OJS;

use CodeIgniter\Model;

class Publications extends Model
{
    protected $table            = 'works';
    protected $primaryKey       = 'id_w';
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

	function programEvents($id)
		{

			$cp = 'sch_day, esb_hora_ini, esb_hora_fim, esb_local, esb_titulo, esb_participantes, lc_nome, lc_class, id_lc as sala, id_sch as day';
			//$cp = '*';
			$dt = $this
					->select($cp)
					->join('event_schedule', 'id_e = sch_event')
					->join('event_schedule_bloco', 'id_sch = esb_day')
					->join('event_local','id_lc = esb_local')
					->where('id_e', $id)
					->orderBy('sch_day, esb_hora_ini, esb_local')
					->findAll();

			$dtt = [];
			# Dias
			$day = [];
			foreach($dt as $idd=>$d)
				{
					if (!isset($day[$d['day']]))
						{
							$day[$d['day']] =$d['sch_day'];
						}
				}
			# Salas
			$room = [];
			foreach ($dt as $idd => $d) {
				if (!isset($room[$d['sala']])) {
					$room[$d['sala']] = $d['lc_nome'];
				}
			}

			$dtt['programacao'] = $dt;
			$dtt['dias'] = $day;
			$dtt['salas'] = $room;

			return $dtt;
		}

	function getEvents($user=0)
		{
			$dt = [];
			$dt = $this
				->join('event_inscritos ', '(id_e = ein_event) AND (ein_user = '.$user.')', 'left')
				->where('e_sigin_until >= ', date('Y-m-d'))
				->findAll();
			return $dt;
		}
}
