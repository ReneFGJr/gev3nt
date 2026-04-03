<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EventsModel;
use App\Models\EventInscritosModel;
use App\Models\UsersModel;

class Events extends BaseController
{
    public function index()
    {
        $eventsModel = new EventsModel();
        $events = $eventsModel->orderBy('id_e', 'DESC')->findAll();
        return view('admin/events/index', ['events' => $events]);
    }

    public function create()
    {
        return view('admin/events/create');
    }

    public function store()
    {
        $eventsModel = new EventsModel();
        $data = $this->request->getPost();
        $limiteInscritos = (int) ($data['e_limit_inscritos'] ?? 0);
        $data['e_limit_inscritos'] = $limiteInscritos > 0 ? $limiteInscritos : 9999;
        $eventsModel->insert($data);
        return redirect()->to('/admin/events')->with('success', 'Evento criado com sucesso!');
    }
    public function edit($id)
    {
        $eventsModel = new EventsModel();
        $event = $eventsModel->find($id);
        if (!$event) {
            return redirect()->to('/admin/events')->with('error', 'Evento não encontrado!');
        }
        return view('admin/events/edit', ['event' => $event]);
    }

    public function update($id)
    {
        $eventsModel = new EventsModel();
        $data = $this->request->getPost();
        $limiteInscritos = (int) ($data['e_limit_inscritos'] ?? 0);
        $data['e_limit_inscritos'] = $limiteInscritos > 0 ? $limiteInscritos : 9999;

        // Se e_data_f for menor que hoje, status = 1
        $hoje = date('Y-m-d');
        if (!empty($data['e_data_f']) && $data['e_data_f'] < $hoje) {
            $data['e_status'] = 1;
        }

        // Se e_data_f estiver em branco ou 0000-00-00, defina como hoje
        if (empty($data['e_data_f']) || $data['e_data_f'] == '0000-00-00') {
            $data['e_data_f'] = $hoje;
        }

        // Upload da imagem (opcional)
        $file = $this->request->getFile('card_img');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = 'event_' . $id . '_' . time() . '.' . $file->getExtension();
            $file->move(FCPATH . '_repository/events', $newName);
            $data['e_ass_img'] = '_repository/events/' . $newName;
        }

