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
            ->where('id_i', $id)
            ->first();

        if (!$cert) {
            return redirect()->to('/')->with('error', 'Certificado não encontrado.');
        }

        // Renderizar view do certificado em HTML
        $html = view('layout/certificado_pdf', ['cert' => $cert]);

        // Gerar PDF com TCPDF
        require_once(APPPATH.'ThirdParty/tcpdf/tcpdf.php');
        $pdf = new \TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Gev3nt');
        $pdf->SetAuthor('Gev3nt');
        $pdf->SetTitle('Certificado');
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(TRUE, 10);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
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
