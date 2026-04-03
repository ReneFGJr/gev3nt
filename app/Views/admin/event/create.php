<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <h2>Novo Registro - event</h2>
    <form action="<?= base_url('admin/event/store') ?>" method="post">
        <div class="mb-3">
            <label for="e_name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="e_name" name="e_name" required>
        </div>
        <div class="mb-3">
            <label for="e_url" class="form-label">URL</label>
            <input type="text" class="form-control" id="e_url" name="e_url">
        </div>
        <div class="mb-3">
            <label for="e_description" class="form-label">Descrição</label>
            <textarea class="form-control" id="e_description" name="e_description" rows="4"></textarea>
        </div>
        <div class="mb-3">
            <label for="e_logo" class="form-label">Logo (caminho/URL)</label>
            <input type="text" class="form-control" id="e_logo" name="e_logo">
        </div>
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label for="e_data_i" class="form-label">Data Inicial</label>
                <input type="date" class="form-control" id="e_data_i" name="e_data_i">
            </div>
            <div class="col-md-4">
                <label for="e_data_f" class="form-label">Data Final</label>
                <input type="date" class="form-control" id="e_data_f" name="e_data_f">
            </div>
            <div class="col-md-4">
                <label for="e_sigin_until" class="form-label">Inscrição até</label>
                <input type="date" class="form-control" id="e_sigin_until" name="e_sigin_until">
            </div>
        </div>
        <div class="mb-3">
            <label for="e_active" class="form-label">Ativo</label>
            <select class="form-select" id="e_active" name="e_active">
                <option value="1" selected>Sim</option>
                <option value="0">Não</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="<?= base_url('admin/event') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?= $this->endSection() ?>
