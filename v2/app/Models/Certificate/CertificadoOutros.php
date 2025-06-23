<?php

namespace App\Models\Certificate;

use CodeIgniter\Model;
use TCPDF;

class CertificadoOutros extends Model
{
	protected $table            = 'certificado_outros';
	protected $primaryKey       = 'id_c';
	protected $useAutoIncrement = true;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		'id_c',
		'c_nome',
		'c_email',
		'c_certificado',
		'c_data',
		'e_evento'
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

	function enviarEmailTodos($tp=1)
	{
		$dt = $this
			->where('c_certificado', $tp)
			->where('e_email', '0')
			->findAll();
		if ($dt == []) {
			return '<div class="alert alert-danger">Certificados não encontrados</div>';
		}
		foreach ($dt as $d) {
			$this->enviarEmail($d['id_c'], $d['e_evento']);
		}
	}

	function enviarEmail($id, $ev)
	{
		$dt = $this
			->join('event', 'id_e = e_evento')
			->join('certificado_tipo', 'c_certificado = id_ct')
			->find($id);
		if ($dt == []) {
			return '<div class="alert alert-danger">Certificado não encontrado</div>';
		}
		$dir = '';
		$file = $dir . 'certificado_'.($dt['id_c']) . '.pdf';

		$this->makeCertificate($id, $ev, $file);

		pre($dt);
	}


