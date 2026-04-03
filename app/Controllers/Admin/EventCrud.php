<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EventBaseModel;

class EventCrud extends BaseController
{
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
