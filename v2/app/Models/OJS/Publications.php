<?php

namespace App\Models\OJS;

use CodeIgniter\Model;

class Publications extends Model
{
	protected $table            = 'articles';
	protected $primaryKey       = 'id_w';
	protected $useAutoIncrement = true;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		'w_id',
		'titulo',
		'resumo',
		'nome_autor1',
		'sobrenome_autor1',
		'orcid_autor1',
		'pais_autor1',
		'instituicao_au,tor1',
		'email_autor1',
		'url_autor1',
		'editor1_email',
		'decisao1',
		'data_decisao1',
		'decisao2',
		'data_decisao2',
		'decisao3',
		'data_decisao3',
		'decisao4',
		'data_decisao4',
		'w_status',
		'w_programado',
		'w_evento',
		'w_autores',
		'w_keywords',
		'created_at',
		'updated_at',

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

	function authors($ev)
	{
		$dt = $this
			->where('w_evento', $ev)
			->where('w_status < 6')
			->findAll();
		$sx = '';
		$AUTH = [];

		foreach ($dt as $id => $line) {
			$autor = $line['w_autores'];
			if ($autor == '') {
				$autor = $line['nome_autor1'] . ' ' . $line['sobrenome_autor1'];
			}

			$autor = str_replace(',', ';', $autor);
			$au = explode(';', $autor);


			foreach($au as $id => $name) {
				$name = trim($name);
				$name = nbr_author($name,7);
				if ($name == '') {
					continue;
				}
				if (isset($AUTH[$name])) {
					$AUTH[$name] += 1;
				} else {
					$AUTH[$name] = 1;
				}
			}
		}
		ksort($AUTH);
		foreach($AUTH as $name => $id) {
			$sx .= '<li>' . $name . ' (' . $id . ')</li>';
		}
		$sx = '<ul>' . $sx . '</ul>';
		$sx = '<h3>Autores</h3>' . $sx;

		return $sx;
	}

	function works($ev)
	{
		$dt = $this
			->where('w_evento', $ev)
			->orderBy('w_status, titulo', 'asc')
			->findAll();
		$sx = '';
		$sx .= view('admin/work/info_filter');
		foreach ($dt as $id => $line) {
			//pre($line);
			$sx .= view('admin/work/info', $line);
		}
		return $sx;
	}

	function work($id, $ev)
	{
		$Publications_log = new \App\Models\OJS\Publications_log();

		/*** POST */
		if ($_POST) {
			$status = get('w_status');
			$dl = $this->where('id_w', $id)
				->where('w_evento', $ev)
				->first();

			if ($dl['w_status'] != $status) {
				if ($status != $dl['w_status']) {
					$Publications_log->log_insert($dl['id_w'],'Alterado status para ' . $status);
					$this->set(['w_status' => $status, 'w_update' => date('Y-m-d H:i:s')])
						->where('id_w', $id)
						->where('w_evento', $ev)
						->update();
				}
			}
		}

		/*************** View */
		$dt = $this
			->where('w_evento', $ev)
			->where('id_w', $id)
			->first();
		if ($dt == []) {
			return 'Work not found';
		}
		$sx = '';
		$sx .= view('admin/work/view', ['dados' => $dt]);
		$sx .= view('admin/work/view_status', ['dados' => $dt]);
		$sx .= $Publications_log->show($id);
		return $sx;
	}

	private function importCSV($csvPath, $ev)
	{
		$sx = '';
		$file = fopen($csvPath, 'r');
		fgetcsv($file); // Skip header

		while (($row = fgetcsv($file)) !== FALSE) {
			$data = [
				'w_id' => $row[0],
				'titulo' => $row[1],
				'resumo' => $row[2],
				'nome_autor1' => $row[3],
				'sobrenome_autor1' => $row[4],
				'orcid_autor1' => $row[5],
				'pais_autor1' => $row[6],
				'instituicao_autor1' => $row[7],
				'email_autor1' => $row[8],
				'url_autor1' => $row[9],
				'editor1_email' => $row[92],
				'decisao1' => $row[93],
				'data_decisao1' => $row[94] ?: null,
				'decisao2' => $row[95],
				'data_decisao2' => $row[96] ?: null,
				'decisao3' => $row[97],
				'data_decisao3' => $row[98] ?: null,
				'decisao4' => $row[99],
				'data_decisao4' => $row[100] ?: null,
				'w_evento' => $ev
			];

			$existingArticle = $this
				->where('w_id', $data['w_id'])
				->where('w_evento', $ev)
				->first();

			if (isset($existingArticle['w_id'])) {
				// Update existing article
				$this->set($data)->where('id_w', $existingArticle['id_w'])->update();
				$sx .= '<li>' . $data['w_id'] . ' was Updated</li>';
			} else {
				// Insert new article
				try {
					$this->insert($data);
					usleep(500000); // pausa de 0.5 segundos
					$sx .= '<li>' . $data['w_id'] . ' was Inserted</li>';
				} catch (\Exception $e) {
					$sx .= '<li>' . $data['w_id'] . ' was NOT Inserted: ' . $e->getMessage() . '</li>';
					continue;
				}
			}
		}
		fclose($file);
		return $sx;
	}

	function import($ev = 2)
	{
		$sx = '';
		$data = [];
		$data['action'] = 'admin/import';
		$data['message'] = get("message");
		$sx .= view('admin/info/ojs_import');
		$sx .= view('admin/form_upload', $data);
		$file = $_FILES;

		if (isset($file['csv_file']['name'])) {
			$file = $file['csv_file']['tmp_name'];
			$rsp = $this->importCSV($file, $ev);
			$sx .= view('admin/message', ['message' => 'Arquivo importado com sucesso.']);
			$sx .= $rsp;
		} else {
			$sx .= view('admin/message', ['message' => 'Arquivo inválido. Envie um CSV válido.', 'class' => 'danger']);
		}


		return $sx;
	}
}
