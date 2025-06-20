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

	function upload_list($id = 0)
	{
		$sx = '';
		$dir = '../uploads/';
		$sx .= '<h4>Lista de Apresentações</h4>';
		$ver = 0;
		for ($r = 100; $r > 0; $r--) {
			$fileID = 'presentation_' . str_pad($id, 8, "0", STR_PAD_LEFT) . '_' . $r . '.pdf';

			if (file_exists($dir . $fileID)) {
				$sx .= '<span class="btn btn-outline-success mt-2 mb-2">Arquivo de Apresentação</span>';
				$timestamp = filemtime($dir . $fileID);
				$sx .=  " - " . date("d/m/Y H:i:s", $timestamp);
				$sx .= '<br>';
				$ver++;
			}
		}
		if ($ver == 0) {
			$sx .= '<span>Nenhuma apresentação encontrada.</span>';
		} else {
			$sx .= '<div class="btn btn-success full mt-2 mb-2 text-center">Este trabalho já tem apresentação vinculada</div>';
		}
		return $sx;
	}

		function showZones($ev)
		{
			$sx = '<h2>Envio das apresentação</h2>';
			$sx .= 'Selecione o trabalho para enviar a apresentação.<br>';
			$sx .= 'Após clicar no link, você será redirecionado para a página de upload da apresentação.<br>';

			$ArticleDoc = new \App\Models\OJS\Publications();
			$db = $ArticleDoc
				->join('event_schedule_bloco', 'id_esb = w_programado','left')
				->join('event_schedule', 'esb_day = id_sch','left')

				->where('esb_event',$ev)
				->orderBy('esb_day, esb_hora_ini','ASC')
				->findAll();
			foreach($db as $line)
				{
					$sx .= '<br>';
					$sx .= '<b>' . $line['sch_day'] . ' ' . $line['esb_hora_ini'] . '</b> - ';
					$sx .= '<a class="" href="'.base_url('/upload_presentation/' . $line['w_id']) . '">' . $line['titulo'] . '</a>';
					$sx .= ' - ' . $line['w_autores'];
					$sx .= '<br>';
				}


			// Code to display media zones based on event ID
			// This is a placeholder for the actual logic to retrieve and display media zones
			return $sx;
		}

		function upload()
		{
			$sx = '<h4>Upload Media</h4>';
			$sx .= '<h5>Instruções para Apresentação</h5>';
			$sx .= '<p>Para enviar uma apresentação, por favor, siga as instruções abaixo:</p>';
			$sx .= '<ul>';
			$sx .= '<li>O arquivo deve estar no formato PDF.</li>';
			$sx .= '<li>O tamanho máximo do arquivo é de 10MB.</li>';
			$sx .= '<li>Está utilizando o template correto. <a href="https://isko.org.br/wp-content/uploads/2025/03/Template-ApresentacaoISKO2025.pptx">Baixar template</a></li>';
			$sx .= '<li>É possível subir uma nova versão até a data da apresentação.</li>';
			$sx .= '<li>Certifique-se de que o arquivo está livre de vírus.</li>';

			$sx .= '</ul>';
			$sx .= '<form method="post" enctype="multipart/form-data">';
			$sx .= '<input type="file" name="media_file" required>';
			$sx .= '<input type="submit" value="Upload">';
			$sx .= '</form>';

			return $sx;
			// Code to handle file upload
			// This is a placeholder for the actual upload logic
			return 'File upload functionality not implemented yet.';
		}

		function saveDocument()
			{}

		function valid_type($type)
		{
			//$validTypes = ['image', 'video', 'audio', 'document'];
			$validTypes = ['application/pdf'];
			return in_array($type, $validTypes);
		}
}
