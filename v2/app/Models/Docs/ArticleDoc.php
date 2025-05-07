<?php

namespace App\Models\Docs;

use CodeIgniter\Model;
use TCPDF;

class ArticleDoc extends Model
{
    protected $table            = 'articles_doc';
    protected $primaryKey       = 'id_doc';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
		'id_doc',
		'doc_tipo',
		'doc_url',
		'doc_status',
		'doc_created',
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

	function emitir($id)
	{
		$ArticleDocType = new \App\Models\Docs\ArticleDocType();
		$WordAproved = new \App\Models\Docs\WordAproved();
		$Work = new \App\Models\OJS\Publications();

		$id_doc = get("doc");

		$dados = $Work->where('id_w', $id)->first();
		if ($dados == []) {
			echo "ID: " . $id;
			echo "Article not found";
			exit;
		}

		$doc = $ArticleDocType->where('id_adt', $id_doc)->first();
		$txt = $doc['adt_text'];
		foreach ($dados as $idx => $vlr) {
			$txt = str_replace('$' . $idx, $vlr, $txt);
		}
		$WordAproved->emitir($txt,1);
	}

	function show($id,$ev)
	{
		$Work = new \App\Models\OJS\Publications();
		$dados = $Work->where('w_id', $id)->first();
		if ($dados == []) {
			echo "ID: " . $id;
			echo "Article not found";
			exit;
		}
		$id = $dados['id_w'];

		$ArticleDocType = new \App\Models\Docs\ArticleDocType();
		$da = $ArticleDocType
			->join('articles_doc', 'adt_codigo = doc_tipo','left')
			->where('doc_id', $id)
			->Orwhere('doc_id', null)
			->findAll();
		$dd = [];
		$dd['docs'] = $da;
		$sx = '<table border="1" cellpadding="5" cellspacing="0" class="table table-striped table-bordered full">';
		$sx .= '<tr>';
		$sx .= '<th>Tipo</th>';
		$sx .= '<th>Arquivo</th>';
		$sx .= '<th>Status</th>';
		$sx .= '</tr>';
		foreach ($da as $idx => $line) {
			$status = $line['doc_status'];
			$act = '';
			switch($status) {
				case '0':
					$status = 'Aguardando';
					break;
				case '1':
					$status = 'Aprovado';
					break;
				case '2':
					$status = 'Reprovado';
					break;
				case '3':
					$status = 'Aguardando revisão';
					break;
				default:
					$status = 'Não emitido';
					$act = '<a href="'.base_url('admin/docs_emitir/?doc=' . $line['id_adt'].'&id='.$id.'&ev='.$ev) . '" class="btn btn-outline-primary">Emitir</a>';
			}
			$sx .= '<tr>';
			$sx .= '<td>' . $line['adt_nome'] . '</td>';
			$sx .= '<td>'.$act.'</td>';
			$sx .= '<td>' . $status . '</td>';
			$sx .= '</tr>';
		}
		$sx .= '</table>';
		return $sx;
	}

	/*
	# 1) Extrai a chave privada, protegida por senha
	openssl pkcs12 -in cert_govbr.p12 -nocerts -out key_encrypted.pem
	*/



}
