<?php

namespace App\Models\Docs;

use CodeIgniter\Model;
use TCPDF;

class ArticleDocType extends Model
{
    protected $table            = 'articles_doc_type';
    protected $primaryKey       = 'id_adt';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
		'id_adt',
		'adt_nome',
		'adt_text',
		'adt_codigo',
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

		$dt = $this
			->join('articles_doc_type', 'adt_codigo = doc_tipo','right')
			->where('doc_id', $id)->findAll();
		pre($dt);


	}

	/*
	# 1) Extrai a chave privada, protegida por senha
	openssl pkcs12 -in cert_govbr.p12 -nocerts -out key_encrypted.pem
	*/



}
