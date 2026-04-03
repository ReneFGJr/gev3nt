<?php

namespace App\Controllers;

use App\Models\EventInscritosModel;
use App\Models\EventsModel;
use App\Models\UsersModel;

class Eventos extends BaseController
{
    public function index()
    {
        $eventsModel = new EventsModel();
        $hoje = date('Y-m-d');

        $eventos = $eventsModel
            ->where('e_data_f >=', $hoje)
            ->where('e_status !=', 9)
            ->orderBy('e_data_i', 'ASC')
            ->findAll();

        $inscricoesUsuario = [];
        if (session('usuario')) {
            $userId = session('usuario.id_n') ?? session('usuario.id');
            if ($userId) {
                $inscritosModel = new EventInscritosModel();
                $inscricoes = $inscritosModel
                    ->select('ein_event')
                    ->where('ein_user', (int) $userId)
                    ->findAll();

                foreach ($inscricoes as $inscricao) {
                    $inscricoesUsuario[(int) $inscricao['ein_event']] = true;
                }
            }
        }

        return view('eventos/index', [
            'eventos' => $eventos,
            'inscricoesUsuario' => $inscricoesUsuario,
        ]);
    }

    public function inscrever($id)
    {
        if (!session('usuario')) {
            return redirect()->to('/auth/registrar')->with('erro', 'Faça seu cadastro para se inscrever.');
        }

        $eventsModel = new EventsModel();
        $evento = $eventsModel->find($id);
        if (!$evento) {
            return redirect()->to('/eventos')->with('erro', 'Evento não encontrado.');
        }

        $userId = session('usuario.id_n') ?? session('usuario.id');
        if (!$userId) {
            return redirect()->to('/auth/login')->with('erro', 'Faça login para continuar.');
        }

        $inscritosModel = new EventInscritosModel();
        $inscricaoExistente = $inscritosModel
            ->where('ein_event', $id)
            ->where('ein_user', $userId)
            ->first();

        if ($inscricaoExistente) {
            return redirect()->to('/eventos')->with('success', 'Você já está inscrito neste evento.');
        }

        $inscritosModel->insert([
            'ein_event' => (int) $id,
            'ein_tipo' => 1,
            'ein_user' => (int) $userId,
            'ein_data' => date('Y-m-d H:i:s'),
            'ein_pago' => 0,
            'ein_presente' => 0,
            'ein_recibo' => '',
        ]);

        return redirect()->to('/eventos')->with('success', 'Inscrição realizada com sucesso!');
    }

    public function cancelar($id)
    {
        if (!session('usuario')) {
            return redirect()->to('/auth/login')->with('erro', 'Faça login para continuar.');
        }

        $userId = session('usuario.id_n') ?? session('usuario.id');
        if (!$userId) {
            return redirect()->to('/auth/login')->with('erro', 'Faça login para continuar.');
        }

        $inscritosModel = new EventInscritosModel();
        $inscricao = $inscritosModel
            ->where('ein_event', (int) $id)
            ->where('ein_user', (int) $userId)
            ->first();

        if (!$inscricao) {
            return redirect()->to('/eventos')->with('erro', 'Você não possui inscrição neste evento.');
        }

        $inscritosModel->delete((int) $inscricao['id_ein']);

        return redirect()->to('/eventos')->with('success', 'Inscrição cancelada com sucesso.');
    }

