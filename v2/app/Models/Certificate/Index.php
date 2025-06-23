<?php

namespace App\Models\Certificate;

use CodeIgniter\Model;
use TCPDF;

class Index extends Model
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

	function index($a2 = '', $a3 = '', $ev = 2)
	{
		$sx = '';
		switch ($a2) {
			case 'email':
				$CertificadoOutros	= new \App\Models\Certificate\CertificadoOutros();
				$sx .= $CertificadoOutros->enviarEmailTodos(1,2);
				break;
			case 'gerar':
				$sx .= $this->gerarCertificados($a3, $ev);
				break;
			default:
				$sx .= '<div class="alert alert-danger">Opção inválida - ' . $a2 . '-' . $a3 . '</div>';
				break;
		}
		return $sx;
	}

	function gerarCertificados($id = '', $ev = 2)
	{

		if ($_POST) {
			$sx = $this->gerarCertificadosPost($id, $ev);
		} else {
			return $this->gerarCertificadosForm($id, $ev);
		}

		return $sx;
	}

	function gerarCertificadosForm($id = '', $ev = 2)
	{
		$sx = '';
		$sx .= '<h3>Gerar Certificados</h3>';
		$sx .= '<form method="post" action="' . base_url('admin/certificados/gerar') . '">'.chr(10);
		$sx .= '<div class="mb-3">' . chr(10);
		$sx .= '<label for="name" class="form-label">Nomes</label>' . chr(10);
		$sx .= '<textarea
				class="form-control border border-secondary"
				id="name"
				name="name"
				rows="10"
				placeholder="Digite um nome por linha, seguido do e-mail. Ex: João Silva - joao@email.com">'.get("name").'</textarea>' . chr(10);
		$sx .= '</div>' . chr(10);
		$sx .= '<div class="mb-3">' . chr(10);
		$sx .= '<button type="submit" class="btn btn-primary">Gerar Certificado</button>' . chr(10);
		$sx .= '</form>' . chr(10);
		$sx .= '</div>' . chr(10);
		return $sx;
	}

	function gerarCertificadosPost($id, $ev)
	{
		$sx = '';
		$name = get("name");
		if ($name == '') {
			return '<div class="alert alert-danger">Informe os nomes para gerar os certificados</div>';
		}
		$names = explode("\n", $name);
		$names = array_map('trim', $names); // Remove espaços em branco
		$names = array_filter($names); // Remove linhas vazias
		$tp = 1;
		foreach ($names as $n) {
			// Verifica se o nome contém um e-mail
			$n = str_replace("\t", ';',$n);
			$n = explode(';', $n);
			if ($this->isEmail($n[1]))
				{
					$sx .= '<li>'.$this->gerarCertificadoDB($n[0], $n[1], $ev, $tp). '</li>';
				}
			}
		return $sx;
	}

	function gerarCertificadoDB($name, $email, $ev, $tp)
	{
		$data = '2025-06-25';
		$CertificadoOutros = new \App\Models\Certificate\CertificadoOutros();
		$data = [
			'c_nome' => $name,
			'c_email' => $email, // Certificado
			'c_certificado' => $tp,
			'c_data' => $data,
			'e_evento'=> $ev
		];

		$dt = $CertificadoOutros->where('c_certificado', $tp)
			->where('c_email', $email)
			->where('e_evento', $ev)
			->first();

		if ($dt == []) {
			// Verifica se o certificado já existe
			$CertificadoOutros->set($data)->insert();
			return $name . ' - ' . $email . ' - Certificado inserido com sucesso.';
		} else {
			return $name . ' - ' . $email . ' - Certificado já existe.';
		}
	}

	function isEmail($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
	}

	function makeCertificate($id, $ev)
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
		while (($public != '') and ($loop < 10)) {
			{
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

		$Article = new \App\Models\OJS\Publications();
		$dt = $Article->join('event', 'id_e = w_evento')->find($id);

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
		$logoImage = $public.'assets/cert/background_2.jpg';
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

		$autores = $dt['w_autores'];
		if (strpos($autores, ',') !== false) {
			$autores = str_replace(' ,', ',', $autores);
		}

		$text = 'Este certificado é concedido a <b>' . trim($autores) . '</b>';
		$text .= ' pela apresentação do trabalho intitulado <b>' . $dt['titulo'] . '</b>';
		$text .= ' no evento do <b>' . $dt['e_name'] . '</b>, realizado entre ' . date('d/m/Y', strtotime($dt['e_data_i'])) . ' e ' . date('d/m/Y', strtotime($dt['e_data_f'])) . '.';
		$text .= ' <br> <br> Declaro que o trabalho foi apresentado e discutido com os participantes do evento.';
		$text .= ' <br> <br> Porto Alegre, ' . date('d', strtotime($dt['e_data_f'])) . ' ' . $this->nome_mes(date('m', strtotime($dt['e_data_f']))) . ' ' . date('Y', strtotime($dt['e_data_f'])) . '.';
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
		$assImage = $public .'assets/cert/ass_luciana_gracioso.jpg';
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
		$assImage = $public .'assets/cert/ass_rita_laipelt.jpg';
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
			$info['ContactInfo'] . "\n" ,
			0,            // sem borda no texto
			'L',          // alinhamento à esquerda
			false,
			1
		);

		$pdf->setSignatureAppearance($signX, $signY, $signW, $signH);

		return $pdf->Output('certificado.pdf', 'I');
	}

	function gerar_certificado_pdf_outros($id)
		{
			$CertificadoOutros = new \App\Models\Certificate\CertificadoOutros();
			$dt = $CertificadoOutros->find($id);
			if ($dt == []) {
				return '<div class="alert alert-danger">Certificado não encontrado</div>';
			}
			$ev = $dt['e_evento'];
			$dir = 'cert';
			for ($i = 0; $i < 10; $i++) {
				if (file_exists($dir)) break;
				$dir = '../' . $dir;
			}
			$certPem   = $dir . '/cert_luciana.pem';
			$keyPem    = $dir . '/key_luciana.pem';
			$keyPass   = '';

			echo "OK";
			pre($dt);
		}

	function nome_mes($mes)
	{
		$meses = [
			'01' => 'Janeiro',
			'02' => 'Fevereiro',
			'03' => 'Março',
			'04' => 'Abril',
			'05' => 'Maio',
			'06' => 'Junho',
			'07' => 'Julho',
			'08' => 'Agosto',
			'09' => 'Setembro',
			'10' => 'Outubro',
			'11' => 'Novembro',
			'12' => 'Dezembro'
		];
		return $meses[$mes];
	}

	function searchName($name, $ev)
	{
		$Article = new \App\Models\OJS\Publications();

		$kw = get("search");
		if ($kw == '') {
			return '<div class="alert alert-danger">Informe o nome do certificado</div>';
		}
		$k = explode(' ', $kw);
		foreach ($k as $v) {
			$v = trim($v);
			if ($v != '') {
				$Article->like('w_autores', $v);
			}
		}
		$dt = $Article->findAll(50);

		$sx = '';
		foreach ($dt as $d) {
			if ($d['w_status'] != 1) {
				continue; // Skip if not a certificate
			}
			$sx .= '<div class="card mb-3">';
			$sx .= '<div class="card-body">';
			$sx .= '<h5 class="card-title">' . $d['titulo'] . '</h5>';
			$sx .= '<p class="card-text">Autores: ' . $d['w_autores'] . '</p>';
			if ($d['w_certificado'] == '1') {
				$sx .= '<a href="' . base_url('certificate/' . $d['id_w']) . '" class="btn btn-primary">Ver Certificado</a>';
			} else {
				$sx .= '<p class="card-text text-danger">Certificado não disponível</p>';
			}

			$sx .= '</div>';
			$sx .= '</div>';
		}

		return $sx;
	}
}
