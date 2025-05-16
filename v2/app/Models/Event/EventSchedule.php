<?php

namespace App\Models\Event;

use CodeIgniter\Model;

class EventSchedule extends Model
{
    protected $table            = 'event_schedule_bloco';
    protected $primaryKey       = 'id_esb';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
		'id_esb',
		'esb_event',
		'esb_day',
		'esb_hora_ini',
		'esb_hora_fim',
		'esb_local',
		'esb_titulo',
		'esb_participantes',
		'esb_link',
		'esb_ativo'
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

	function programSchedule($idv,$ev)
		{
			$id_esb = get("id_esb");
			if ($id_esb != '') {
				$Publications = new \App\Models\OJS\Publications();
				$dd['w_programado'] = $id_esb;
				$dd['w_status'] = 2;
				$Publications->set($dd)->where('id_w', $idv)->update();
				$sx = '<script>window.location.href ="'.base_url('/admin/workEvent/' . $idv) . '";</script>';
				return $sx;
			}
			$cp = 'sch_day, esb_hora_ini, esb_hora_fim, esb_local, esb_titulo, esb_participantes, lc_nome, lc_class, id_lc as sala, id_sch as day';
			$cp = '*';
			$dt = $this
					->select($cp)
					->join('event_schedule', 'id_sch = esb_day')
					->join('event_local','id_lc = esb_local')
					->join('articles', 'id_esb = w_programado', 'left')
					->where('esb_event', $ev)
					->orderBy('sch_day, esb_hora_ini, esb_local')
					->findAll();

			$sx = '<div class="row">';
			$section = 0;
			$day = 0;
			foreach ($dt as $id => $line) {
				$xSection = $line['id_esb'];
				$xDay = $line['sch_day'];
				if ($xDay != $day) {
					$sx .= view('admin/event/schedule_day', $line);
					$day = $xDay;
				}
				if ($xSection != $section) {
					$sx .= view('admin/event/schedule_section', $line);
					$section = $xSection;
				}
				$sx .= view('admin/event/schedule', $line);
			}
			$sx .= '</div>';
			$line['work'] = $idv;
			$sx .= view('admin/event/schedule_js', $line);
			return $sx;
		}
	}