	function makeCertificate($id, $ev, $fileName = 'Certificado.pdf')
	{
		$dir = 'cert';
		for ($i = 0; $i < 10; $i++) {
			if (file_exists($dir)) break;
			$dir = '../' . $dir;
		}

		$certPem   = $dir . '/cert_luciana.pem';
		$keyPem    = $dir . '/key_luciana.pem';
		$keyPass   = '';

		$public = __DIR__;
		$loop = 0;
		while (($public != '') and ($loop < 10)) { {
				$loop++;
				$d = explode('/', $public);
				$public = '';
				for ($i = 0; $i < count($d) - 1; $i++) {
					$public .= $d[$i];
					if ($i < count($d) - 2) {
						$public .= '/';
					}
					if (is_dir($public . 'public')) {
						$public .= 'public/';
						break;
					}
				}
			}
		}
		if (!file_exists($certPem)) {
			echo 'Certificado não encontrado: ' . $certPem;
			exit;
		}

		$dt = $this
			->join('event', 'id_e = e_evento')
			->join('certificado_tipo', 'c_certificado = id_ct')
			->find($id);
		if ($dt == []) {
			return '<div class="alert alert-danger">Certificado não encontrado</div>';
		}

		$sealImage = $public . 'assets/cert/selo.png';
		if (!file_exists($sealImage)) {
			echo 'Imagem do selo não encontrada: ' . $sealImage;
			exit;
		}


		$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetMargins(0, 0, 0); // remove margens
		$pdf->SetAutoPageBreak(false, 0); // desativa quebra automática
		$pdf->AddPage();

		// Obtem o tamanho da página dinamicamente
		$pageWidth = $pdf->getPageWidth();
		$pageHeight = $pdf->getPageHeight();

		// Define imagem de fundo
		$logoImage = $public . 'assets/cert/background_2.jpg';
		if (!file_exists($logoImage)) {
			echo 'Imagem de fundo não encontrada: ' . $logoImage;
			exit;
		}
		$pdf->Image($logoImage, 0, 0, $pageWidth, $pageHeight, '', '', '', false, 300, '', false, false, 0);

		// Conteúdo
		$pdf->SetXY(10, 50);
		$pdf->SetFont('helvetica', '', 28);
		$pdf->Write(0, 'Certificado', '', 0, 'C', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 16);
		$pdf->Ln(10);

		$autores = $dt['c_nome'];
		if (strpos($autores, ',') !== false) {
			$autores = str_replace(' ,', ',', $autores);
		}

		$text = $dt['ct_texto'];
		$text = str_replace('[nome]', $autores, $text);
		$text = str_replace('[Evento]', $dt['e_name'], $text);
		$pdf->writeHTMLCell(260, 120, '20', '75', $text, 0, 1, false, true, 'J', true);

		// Assinatura digital 1
		$info = [
			'Name'        => 'Luciana Gracioso',
			'Location'    => 'Canela, RS',
			'Reason'      => 'Apresentação do trabalho',
			'ContactInfo' => 'Presidente da Comissão Científica',
		];
		$pdf->setSignature(
			'file://' . realpath($certPem),
			'file://' . realpath($keyPem),
			$keyPass,
			'',
			2,
			$info
		);

		// Imagens de assinatura e selo
		$assImage = $public . 'assets/cert/ass_luciana_gracioso.jpg';
		if (!file_exists($assImage)) {
			echo 'Imagem de assinatura não encontrada: ' . $assImage;
			exit;
		}
		$pdf->Image($assImage, 160, 155, 50, 0); // ajustado Y para caber bem na página

		$pdf->Image($sealImage, 150, 170, 30, 15, 'PNG');

		// Campo de assinatura visível
		$signX = 180;
		$signY = 170;
		$signW = 60;
		$signH = 15;
		$pdf->SetFont('helvetica', '', 8);
		$pdf->SetXY($signX + 1, $signY + 1);
		$emissao = date('d/m/Y H:i:s');

		$pdf->MultiCell(
			$signW - 2,   // largura interna
			0,
			$info['Name'] . "\n" .
				$info['ContactInfo'] . "\n",
			0,            // sem borda no texto
			'L',          // alinhamento à esquerda
			false,
			1
		);

		$pdf->setSignatureAppearance($signX, $signY, $signW, $signH);


		// Assinatura digital 2
		$info = [
			'Name'        => 'Rita do Carmo Laipelt',
			'Location'    => 'Canela, RS',
			'Reason'      => 'Apresentação do trabalho',
			'ContactInfo' => 'Presidente da ISKO Brasil',
		];
		$pdf->setSignature(
			'file://' . realpath($certPem),
			'file://' . realpath($keyPem),
			$keyPass,
			'',
			2,
			$info
		);

		// Imagens de assinatura e selo
		$assImage = $public . 'assets/cert/ass_rita_laipelt.jpg';
		if (!file_exists($assImage)) {
			echo 'Imagem de assinatura não encontrada: ' . $assImage;
			exit;
		}
		$pdf->Image($assImage, 80, 155, 50, 0); // ajustado Y para caber bem na página

		$pdf->Image($sealImage, 70, 170, 30, 15, 'PNG');

		// Campo de assinatura visível
		$signX = 100;
		$signY = 170;
		$signW = 60;
		$signH = 15;
		$pdf->SetFont('helvetica', '', 8);
		$pdf->SetXY($signX + 1, $signY + 1);
		$emissao = date('d/m/Y H:i:s');

		$pdf->MultiCell(
			$signW - 2,   // largura interna
			0,
			$info['Name'] . "\n" .
				$info['ContactInfo'] . "\n",
			0,            // sem borda no texto
			'L',          // alinhamento à esquerda
			false,
			1
		);

		$pdf->setSignatureAppearance($signX, $signY, $signW, $signH);
		if ('Certificado.pdf' != $fileName) {
			$pdf->Output($fileName,'F');
		} else {
			echo "OK";
			exit;
			return $pdf->Output($fileName, 'I');
		}
	}

	function searchName($name, $ev = 2)
	{
		$sx = '';
		$k = explode(' ', $name);
		foreach ($k as $v) {
			$v = trim($v);
			if ($v != '') {
				$this->like('c_nome', $v);
			}
		}
		$this->join('certificado_tipo', 'id_ct = c_certificado');
		$dt = $this->findAll(50);
		//pre($dt);

		foreach ($dt as $d) {
			$sx .= '<div class="card mb-3">';
			$sx .= '<div class="card-body">';
			$sx .= '<h5 class="card-title">' . $d['ct_titulo'] . '</h5>';
			$sx .= '<p class="card-text">Autores: ' . $d['c_nome'] . '</p>';
			$sx .= '<a href="' . base_url('certificateO/' . $d['id_c']) . '" class="btn btn-primary">Ver Certificado</a>';

			$sx .= '</div>';
			$sx .= '</div>';
		}
		return $sx;
	}
}