        $eventsModel->update($id, $data);
        return redirect()->to('/admin/events')->with('success', 'Evento atualizado com sucesso!');
    }
    public function view($id)
    {
        $eventsModel = new EventsModel();
        $event = $eventsModel->find($id);
        if (!$event) {
            return redirect()->to('/admin/events')->with('error', 'Evento não encontrado!');
        }

        // Buscar quantidade de inscritos e presentes
        $inscritosModel = new \App\Models\EventInscritosModel();
        $totalInscritos = $inscritosModel->where('ein_event', $id)->countAllResults();
        $totalPresentes = $inscritosModel->where(['ein_event' => $id, 'ein_presente' => 1])->countAllResults();

        return view('admin/events/view', [
            'event' => $event,
            'totalInscritos' => $totalInscritos,
            'totalPresentes' => $totalPresentes
        ]);
    }
    public function import($id)
    {
        if (strtolower($this->request->getMethod()) === 'post') {
            $importData = (string) $this->request->getPost('import_data');
            $mode = (string) $this->request->getPost('mode');
            $previewMode = $mode !== 'import';
            $result = $this->processImportData($id, $importData, $previewMode);

            return view('admin/events/import', [
                'id' => $id,
                'importData' => $importData,
                'importReport' => $result,
            ]);
        }

        return view('admin/events/import', ['id' => $id, 'importData' => '']);
    }

    public function signList($id)
    {
        $eventsModel = new EventsModel();
        $event = $eventsModel->find((int) $id);

        if (!$event) {
            return redirect()->to('/admin/events')->with('error', 'Evento não encontrado!');
        }

        $inscritosModel = new EventInscritosModel();
        $inscritos = $inscritosModel
            ->select('events_names.n_nome, events_names.n_email')
            ->join('events_names', 'events_names.id_n = event_inscritos.ein_user', 'left')
            ->where('event_inscritos.ein_event', (int) $id)
            ->orderBy('events_names.n_nome', 'ASC')
            ->orderBy('events_names.n_email', 'ASC')
            ->findAll();

        return view('admin/events/sign_list', [
            'event' => $event,
            'inscritos' => $inscritos,
        ]);
    }

    private function processImportData(int $eventId, string $importData, bool $dryRun = false): array
    {
        $usersModel = new UsersModel();
        $inscritosModel = new EventInscritosModel();

        $report = [
            'mode' => $dryRun ? 'preview' : 'final',
            'parsed' => [],
            'success' => [],
            'failed' => [],
            'createdUsers' => 0,
            'createdSubscriptions' => 0,
            'skippedLines' => 0,
        ];

        $lines = preg_split('/\r\n|\r|\n/', $importData) ?: [];
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            $lineNumber = count($report['success']) + count($report['failed']) + 1;

            $email = null;
            if (preg_match('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}/i', $line, $matches)) {
                $email = strtolower(trim($matches[0]));
            }

            if (!$email) {
                $report['skippedLines']++;
                $report['failed'][] = [
                    'line' => $lineNumber,
                    'input' => $line,
                    'reason' => 'E-mail não encontrado na linha.',
                ];
                continue;
            }

            $parts = array_values(array_filter(array_map('trim', preg_split('/[;\t,]+/', $line) ?: []), static fn ($value) => $value !== ''));
            $name = $parts[0] ?? '';
            if ($name === '' || filter_var($name, FILTER_VALIDATE_EMAIL)) {
                $name = strstr($email, '@', true) ?: $email;
            }

            $report['parsed'][] = [
                'line' => $lineNumber,
                'name' => $name,
                'email' => $email,
            ];

            $user = $usersModel->where('n_email', $email)->first();
            $userCreated = false;
            if (!$user) {
                $cracha = substr(hash('sha256', $email), 0, 15);
                if ($dryRun) {
                    $userId = null;
                    $report['createdUsers']++;
                } else {
                    $userId = $usersModel->insert([
                        'n_email' => $email,
                        'n_nome' => $name,
                        'n_cracha' => $cracha,
                    ], true);
                    if (!$userId) {
                        $report['failed'][] = [
                            'line' => $lineNumber,
                            'input' => $line,
                            'reason' => 'Falha ao criar usuário.',
                        ];
                        continue;
                    }
                    $report['createdUsers']++;
                }
                $userCreated = true;
            } else {
                $userId = $user['id_n'];
            }

            if ($dryRun && $userCreated) {
                $existingSubscription = false;
            } else {
                $existingSubscription = $inscritosModel
                    ->where('ein_event', $eventId)
                    ->where('ein_user', $userId)
                    ->first();
            }

            if ($existingSubscription) {
                $report['failed'][] = [
                    'line' => $lineNumber,
                    'input' => $line,
                    'reason' => 'Usuário já inscrito neste evento.',
                ];
                continue;
            }

            if ($dryRun) {
                $report['createdSubscriptions']++;
            } else {
                $subscriptionId = $inscritosModel->insert([
                    'ein_event' => $eventId,
                    'ein_tipo' => 1,
                    'ein_user' => $userId,
                    'ein_data' => date('Y-m-d H:i:s'),
                    'ein_pago' => 0,
                    'ein_presente' => 0,
                    'ein_recibo' => '',
                ], true);

                if (!$subscriptionId) {
                    $report['failed'][] = [
                        'line' => $lineNumber,
                        'input' => $line,
                        'reason' => 'Falha ao criar inscrição.',
                    ];
                    continue;
                }

                $report['createdSubscriptions']++;
            }
            $report['success'][] = [
                'line' => $lineNumber,
                'name' => $name,
                'email' => $email,
                'userCreated' => $userCreated,
                'status' => $dryRun
                    ? ($userCreated ? 'Usuário seria criado e inscrito' : 'Usuário encontrado e seria inscrito')
                    : ($userCreated ? 'Usuário criado e inscrito' : 'Usuário encontrado e inscrito'),
            ];
        }


        return $report;
    }
}