    public function enviarConfirmacao($id)
    {
        if (!session('usuario')) {
            return redirect()->to('/auth/login')->with('erro', 'Faça login para continuar.');
        }

        $userId = session('usuario.id_n') ?? session('usuario.id');
        if (!$userId) {
            return redirect()->to('/auth/login')->with('erro', 'Faça login para continuar.');
        }

        $eventsModel = new EventsModel();
        $evento = $eventsModel->find((int) $id);
        if (!$evento) {
            return redirect()->to('/eventos')->with('erro', 'Evento não encontrado.');
        }

        $inscritosModel = new EventInscritosModel();
        $inscricao = $inscritosModel
            ->where('ein_event', (int) $id)
            ->where('ein_user', (int) $userId)
            ->first();

        if (!$inscricao) {
            return redirect()->to('/eventos')->with('erro', 'Você não está inscrito neste evento.');
        }

        $usersModel = new UsersModel();
        $usuario = $usersModel->find((int) $userId);
        $emailDestino = $usuario['n_email'] ?? (session('usuario.email') ?? null);
        $nomeDestino = $usuario['n_nome'] ?? (session('usuario.nome') ?? 'Participante');

        if (empty($emailDestino)) {
            return redirect()->to('/eventos')->with('erro', 'Não foi possível identificar seu e-mail de cadastro.');
        }

        $emailService = \Config\Services::email();
        $fromEmail = getenv('email.fromEmail') ?: 'no-reply@gev3nt.local';
        $fromName = getenv('email.fromName') ?: 'Gev3nt';

        $emailService->setTo($emailDestino);
        $emailService->setFrom($fromEmail, $fromName);
        $emailService->setSubject('Confirmacao de inscricao - ' . ($evento['e_name'] ?? 'Evento'));
        $emailService->setMessage($this->buildConfirmationMessage($evento, (string) $nomeDestino));

        $googleIcsPath = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'evento_google_' . (int) $id . '_' . time() . '.ics';
        $microsoftIcsPath = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'evento_microsoft_' . (int) $id . '_' . time() . '.ics';

        if (!is_dir(dirname($googleIcsPath))) {
            mkdir(dirname($googleIcsPath), 0777, true);
        }

        file_put_contents($googleIcsPath, $this->buildIcsContent($evento));
        file_put_contents($microsoftIcsPath, $this->buildIcsContent($evento));

        //$emailService->attach($googleIcsPath, 'attachment', 'google-calendar.ics', 'text/calendar; charset=utf-8; method=REQUEST');
        //$emailService->attach($microsoftIcsPath, 'attachment', 'microsoft-calendar.ics', 'text/calendar; charset=utf-8; method=REQUEST');
        //$emailService->attach($googleIcsPath);
        //$emailService->attach($microsoftIcsPath);
        $email_attach = file_get_contents($googleIcsPath);
        $emailService->attach($email_attach, 'attachment', 'evento.ics', 'text/calendar; charset=utf-8; method=REQUEST');

        $sent = $emailService->send();

        @unlink($googleIcsPath);
        @unlink($microsoftIcsPath);

        if (!$sent) {
            return redirect()->to('/eventos')->with('erro', 'Nao foi possivel enviar o e-mail de confirmacao agora.');
        }

        return redirect()->to('/eventos')->with('success', 'Confirmacao enviada para o seu e-mail com anexos de calendario.');
    }

    private function buildConfirmationMessage(array $evento, string $nome): string
    {
        $nomeEvento = esc((string) ($evento['e_name'] ?? 'Evento'));
        $local = esc((string) ($evento['e_location'] ?? 'Nao informado'));
        $descricao = nl2br(esc((string) ($evento['e_texto'] ?? '')));
        $dataInicio = !empty($evento['e_data_i']) ? date('d/m/Y', strtotime((string) $evento['e_data_i'])) : '-';
        $dataFim = !empty($evento['e_data_f']) ? date('d/m/Y', strtotime((string) $evento['e_data_f'])) : '-';
        $horaInicio = esc((string) ($evento['e_hora_inicio'] ?? ''));
        $horaFim = esc((string) ($evento['e_hora_fim'] ?? ''));

        return '<p>Ola, ' . esc($nome) . '.</p>'
            . '<p>Sua inscricao foi confirmada no evento <strong>' . $nomeEvento . '</strong>.</p>'
            . '<p><strong>Local:</strong> ' . $local . '<br>'
            . '<strong>Data:</strong> ' . $dataInicio . ' ate ' . $dataFim . '<br>'
            . '<strong>Horario:</strong> ' . ($horaInicio !== '' ? $horaInicio : '-') . ' / ' . ($horaFim !== '' ? $horaFim : '-') . '</p>'
            . '<p><strong>Descricao:</strong><br>' . $descricao . '</p>'
            . '<p>Foram anexados arquivos para adicionar automaticamente na agenda do Google e Microsoft.</p>';
    }

