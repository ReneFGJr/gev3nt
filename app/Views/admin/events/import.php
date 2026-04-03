<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <h2>Importar Usuários/Dados para o Evento</h2>
    <form action="/admin/event/import/<?= esc($id) ?>" method="post">
        <div class="mb-3">
            <label for="import_data" class="form-label">Cole ou digite a lista de inscritos:</label>
            <textarea class="form-control" id="import_data" name="import_data" rows="10" placeholder="Nome;Email;Outro dado..."></textarea>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Importar</button>
            <a href="/admin/events/view/<?= esc($id) ?>" class="btn btn-secondary">Cancelar</a>
            <a href="/admin/events/view/<?= esc($id) ?>" class="btn btn-outline-primary">Voltar</a>
        </div>
    </form>
    </form>
</div>
<?= $this->endSection() ?>
