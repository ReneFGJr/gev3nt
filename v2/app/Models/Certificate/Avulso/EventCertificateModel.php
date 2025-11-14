<?php

namespace App\Models\Certificate\Avulso;

use CodeIgniter\Model;
use TCPDF;

class EventCertificateModel extends Model
{

    protected $DBGroup = 'isko';
    protected $table            = 'event_certificate';
    protected $primaryKey       = 'id_ec';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'ec_text',
        'ec_date',
        'ec_ch', /* Carga Horária */
        'ec_ass_1',
        'ec_ass_2',
        'ec_event_id'
    ];

    // Se quiser timestamps automáticos, ative:
    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';

    // Validação opcional
    protected $validationRules = [
        'ec_text'      => 'permit_empty|string',
        'ec_date'      => 'permit_empty|valid_date',
        'ec_ass_1'     => 'permit_empty|integer',
        'ec_ass_2'     => 'permit_empty|integer',
        'ec_event_id'  => 'permit_empty|integer',
    ];

    function emitir($id)
    {
        $EventCertificateEmitir = new \App\Models\Certificate\Avulso\EventCertificateEmitModel();
        $data = $EventCertificateEmitir
            ->join('event_people', 'id_p = ece_person')
            ->join('event_certificate', 'ece_certificate = id_ec')
            ->join('event', 'ec_event = id_e')
            ->where('id_ece', $id)
            ->first(); {
            // ================================
            // 1. Preparar dados do certificado
            // ================================
            $nome   = $data['p_name'];
            $evento = $data['e_name'];
            $dataEvento = date('d/m/Y', strtotime($data['e_date']));
            $textoModelo = $data['ec_text'];

            // Substituir variáveis do texto
            $textoFinal = str_replace(
                ['$NOME', '$EVENTO', '$DATA'],
                [$nome, $evento, $dataEvento],
                $textoModelo
            );

            // ================================
            // 2. Criar PDF
            // ================================
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

            // Remover cabeçalho/rodapé padrão
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            // Margens
            $pdf->SetMargins(20, 40, 20);

            // Fonte padrão
            $pdf->SetFont('dejavusans', '', 14);

            // Adicionar página
            $pdf->AddPage();

            // ===========================================
            // 🔥 1. Forçar imagem ocupar a página inteira
            // ===========================================
            $pdf->SetAutoPageBreak(false, 0); // sem quebra automática
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            $w = $pdf->getPageWidth();   // largura exata da página
            $h = $pdf->getPageHeight();  // altura exata da página


            // ================================
            // 3. Imagem de fundo fixa (background.jpg)
            // ================================
            $bgPath = '..\uploads\backgrounds\isko-premio.jpg';
            if (!file_exists($bgPath)) {
                echo 'File notfound - '. $bgPath .'';
                exit;
            }

            if (file_exists($bgPath)) {
                $pdf->Image(
                    $bgPath,
                    0,
                    0,
                    210,   // largura total da página A4
                    297,   // altura total da página A4
                    '',
                    '',
                    '',
                    false,
                    300,
                    '',
                    false,
                    false,
                    0
                );
            }

            // ================================
            // 4. Texto do certificado
            // ================================,
            $html = '<div style="height:700px; width: 100%;"></div>';
            $html .= '<br/>';
            
            $html .= '<style>p { line-height: 1.5; text-align: justify; font-size: 18px; }</style>';
            $html .= "$textoFinal";

            // ================================
            // 5. Escrever no PDF
            // ================================
            $pdf->writeHTML($html, true, false, true, false, '');

            // ================================
            // 7. Salvar arquivo
            // ================================
            $fileName = 'certificado_' . $data['id_ece'] . '.pdf';
            $dir = WRITEPATH . 'certificados/';

            // Verifica diretório
            if (!is_dir($dir)) {
                mkdir($dir, 0775, true);
            }

            $filePath = $dir . $fileName;

            // Mostrar na tela
            $pdf->Output('certificado.pdf', 'I');
            exit;

            return $filePath;
        }
    }
}
