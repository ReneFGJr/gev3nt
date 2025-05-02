<?php

namespace App\Models\OJS;

use CodeIgniter\Model;

class Api extends Model
{
	protected $table            = 'articles';
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

	function updateDB($id)
		{
			$sx = '';
			$Work = new \App\Models\OJS\Publications();
			$dados = $Work->where('w_id', $id)->first();
			if ($dados == []) {
				echo "ID: " . $id;
				echo "Article not found";
				exit;
			}
			$dt = $this->api_article($id);
			if ($dt['title'] != $dados['titulo']) {
				$Work->set('titulo', $dt['title'])->where('w_id', $id)->update();
				$sx .= "Title: " . $dt['title'] . " Update<br>";
			}

			if ($dt['authors'] != $dados['w_autores']) {
				$Work->set('w_autores', $dt['authors'])->where('w_id', $id)->update();
				$sx .= "Authors: " . $dt['authors'] . " Update<br>";
			}
			return $sx;
		}

	function api_article($id)
	{
		$Publications = new \App\Models\OJS\Publications();
		$dt = $Publications->where('w_id', $id)->first();
		if ($dt == []) {
			echo "ID: " . $id;
			echo "Article not found";
			exit;
		}
		//echo "<pre>";
		$submissionId = $dt['w_id'];
		$apiKey = getenv("ojs_apikey");
		$journalPath = 'iskobrasil2025';
		$baseUrl = 'https://isko.org.br/ojs';

		$url = $baseUrl . '/index.php/' . $journalPath . '/api/v1/submissions/' . $submissionId;
		//https://isko.org.br/ojs/index.php/iskobrasil2025/api/v1/submissions/80

		$ch = curl_init($url);

		curl_setopt_array($ch, [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => [
				'Authorization: Bearer ' . $apiKey,
				'Accept: application/json',
			],
		]);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if (curl_errno($ch)) {
			echo 'Erro na requisição: ' . curl_error($ch);
		} elseif ($httpCode !== 200) {
			echo "Erro HTTP $httpCode: " . $response;
		} else {
			$data = json_decode($response, true);
			echo '<h1>Resposta da API</h1>';
			echo '<pre>';
			$pb = $data['publications'][0];
			if (isset($pb['authorsString']))
				{

					$autores = $pb['authorsString'];
					$autores = str_replace('(Autor)', '', $autores);
					$autores = str_replace(' ,  ', ', ', $autores);
					$autores = str_replace('  ', ' ', $autores);
					$RSP['authors'] = $autores;

					if (isset($pb['fullTitle'])) {
						if (isset($pb['fullTitle']['pt_BR'])) {
							$titulo = $pb['fullTitle']['pt_BR'];
						} else {
							if (isset($pb['fullTitle']['en'])) {
								$titulo = $pb['fullTitle']['en'];
							} else {
								$titulo = $pb['fullTitle']['es'];
							}
						}
					}
					$RSP['title'] = $titulo;
				}
		}
		curl_close($ch);
		return $RSP;
	}
}
