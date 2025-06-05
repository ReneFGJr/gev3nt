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

	function session_ed($id, $ev)
	{
		if ($_POST != []) {
			$dd = $_POST;
			$dd['esb_event'] = $ev;
			$dd['esb_ativo'] = 1;
			$this->set($dd)
				->where('id_esb', $id)
				->where('esb_event', $ev)
				->update();
		}

		$dt = $this
			->join('event_schedule', 'id_sch = esb_day')
			->join('event_local','id_lc = esb_local')
			->where('id_esb', $id)
			->where('esb_event', $ev)
			->first();


		if ($dt == []) {
			return '<div class="alert alert-warning">Sessão não encontrada</div>';
		}

		$dt['days'] = $this
			->select('id_sch, sch_day')
			->join('event_schedule', 'id_sch = esb_day')
			->where('esb_event', $ev)
			->groupBy('id_sch, sch_day')
			->orderBy('sch_day')
			->findAll();

		$times = [];
		for ($i = 8; $i < 24; $i++) {
			$times[] = sprintf('%02d:00', $i);
			$times[] = sprintf('%02d:30', $i);
		}
		$dt['hours'] = $times;

		$times = [];
		for ($i = 8; $i < 24; $i++) {
			$times[] = sprintf('%02d:29', $i);
			$times[] = sprintf('%02d:59', $i);
		}
		$dt['hours2'] = $times;

		$rooms = $this
			->select('id_lc, lc_nome')
			->join('event_local', 'id_lc = esb_local')
			->where('esb_event', $ev)
			->groupBy('id_lc, lc_nome')
			->orderBy('lc_nome')
			->findAll();
		$dt['rooms'] = $rooms;

		return view('admin/event/scheduleForm', $dt);
	}

	function sessions($ev)
	{
		$dt = $this
			->select('*')
			->join('event_schedule', 'id_sch = esb_day')
			->join('event_local','id_lc = esb_local')
			->where('esb_event', $ev)
			->orderBy('esb_day, esb_local, esb_hora_ini')
			->findAll();

		if ($dt == []) {
			return '<div class="alert alert-warning">Nenhuma sessão programada</div>';
		}

		$sx = '<div class="row">';
		$xday = '';
		$xroom = '';
		foreach ($dt as $id => $line) {
			if ($xday != $line['sch_day']) {

				$xday = $line['sch_day'];
				$line['lc_class'] = 'text-primary';
				$sx .= view('admin/event/schedule_day', $line);
			}

			if ($xroom != $line['esb_local']) {

				$xroom = $line['esb_local'];
				$sx .= view('admin/event/schedule_room', $line);
			}
			//pre($line);
			//$line['sch_day'] = $line['esb_day'];
			//$line['lc_class'] = 'text-primary';
			//$line['lc_nome'] = $line['esb_local'];
			$sx .= view('admin/event/scheduleRow', $line);
		}
		$sx .= '</div>';
		return $sx;
	}

	function show($id,$ev)
	{
		$Publications = new \App\Models\OJS\Publications();
		$dt = $Publications
			->join('event_schedule_bloco', 'id_esb = w_programado')
			->join('event_schedule', 'id_sch = esb_day')
			->join('event_local','id_lc = esb_local')
			->where('w_id', $id)
			->where('w_evento', $ev)
			->first();

		if ($dt != []) {
			$sx = '<table class="table table-striped table-bordered">';
			$sx .= '<tr><td colspan="2" class="bg-light">';
			$sx .= '<h5>Local na programação</h5>';
			$sx .= '</td></tr>';
			$sx .= '<tr><td>';
			$data = $dt['sch_day'];
			$sx .= date('d/m/Y', strtotime($data));
			$sx .= ' - ';
			$hora = $dt['esb_hora_ini'];
			$hora = date('H:i', strtotime($hora));
			$sx .= $hora;
			$sx .= ' - ';
			$hora = $dt['esb_hora_fim'];
			$hora = date('H:i', strtotime($hora));
			$sx .= $hora;
			$sx .= ' - ';
			$sx .= $dt['lc_nome'];
			$sx .= '</td>';
			$sx .= '<td class="text-end">';
			$sx .= '<a href="'.base_url('admin/workEventCancel/'.$id.'/'.$ev).'" onclick="return confirm(\'Deseja cancelar a programação?\');" class="btn btn-danger btn-sm">Cancelar programação</a>';
			$sx .= '</td></tr>';
			$sx .= '</table>';

			return $sx;
		}
		return $dt;
	}

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
