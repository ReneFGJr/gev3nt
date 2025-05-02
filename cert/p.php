<?php
require __DIR__ . '/../vendor/autoload.php';

use TCPDF;

// Caminhos dos seus arquivos de chave/certificado e selo
$certPem   = __DIR__ . '/cert.pem';
$keyPem    = __DIR__ . '/key.pem';
$keyPass   = '';               // vazio se sua chave não tiver senha
$sealImage = __DIR__ . '/selo.png';
$outputPdf = __DIR__ . '/x.pdf';

// 1) Cria instância TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// 2) PÁGINA 1: Declaração de Participação
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 14);
$pdf->Ln(15);
$text =
	"DECLARAÇÃO DE PARTICIPAÇÃO\n\n" .
	"Eu, _____________________________________________, portador(a) do documento nº ____________, " .
	"declaro que participei efetivamente do evento/atividade descrita a seguir:\n\n" .
	"Título do Evento: __________________________________________\n" .
	"Data do Evento: __/__/____\n\n" .
	"Porto Alegre, " . date('d/m/Y');
$pdf->writeHTMLCell(0, 0, '', '', $text, 0, 1, false, true, 'J', true);

// 3) ASSINATURA DIGITAL (campo visível na página 1)
$emissao = date('d/m/Y H:i:s');
$info = [
	'Name'        => 'Rene Faustino Gabriel Junior',
	'Location'    => 'Porto Alegre, RS',
	'Reason'      => 'Declaração de participação',
	'ContactInfo' => 'Emissão: ' . $emissao,
];
$pdf->setSignature(
	'file://' . realpath($certPem),
	'file://' . realpath($keyPem),
	$keyPass,
	'',
	2,
	$info
);
$XX = 120;

// Insere selo no canto inferior direito da página 1
$pdf->Image($sealImage, $XX, 245, 30, 15, 'PNG');

// 1) Defina posição e tamanho do campo de assinatura
$signX = $XX+28;    // X em mm
$signY = 245;   // Y em mm
$signW = 60;    // largura em mm
$signH = 20;    // altura maior para caber o texto

// 3) Imprima o texto do $info dentro desse retângulo
$pdf->SetFont('helvetica', '', 8);
$pdf->SetXY($signX + 1, $signY + 1);
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

// Define a posição do campo de assinatura na página 1 (após o selo)
$signX -= 30;
$signW += 25;
$signH -= 4;

$pdf->setSignatureAppearance($signX, $signY, $signW, $signH);


// 4) PÁGINA 2: Conteúdo Simulado
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);
$html = '
<h1>Conteúdo do Documento</h1>
<p>Exemplo de segunda página gerada do zero, sem selo nem campo de assinatura visível.</p>
';
$pdf->writeHTML($html, true, false, true, false, '');

// 5) Gera o PDF final
$pdf->Output($outputPdf, 'F');

echo "PDF criado com assinatura visível na página 1 em: {$outputPdf}\n";
