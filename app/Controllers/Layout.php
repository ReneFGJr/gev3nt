<?php
namespace App\Controllers;

helper('url');

class Layout extends BaseController
    {
    public function imprimir($id = null)
    {
        if (!$id) {
            return redirect()->to('/')->with('error', 'Certificado não encontrado.');
        }

        $certModel = new \App\Models\EventsInscritosModel();
        $cert = $certModel
            ->join('events', 'events_inscritos.i_evento = events.id_e')
            ->join('events_names', 'i_user = id_n')
            ->join('event', 'events.e_event = event.id_e','left')
            ->where('id_i', $id)
            ->first();

        if (!$cert) {
            return redirect()->to('/')->with('error', 'Certificado não encontrado.');
        }

        $dateOut = trim((string) ($cert['i_date_out'] ?? ''));
        if ($dateOut === '' || str_starts_with($dateOut, '0000-00-00')) {
            $certModel->update($id, [
                'i_date_out' => date('Y-m-d'),
                'i_status' => 1,
            ]);

            $cert['i_date_out'] = date('Y-m-d');
            $cert['i_status'] = 1;
        }

        $text = $cert['e_certificado_texto'];
        $text = str_replace('$nome', $cert['n_nome'], $text);
        $text = str_replace('{evento}', $cert['e_name'], $text);
        $text = str_replace('$titulo', '<b>'.$cert['i_titulo_trabalho'].'</b>', $text);
        $text = str_replace('$autores', '<i>'.$cert['i_autores'].'</i>', $text);
        $text = str_replace('$evento', $cert['e_name'], $text);
        $text = str_replace('$data', date('d/m/Y', strtotime($cert['e_data'])), $text);
        $text = str_replace('$cidade', $cert['e_cidade'], $text);
        $text = str_replace('$ch', $cert['i_carga_horaria'], $text);

        // Gerar QR code para validação
        $certUrl = base_url('certificados/imprimir/' . $id);
        $qrDir = WRITEPATH . 'qrcodes/';
        if (!is_dir($qrDir)) mkdir($qrDir, 0777, true);
        $qrcodePath = $qrDir . 'cert_' . $id . '.png';
        if (!file_exists($qrcodePath)) {
            include_once(APPPATH . 'ThirdParty/phpqrcode/qrlib.php');
            \QRcode::png($certUrl, $qrcodePath, QR_ECLEVEL_L, 5);
        }



        // Gerar PDF com TCPDF
        require_once(APPPATH.'ThirdParty/tcpdf/tcpdf.php');
        $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Gev3nt');
        $pdf->SetAuthor('Gev3nt');
        $pdf->SetTitle('Certificado');
        $pdf->SetMargins(0, 0, 0, 0);
        $pdf->SetAutoPageBreak(TRUE, 0);
        $pdf->AddPage();

        // Adicionar imagem de background se existir

        if (!empty($cert['e_background'])) {
            $imgPath = $cert['e_background'];
            if (strpos($imgPath, 'http') === 0) {
                // Se for URL absoluta
                $pdf->Image($imgPath, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
            } else {
                // Caminho relativo ao public
                $publicPath = FCPATH . ltrim($imgPath, '/');
                if (file_exists($publicPath)) {
                    $pdf->Image($publicPath, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
                } else {
                    // Mostra erro e caminho completo
                    echo '<pre style="color:red;">Erro: Imagem de background não encontrada! Caminho: ' . $publicPath . '</pre>';
                    exit;
                }
            }
        }

        $pdf->setXY(10, 10);
        $header = '<h1 style="color:#000000; font-size:18px; font-weight: bold; text-align: center;">CERTIFICADO</h1>';
        $text = $header . '<p style="line-height:1.5; font-size:16px;">' . $text . '</p>';
        $text = '<table width="350" style="text-align: justify; border: 1px solid #000;"><tr><td>' . $text . '</td></tr></table>';

        $meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
        $mes = round(substr(date('m', strtotime($cert['e_data'])), 0, 2));
        $mes = $meses[$mes - 1];
        $dia = date('d', strtotime($cert['e_data']));
        $data = $cert['e_cidade'] . ' '.$dia.' de ' . $mes . ' de ' . date('Y', strtotime($cert['e_data'])).'.';
        $text .= '<br>';
        $text .= '<br>';


        $data = str_replace(date('F'), $meses[date('n') - 1], $data);
        $text .= '<table width="350" style="text-align: right; color:#000000; font-size:18px; font-weight: bold;"><tr><td>' . $data . '</td></tr></table>';

        $pdf->writeHTML($text, true, false, true, false, '');

        // Inserir QR code no lado direito do meio da página
        $pageWidth = $pdf->getPageWidth();
        $pageHeight = $pdf->getPageHeight();
        $qrSize = 40; // mm
        if (file_exists($qrcodePath)) {
            $pdf->Image($qrcodePath, 165, 190, $qrSize, $qrSize, 'PNG');
        } else {
            echo '<pre style="color:red;">Erro: QR code não encontrado! Caminho: ' . $qrcodePath . '</pre>';
            exit;
        }

        $pdf->Output('certificado_'.$id.'.pdf', 'I');
        exit;
    }

    public function contato()
    {
        return view('layout/contato');
    }

    public function index()
    {
        $certificados = [];
        if (session('usuario')) {
            $userId = session('usuario.id_n') ?? session('usuario.id');
            $certModel = new \App\Models\EventsInscritosModel();
            $certificados = $certModel->getCertificadosByUser($userId);
        }
        return view('layout/index', [
            'certificados' => $certificados
        ]);
    }
}
