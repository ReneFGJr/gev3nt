<?php

namespace App\Models\Docs;

use CodeIgniter\Model;
use TCPDF;

class UploadDoc extends Model
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

	function md5check($file)
		{
			$check = md5($file . 'download');
			return $check;
		}
	function directory()
	{
		$dir = '';
		if ($_SERVER['SERVER_NAME'] == 'isko.org.br') {
			$dir = '/home2/iskoor95/inscricoes/uploads/';
		} else {
			$dir = $_SERVER['DOCUMENT_ROOT'];
			$loop = 0;
			while ($loop < 3) {
				$dir = $dir . '../';
				$dirz = $dir . 'uploads/';
				if (is_dir($dirz)) {
					$dir = $dirz;
					break;
				}
				$loop++;
			}
		}
		return $dir;
	}

	function show($id_doc)
	{
		$sx = '';
		$dir = $this->directory();

		$id_doc = str_pad($id_doc, 8, '0', STR_PAD_LEFT);
		$files = ['doc_$$.pdf'=>"Documento comprobatório", 'payment_proof_$$.pdf'=>'Comprovante de pagamento'];

		// http://g3vent/download/doc_00000044.pdf/00000044
		foreach ($files as $file=>$label) {
			$file = str_replace('$$', $id_doc, $file);
			$path = $dir . $file;
			if (file_exists($path)) {
				$sx .= '<a href="'.base_url('download'). '?file='.$file.'&check='.$this->md5check($file).'" class="btn btn-outline-primary me-2 p-0" target="_blank"> '.$label.' </a>';
			} else {
				$sx .= $path."- File not found";
			}
		}
		return $sx;
	}



}