    private function buildIcsContent(array $evento): string
    {
        $eventId = (int) ($evento['id_e'] ?? 0);
        $title = $this->escapeIcsText((string) ($evento['e_name'] ?? 'Evento Gev3nt'));
        $location = $this->escapeIcsText((string) ($evento['e_location'] ?? ''));
        $description = $this->escapeIcsText((string) ($evento['e_texto'] ?? ''));

        $hasTime = !empty($evento['e_hora_inicio']) || !empty($evento['e_hora_fim']);
        $startDate = (string) ($evento['e_data_i'] ?? date('Y-m-d'));
        $endDate = (string) ($evento['e_data_f'] ?? $startDate);

        if ($hasTime) {
            $startTime = !empty($evento['e_hora_inicio']) ? (string) $evento['e_hora_inicio'] : '00:00:00';
            $endTime = !empty($evento['e_hora_fim']) ? (string) $evento['e_hora_fim'] : '23:59:00';
            $dtStart = date('Ymd\\THis', strtotime($startDate . ' ' . $startTime));
            $dtEnd = date('Ymd\\THis', strtotime($endDate . ' ' . $endTime));
            $dateBlock = "DTSTART;TZID=America/Sao_Paulo:" . $dtStart . "\\r\\n"
                . "DTEND;TZID=America/Sao_Paulo:" . $dtEnd;
        } else {
            $dtStart = date('Ymd', strtotime($startDate));
            $dtEndExclusive = date('Ymd', strtotime($endDate . ' +1 day'));
            $dateBlock = "DTSTART;VALUE=DATE:" . $dtStart . "\\r\\n"
                . "DTEND;VALUE=DATE:" . $dtEndExclusive;
        }

        $uid = 'gev3nt-evento-' . $eventId . '-' . substr(md5((string) microtime(true)), 0, 10) . '@gev3nt';
        $dtStamp = gmdate('Ymd\\THis\\Z');

        $txt = "BEGIN:VCALENDAR[CR]"
            . "VERSION:2.0[CR]"
            . "PRODID:-//Gev3nt//Eventos//PT-BR[CR]"
            . "ORGANIZER;CN=Gev3nt:MAILTO:bracpcici@gmail.com[CR]"
            . "ATTENDEE;CN=" . $this->escapeIcsText($title) . ";RSVP=TRUE:MAILTO:[CR]"
            . "CALSCALE:GREGORIAN[CR]"
            . "METHOD:REQUEST[CR]"
            . "BEGIN:VEVENT[CR]"
            . "UID:" . $uid . "[CR]"
            . "DTSTART;TZID=America/Sao_Paulo:" . $dtStart . "[CR]"
            . "DTEND;TZID=America/Sao_Paulo:" . $dtEnd . "[CR]"
            . "DTSTAMP:" . $dtStamp . "[CR]"
            . "TZOFFSETFROM:-0300[CR]"
            . "TZOFFSETTO:-0300[CR]"
            . $dateBlock . "[CR]"
            . "SUMMARY:" . $title . "[CR]"
            . "LOCATION:" . $location . "[CR]"
            . "DESCRIPTION:" . $description . "[CR]"
            . "END:VEVENT[CR]"
            . "END:VCALENDAR[CR]";
        $txt = str_replace('[CR]', "\r\n", $txt);
        return $txt;
    }

    private function escapeIcsText(string $value): string
    {
        $value = str_replace('\\\\', '\\\\\\\\', $value);
        $value = str_replace(';', '\\;', $value);
        $value = str_replace(',', '\\,', $value);
        $value = str_replace(["\r\n", "\n", "\r"], '\\n', $value);
        return $value;
    }
}
