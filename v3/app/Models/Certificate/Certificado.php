<?php

namespace App\Models\Certificate;

use CodeIgniter\Model;
use TCPDF;

class Certificado extends Model
{
	protected $table            = 'articles';
	protected $primaryKey       = 'id_w';
	protected $useAutoIncrement = true;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		'w_id',
		'w_certificado'
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

	function list($ev)
	{
		$id = get("id");
		if ($id != '') {
			$this->update_certificado($id, '1');
		}
		$certificados =
			$this
				->join('event_schedule_bloco', 'w_programado = id_esb')
				->join('event_schedule', 'esb_day = id_sch')
				->join('event_local', 'id_lc = esb_local')
				->where('w_evento', $ev)
				->where('w_certificado', 0)
				->orderBy('esb_day, esb_hora_ini, esb_local', 'ASC')
				->findAll();

		if (empty($certificados)) {
			return '<p>Nenhum certificado encontrado.</p>';
		}

		$sx = '<table class="table table-striped">';
		$sx .= '<thead><tr><th>ID</th><th>Certificado</th></tr></thead>';
		$sx .= '<tbody>';

		foreach ($certificados as $certificado) {
			$sx .= '<tr>';
			$sx .= '<td>';
			$sx .= $certificado['w_id'] . '</td>';
			$sx .= '<td>';
			$sx .= $certificado['sch_day'].' '.$certificado['esb_hora_ini'].' - '.$certificado['lc_nome'];
			$sx .= '<hr>';
			$sx .= $certificado['titulo'];
			$sx .= '<br><i>'. $certificado['w_autores'].'</i>';
			$sx .= '</td>';
			$sx .= '<td>';
			if ($certificado['w_certificado'] == '1') {
				$sx .= '<a href="' . base_url('certificate/' . $certificado['w_id']) . '" class="btn btn-primary">Ver Certificado</a>';
			} else {
				$sx .= '<a href="' . base_url('admin/certificados/presentation?id=' . $certificado['w_id']) . '" class="btn btn-outline-primary full">Liberar</a>';
			}
			$sx .= '</td>';
			$sx .= '</tr>';
		}

		$sx .= '</tbody></table>';

		return $sx;
	}

	function update_certificado($id, $certificado)
	{
		$data = [
			'w_certificado' => $certificado
		];

		$this->set($data)->where('w_id', $id)->update();
		return '';
	}
}
