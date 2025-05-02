<?php
require __DIR__ . '/../vendor/autoload.php';

use TCPDF;

// Caminhos dos seus arquivos de chave/certificado e selo
$certPem   = __DIR__ . '/cert.pem';
$keyPem    = __DIR__ . '/key.pem';
$keyPass   = '';               // vazio se sua chave não tiver senha
$sealImage = __DIR__ . '/selo.png';
$outputPdf = __DIR__ . '/declaracao-participacao.pdf';

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
$info = [
	'Name'        => 'Rene F. G. Junior',
	'Location'    => 'Porto Alegre, RS',
	'Reason'      => 'Declaração de participação',
	'ContactInfo' => 'rene.gabriel@ufrgs.br',
];
$pdf->setSignature(
	'file://' . realpath($certPem),
	'file://' . realpath($keyPem),
	$keyPass,
	'',
	2,
	$info
);

// Insere selo no canto inferior direito da página 1
$pdf->Image($sealImage, 100, 180, 50, 50, 'PNG');

// Define a posição do campo de assinatura na página 1 (após o selo)
$signX = 100;    // X em mm
$signY = 180;   // Y em mm (ajuste conforme seu layout)
$signW = 60;    // largura do campo
$signH = 15;    // altura do campo
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
