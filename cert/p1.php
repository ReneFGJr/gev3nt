<?php
require __DIR__ . '/../vendor/autoload.php';

// Instancia a classe TCPDF diretamente (no global namespace)
$pdf = new \TCPDF();

// Caminhos — ajuste conforme sua estrutura de pastas
//$inputPdf   = __DIR__ . '/input.pdf';           // coloque aqui o seu input.pdf
//$outputPdf  = __DIR__ . '/output-signed.pdf';   // onde gerar o PDF assinado
//$certPem    = __DIR__ . '/cert.pem';
//$keyPem     = __DIR__ . '/key.pem';
//$keyPass    = '';  // vazio se sua chave não tiver senha

// Caminhos dos arquivos
$inputPdf   = __DIR__ . '/input.pdf';
$outputPdf  = __DIR__ . '/output-signed.pdf';
$certPem    = __DIR__ . '/cert.pem';
$keyPem     = __DIR__ . '/key.pem';
$keyPass    = '';             // se key.pem não tiver senha
$sealImage  = __DIR__ . '/selo.png';  // seu selo gráfico

// 1) Instancia FPDI (baseado em TCPDF)
$pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// 2) Importa páginas do PDF de entrada
$pageCount = $pdf->setSourceFile($inputPdf);
for ($n = 1; $n <= $pageCount; $n++) {
    $tpl = $pdf->importPage($n);
    $size = $pdf->getTemplateSize($tpl);
    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
    $pdf->useTemplate($tpl);

    // 3) Insere o selo na última página (ou condicionalmente em qualquer página)
    if ($n === $pageCount) {
        // Parâmetros: arquivo, X (mm), Y (mm), largura (mm), altura (mm)
        // Ajuste as coordenadas conforme necessidade:
        $x      = 150;
        $y      = 250;
        $w      = 40;
        $h      = 40;
        $pdf->Image($sealImage, $x, $y, $w, $h, 'PNG');
    }
}

// 4) Dados da assinatura
$info = [
    'Name'        => 'Rene F. G. Junior',
    'Location'    => 'Porto Alegre, RS',
    'Reason'      => 'Assinatura do documento',
    'ContactInfo' => 'rene.gabriel@ufrgs.br',
];

// 5) Configura a assinatura (depois de inserir selo)
$pdf->setSignature(
    'file://' . realpath($certPem),
    'file://' . realpath($keyPem),
    $keyPass,
    '',
    2,
    $info
);

// 6) Campo visível da assinatura (opcional)
$pdf->setSignatureAppearance(15, 260, 60, 15);

// 7) Gera o PDF final
$pdf->Output($outputPdf, 'F');

echo "PDF com selo e assinatura gerado em: {$outputPdf}\n";