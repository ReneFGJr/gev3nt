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


	function showTypeInscricoes($id)
		{
			$sx = '';
			$dc = $this->lotesInscricoesTodos($id);

			$dc = array_map(function ($item) {
				$item['ei_data_inicio'] = date('d/m/Y', strtotime($item['ei_data_inicio']));
				$item['ei_data_final'] = date('d/m/Y', strtotime($item['ei_data_final']));
				return $item;
			}, $dc);

			$dfl = '';
			$sx .= '<table class="table table-striped table-bordered table-hover mt-3">';
			foreach ($dc as $key => $value) {
				$df = $value['ei_descricao'];
				if ($dfl != $df)
					{
						$dfl = $df;
						$sx .= '<tr><th colspan="3" class="h4">'.$dfl.'</th></tr>';
					}
				$sx .= '<tr>';
				$sx .= '<td class="text-center" style="width: 20%;">até '.$value['ei_data_final'].'</td>';
				$sx .= '<td class="text-center" style="width: 60%;">'.$value['ei_modalidade'].'</td>';
				$sx .= '<td class="text-center" style="width: 20%;">' . number_format($value['ei_preco'],2,',','.') . '</td>';
				$sx .= '</tr>';
			}
			$sx .= '</table>';
			return ($sx);
		}
	function lotesInscricoesTodos($id_e)
	{
		$rlt = $this
			->where('ei_event', $id_e)
			->orderBy('ei_descricao, ei_data_inicio, ei_modalidade, ei_preco desc')
			->findAll();
		return ($rlt);
	}

	function lotesInscricoes($id_e)
	{
		$rlt = $this
			->where('ei_event', $id_e)
			->where('ei_data_inicio <=', date("Y-m-d"))
			->where('ei_data_final >=', date("Y-m-d"))
			->orderBy('ei_descricao, ei_data_inicio, ei_modalidade')
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
