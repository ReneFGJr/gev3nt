<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <h2>Novo Evento</h2>
    <form action="/admin/events/store" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="e_name" class="form-label">Nome do Evento</label>
            <input type="text" class="form-control" id="e_name" name="e_name" required>
        </div>
        <div class="mb-3">
            <label for="e_data_i" class="form-label">Data Inicial</label>
            <input type="date" class="form-control" id="e_data_i" name="e_data_i" required>
        </div>
        <div class="mb-3">
            <label for="e_data_f" class="form-label">Data Final</label>
            <input type="date" class="form-control" id="e_data_f" name="e_data_f" required>
        </div>
        <div class="mb-3">
            <label for="e_texto" class="form-label">Descrição do Evento</label>
            <textarea class="form-control" id="e_texto" name="e_texto" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="e_location" class="form-label">Localização</label>
            <input type="text" class="form-control" id="e_location" name="e_location">
        </div>
        <div class="mb-3">
            <label for="e_hora_inicio" class="form-label">Hora Inicial (opcional)</label>
            <input type="time" class="form-control" id="e_hora_inicio" name="e_hora_inicio">
        </div>
        <div class="mb-3">
            <label for="card_img" class="form-label">Imagem (Card) do Evento</label>
            <input type="file" class="form-control" id="card_img" name="card_img" accept="image/*">
        </div>
        <button type="submit" class="btn btn-success">Criar Evento</button>
        <a href="/admin/events" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?= $this->endSection() ?>
