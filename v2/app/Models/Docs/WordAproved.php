<?php

namespace App\Models\Docs;

use CodeIgniter\Model;
use TCPDF;

class WordAproved extends Model
{
    protected $table            = 'works';
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

	/*
	# 1) Extrai a chave privada, protegida por senha
	openssl pkcs12 -in cert_govbr.p12 -nocerts -out key_encrypted.pem
	*/

	public function sample()
	{
			// 1) Carrega dados (opcional)
			// $model = new \App\Models\Docs\WordAproved();
			// $data  = $model->find($id);

			// 2) Paths para os PEMs
			$certPath = WRITEPATH . 'certs/cert.pem';
			$keyPath  = WRITEPATH . 'certs/key.pem';
			$keyPass  = ''; // chave sem criptografia

			// 3) Verifique leitura da chave (depuração opcional)
			$keyContents = file_get_contents($keyPath);
			if ($keyContents === false || !openssl_pkey_get_private($keyContents, $keyPass)) {
				throw new \RuntimeException('Não foi possível carregar a chave privada.');
			}

			// 4) Instancia o TCPDF
			$pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator('Seu Sistema');
			$pdf->SetAuthor('Seu Nome');
			$pdf->SetTitle('Documento Assinado');
			$pdf->SetSubject('Assinatura Gov.br');

			$pdf->SetMargins(20, 20, 20);
			$pdf->SetAutoPageBreak(true, 20);
			$pdf->AddPage();

			// 5) Conteúdo do PDF
			$html = '<h1>PDF Assinado</h1><p>Conteúdo de exemplo...</p>';
			$pdf->writeHTML($html, true, false, true, false, '');

			// 6) Informações da assinatura
			$info = [
				'Name'        => 'Rene Faustino Gabriel Junior',
				'Location'    => 'Porto Alegre, RS',
				'Reason'      => 'Assinatura Digital Gov.br',
				'ContactInfo' => 'seu.email@exemplo.com',
			];

			// 7) Configura a assinatura usando os PEMs
			$pdf->setSignature(
				$certPath,   // certificado público
				$keyPath,    // chave privada
				$keyPass,    // senha (vazia aqui)
				'',
				2,           // X.509
				$info
			);

			// 8) Placeholder visual da assinatura (opcional)
			$x = 15;
			$y = 240;
			$w = 50;
			$h = 30;
			$pdf->addEmptySignatureAppearance($x, $y, $w, $h);

			// 9) Retorna o PDF
			$output = $pdf->Output('', 'S');
		}

}
