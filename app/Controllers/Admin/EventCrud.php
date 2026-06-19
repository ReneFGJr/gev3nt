<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EventBaseModel;
use App\Models\UsersModel;

class EventCrud extends BaseController
{
    private function getCurrentUserId(): ?int
    {
        $userId = session('usuario.id_n') ?? session('usuario.id');

        if ($userId === null || $userId === '') {
            return null;
        }

        return (int) $userId;
    }

    public function index()
    {
        $model = new EventBaseModel();
        $items = $model->orderBy('id_e', 'DESC')->findAll();

        return view('admin/event/index', [
            'items' => $items,
        ]);
    }

    public function create()
    {
        return view('admin/event/create');
    }

    public function store()
    {
        $model = new EventBaseModel();
        $data = $this->request->getPost();
        $data['e_active'] = isset($data['e_active']) ? (int) $data['e_active'] : 1;

        $model->insert($data);
        return redirect()->to('/admin/event')->with('success', 'Registro criado com sucesso!');
    }

    public function edit($id)
    {
        $model = new EventBaseModel();
        $item = $model->find((int) $id);

        if (!$item) {
            return redirect()->to('/admin/event')->with('error', 'Registro não encontrado.');
        }

        return view('admin/event/edit', [
            'item' => $item,
        ]);
    }

    public function view($id)
    {
        $model = new EventBaseModel();
        $item = $model->find((int) $id);

        if (!$item) {
            return redirect()->to('/admin/event')->with('error', 'Registro não encontrado.');
        }

        $usersModel = new UsersModel();
        $users = $usersModel->orderBy('n_nome', 'ASC')->findAll();

        $permissions = db_connect()
            ->table('event_permissions')
            ->select('event_permissions.id_ep, event_permissions.ep_event_id, event_permissions.ep_user_id, event_permissions.ep_created, events_names.n_nome, events_names.n_email')
            ->join('events_names', 'events_names.id_n = event_permissions.ep_user_id', 'inner')
            ->where('event_permissions.ep_event_id', (int) $id)
            ->where('event_permissions.ep_can_manage', 1)
            ->orderBy('events_names.n_nome', 'ASC')
            ->get()
            ->getResultArray();

        return view('admin/event/view', [
            'item' => $item,
            'users' => $users,
            'permissions' => $permissions,
        ]);
    }

    public function grantAccess($id)
    {
        $model = new EventBaseModel();
        $item = $model->find((int) $id);

        if (!$item) {
            return redirect()->to('/admin/event')->with('error', 'Registro não encontrado.');
        }

        $userId = (int) $this->request->getPost('ep_user_id');
        if ($userId <= 0) {
            return redirect()->to('/admin/event/view/' . (int) $id)->with('error', 'Selecione um usuário para liberar o acesso.');
        }

        $db = db_connect();
        $builder = $db->table('event_permissions');

        $alreadyGranted = $builder
            ->where('ep_event_id', (int) $id)
            ->where('ep_user_id', $userId)
            ->countAllResults() > 0;

        if (!$alreadyGranted) {
            $builder->insert([
                'ep_event_id' => (int) $id,
                'ep_user_id' => $userId,
                'ep_can_manage' => 1,
            ]);
        } else {
            $builder->where('ep_event_id', (int) $id)
                ->where('ep_user_id', $userId)
                ->update(['ep_can_manage' => 1]);
        }

        return redirect()->to('/admin/event/view/' . (int) $id)->with('success', 'Acesso liberado com sucesso.');
    }

    public function revokeAccess($permissionId)
    {
        $db = db_connect();
        $permission = $db->table('event_permissions')
            ->where('id_ep', (int) $permissionId)
            ->get()
            ->getRowArray();

        if (!$permission) {
            return redirect()->to('/admin/event')->with('error', 'Liberação não encontrada.');
        }

        $db->table('event_permissions')
            ->where('id_ep', (int) $permissionId)
            ->delete();

        return redirect()->to('/admin/event/view/' . (int) ($permission['ep_event_id'] ?? 0))->with('success', 'Liberação excluída com sucesso.');
    }

    public function update($id)
    {
        $model = new EventBaseModel();
        $item = $model->find((int) $id);

        if (!$item) {
            return redirect()->to('/admin/event')->with('error', 'Registro não encontrado.');
        }

        $data = $this->request->getPost();
        $data['e_active'] = isset($data['e_active']) ? (int) $data['e_active'] : 0;

        $backgroundFile = $this->request->getFile('e_background_file');
        if ($backgroundFile && $backgroundFile->getError() !== UPLOAD_ERR_NO_FILE) {
            if (!$backgroundFile->isValid() || $backgroundFile->hasMoved()) {
                return redirect()->back()->with('error', 'Falha no upload do background.');
            }

            $extension = strtolower((string) $backgroundFile->getExtension());
            $mimeType = strtolower((string) $backgroundFile->getClientMimeType());
            $jpgMimes = ['image/jpeg', 'image/pjpeg'];

            if (!in_array($extension, ['jpg', 'jpeg'], true) || !in_array($mimeType, $jpgMimes, true)) {
                return redirect()->back()->with('error', 'Arquivo inválido. Envie somente imagem JPG.');
            }

            $destDir = FCPATH . 'img/certificado';
            if (!is_dir($destDir)) {
                mkdir($destDir, 0777, true);
            }

            $newName = 'background_event_' . (int) $id . '_' . time() . '.jpg';
            $backgroundFile->move($destDir, $newName, true);
            $data['e_background'] = 'img/certificado/' . $newName;
        }

        $model->update((int) $id, $data);
        return redirect()->to('/admin/event')->with('success', 'Registro atualizado com sucesso!');
    }

    public function delete($id)
    {
        $model = new EventBaseModel();
        $item = $model->find((int) $id);

        if (!$item) {
            return redirect()->to('/admin/event')->with('error', 'Registro não encontrado.');
        }

        $model->delete((int) $id);
        return redirect()->to('/admin/event')->with('success', 'Registro removido com sucesso!');
    }
}
