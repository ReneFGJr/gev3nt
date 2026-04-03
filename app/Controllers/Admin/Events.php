<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EventsModel;

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
        $inscritosModel = new \App\Models\EventsInscritosModel();
        $totalInscritos = $inscritosModel->where('i_evento', $id)->countAllResults();
        $totalPresentes = $inscritosModel->where(['i_evento' => $id, 'i_status' => 1])->countAllResults();

        return view('admin/events/view', [
            'event' => $event,
            'totalInscritos' => $totalInscritos,
            'totalPresentes' => $totalPresentes
        ]);
    }
    public function import($id)
    {
        // Apenas exibe o formulário, processamento pode ser implementado depois
        return view('admin/events/import', ['id' => $id]);
    }
}
