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
		'doc_id',
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

	function accepts($id)
		{
			$Publication = new \App\Models\OJS\Publications();

			$da = $Publication
				->join('articles_doc', 'doc_tipo = w_id', 'left')
				->where('w_evento', $id)
				->where('w_status', 1)
				->orderBy('w_id', 'desc')
				->findAll();

			$sx = '';
			$sx .= '<table border="1" cellpadding="5" cellspacing="0" class="table table-striped table-bordered full">';

			foreach ($da as $idx => $line) {
				$link = '<a href="' . base_url('admin/work/' . $line['id_w']) . '" class="link">';
				$linka = '</a>';
				$sx .= '<tr>';
				$sx .= '<td>' . $link.$line['titulo'] .$linka. '</td>';
				$sx .= '</tr>';
				$sx .= '<tr>';
				$sx.= '<td>';
				$sx .= $this->show($line['w_id'], $id);
				$sx .= '</td>';
				$sx .= '</tr>';
			}
			$sx .= '</table>';
			return $sx;
	}

	function email_enviar($id)
		{
			$id = get('doc');
			$docID = get('id');
			$ev = get('ev');
			$dt = $this
			->join('articles_doc_type', 'adt_codigo = doc_tipo','left')
			->join('articles', 'id_w = doc_id','left')
			->where('id_doc', $id)->first();
			$dt['n_mail'] = $dt['email_autor1'];
			$dt['n_nome'] = $dt['nome_autor1'].' '.$dt['sobrenome_autor1'];
			$dt['e_name'] = 'VIII Isko Brasil';

			$dt['e_email'] = 'iskobrazil@gmail.com';
			$dt['cb_created'] = date('Y-m-d H:i:s');
			$dt['autores'] = $dt['w_autores'];

			/********* Files */
			$files = [$dt['doc_url']];

			$Message = new \App\Models\Messages\Index();
			$txt = $Message->messages(4, $dt);

			$this->set(['doc_status'=> 2])->where('id_doc', $dt['id_doc'])->update();

			$Email = new \App\Models\IO\EmailX();
			$email = $dt['email_autor1'];
			$rsp = $Email->sendEmail($email, '['.$dt['e_name'].'] Aceite de Trabalho - #ID'.$id, $txt,$files);

			$Publications_log = new \App\Models\OJS\Publications_log();
			$Publications_log->log_insert($dt['doc_id'], 'Carta de aceite enviada os autores');



		return "Enviado e-mail com sucesso para " . $dt['n_nome'] . " - " . $dt['n_mail'];
		}

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

		$idW = get("id");
		$doc = $ArticleDocType->where('id_adt', $id_doc)->first();
		$txt = $doc['adt_text'];
		foreach ($dados as $idx => $vlr) {
			$txt = str_replace('$' . $idx, $vlr, $txt);
		}
		$dir = $this->getDir();
		if (!is_dir($dir)) {
			mkdir($dir, 0777, true);
		}
		$file = $dir.'/aceite_'. str_pad($idW, 7, '0', STR_PAD_LEFT) . '.pdf';
		$WordAproved->emitir($txt,1,$file);

		$Publications_log = new \App\Models\OJS\Publications_log();
		$Publications_log->log_insert($idW, 'Emitido certificado de aceite: ' . $doc['adt_nome'] . ' - ' . $file);

		$dt = [];
		$dt['doc_id'] = $idW;
		$dt['doc_tipo'] = 'ACEIT';
		$dt['doc_url'] = $file;
		$dt['doc_status'] = 1;
		$this->set($dt)->insert();

		return "Certificado emitido com sucesso ";

	}

	function getDir()
	{
		$pre = $_SERVER['DOCUMENT_ROOT'];
		if ($pre == '/home2/iskoor95/public_html')
			{
				$pre = '/home2/iskoor95/inscricoes/uploads/';
				return $pre;
			}

		if (is_dir($pre)) {
			return $pre.'/';
		}
		echo "Erro de diretorio: " . $pre;
		exit;
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
			->join('articles_doc', 'adt_codigo = doc_tipo AND `doc_id` = '.$id,'left')
			->findAll();

		$sx = $this->showTable($da, $id, $ev);
		return $sx;
	}

		function showTable($da, $id, $ev)
	{
		$sx = '';
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
					$status = 'Emitido';
					$act = '<a href="' . base_url('admin/docs_email/?doc=' . $line['id_doc'] . '&id=' . $id . '&ev=' . $ev) . '" class="btn btn-outline-primary">Enviar e-mail</a>';
					$act .= '<a href="' . base_url('downloadDoc/?doc=' . $line['id_doc'] . '&id=' . $id . '&ev=' . $ev) . '" class="btn btn-outline-primary ms-2">Ver documento</a>';
					break;
				case '2':
					$status = 'Comunicado autor';
					$act .= '<a href="' . base_url('downloadDoc/?doc=' . $line['id_doc'] . '&id=' . $id . '&ev=' . $ev) . '" class="btn btn-outline-primary ms-2">Ver documento</a>';
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
