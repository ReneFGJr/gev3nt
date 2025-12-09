<?php

namespace App\Models\Docs;

use CodeIgniter\Model;
use TCPDF;

class PaymentReceipt extends Model
{
	protected $table            = 'event_inscritos';
	protected $primaryKey       = 'id_ein';
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

	public function emitir($txt,$ass=0, $outputPdf='')
	{
		// 1) Carrega dados (opcional)
		// $model = new \App\Models\Docs\WordAproved();
		// $data  = $model->find($id);

		// 2) Paths para os PEMs
		$dir =  'cert';
		for ($i=0; $i < 10; $i++) {
			$file = $dir . '/cert.pem';
			if (file_exists($dir)) {
				break;
			}
			$dir = '../' . $dir;
		}
		$certPem   = $dir . '/cert.pem';
		$keyPem    = $dir . '/key.pem';
		$keyPass   = '';               // vazio se sua chave não tiver senha
		$sealImage = __DIR__ . '/selo.png';


		// 3) Verifique leitura da chave (depuração opcional)
		if (!file_exists($certPem)) {
			echo 'Certificado não encontrado. Verifique o caminho.';
			echo '<hr>'.$certPem;
			exit;
		}
		$keyContents = file_get_contents($keyPem);
		if ($keyContents === false || !openssl_pkey_get_private($keyContents, $keyPass)) {
			throw new \RuntimeException('Não foi possível carregar a chave privada.');
		}

		// 4) Instancia o TCPDF
		$pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator('ISKO Brasil');
		$pdf->SetAuthor('ISKO Brasil');
		$pdf->SetTitle('Declaração de aprovação de trabalho');
		$pdf->SetSubject('ISKO Brasil');

		$pdf->SetMargins(20, 20, 20);
		$pdf->SetAutoPageBreak(true, 20);
		$pdf->AddPage();

		$dir = '';
		if ($_SERVER['SERVER_NAME'] == 'isko.org.br') {
			$dir = '/home2/iskoor95/inscricoes/public/';
		}

		$logoImage = $dir.'assets/logos/logo_isko_brasil.png';
		if (!file_exists($logoImage)) {
			echo 'Logo não encontrado. Verifique o caminho.';
			echo '<hr>'.$logoImage;
			exit;

		}

		$pdf->image($logoImage, 35, 15, 150, 0, 'PNG', '', '', true, 300, '', false, false, 1, false, false, false);
		$pdf->SetX(15);
		$pdf->setY(70);

		// 5) Conteúdo do PDF
		$html = $txt;
		$pdf->writeHTML($html, true, false, true, false, '');

		$XX = 120;
		$logoImage = $dir. 'assets/cert/ass_rene_gabriel.jpg';
		$pdf->image($logoImage, $XX+20, 224, 50, 0);

		$logoImage = $dir .'assets/cert/selo.png';
		// Insere selo no canto inferior direito da página 1
		$pdf->Image($logoImage,$XX, 245, 30, 15, 'PNG');

		// 1) Defina posição e tamanho do campo de assinatura
		$signX = $XX+28;    // X em mm
		$signY = 245;   // Y em mm
		$signW = 60;    // largura em mm
		$signH = 20;    // altura maior para caber o texto

		// 3) Imprima o texto do $info dentro desse retângulo
		$pdf->SetFont('helvetica', '', 8);
		$pdf->SetXY($signX + 1, $signY + 1);
		$emissao = date('d/m/Y H:i:s');

		$info = [
			'Name'        => 'Rene Faustino Gabriel Junior',
			'Location'    => 'Canela, RS',
			'Reason'      => 'Recibo - Tesoureiro',
			'ContactInfo' => 'Emissão: ' . $emissao,
		];
		$pdf->MultiCell(
			$signW - 2,   // largura interna
			0,
			"Name: " . $info['Name'] . "\n" .
				"Location: " . $info['Location'] . "\n" .
				"Reason: " . $info['Reason'] . "\n" .
				"Contact: " . $info['ContactInfo'],
			0,            // sem borda no texto
			'L',          // alinhamento à esquerda
			false,
			1
		);


		// 6) Informações da assinatura

		$info = [
			'Name'        => 'Rene Faustino Gabriel Junior',
			'Location'    => 'Porto Alegre, RS',
			'Reason'      => 'Declaração de participação',
			'ContactInfo' => 'Emissão: ' . $emissao,
		];

		// 7) Configura a assinatura usando os PEMs
		$pdf->setSignature(
			'file://' . realpath($certPem),
			'file://' . realpath($keyPem),
			$keyPass,
			'',
			2,
			$info
		);

		// 8) Placeholder visual da assinatura (opcional)
		$signX = $XX ;    // X em mm
		$signY = 245;   // Y em mm
		$signW = 60 + 28;    // largura em mm
		$signH = 20;

		$pdf->addEmptySignatureAppearance($signX, $signY, $signW, $signH);

		// 9) Retorna o PDF
		#$output = $pdf->Output();
		$output = $pdf->Output($outputPdf, 'F');
		//$output = $pdf->Output('e:\lixo\xxxx.pdf', 'F');
		return true;
	}

	public function sample()
	{
			// 1) Carrega dados (opcional)
			// $model = new \App\Models\Docs\WordAproved();
			// $data  = $model->find($id);

			// 2) Paths para os PEMs
			$certPem   = __DIR__ . '/cert.pem';
			$keyPem    = __DIR__ . '/key.pem';
			$keyPass   = '';               // vazio se sua chave não tiver senha
			$sealImage = __DIR__ . '/selo.png';
			$outputPdf = __DIR__ . '/x.pdf';

			echo $certPem;
			exit;

			// 3) Verifique leitura da chave (depuração opcional)
			$keyContents = file_get_contents($keyPem);
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
			$emissao = date('d/m/Y H:i:s');
			$info = [
				'Name'        => 'Rene Faustino Gabriel Junior',
				'Location'    => 'Porto Alegre, RS',
				'Reason'      => 'Declaração de participação',
				'ContactInfo' => 'Emissão: ' . $emissao,
			];

			// 7) Configura a assinatura usando os PEMs
			$pdf->setSignature(
				'file://' . realpath($certPem),
				'file://' . realpath($keyPem),
				$keyPass,
				'',
				2,
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
