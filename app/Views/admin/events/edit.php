<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <h2>Editar Evento</h2>
    <form action="/admin/events/update/<?= esc($event['id_e']) ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="e_name" class="form-label">Nome do Evento</label>
            <input type="text" class="form-control" id="e_name" name="e_name" value="<?= esc($event['e_name']) ?>" required>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="e_data_i" class="form-label">Data Inicial</label>
                <input type="date" class="form-control" id="e_data_i" name="e_data_i" value="<?= esc($event['e_data_i']) ?>" required>
            </div>
            <div class="col-md-4">
                <label for="e_data_f" class="form-label">Data Final</label>
                <input type="date" class="form-control" id="e_data_f" name="e_data_f" value="<?= esc($event['e_data_f']) ?>" required>
            </div>
            <div class="col-md-2">
                <label for="e_hora_inicio" class="form-label">Hora Inicial</label>
                <input type="time" class="form-control" id="e_hora_inicio" name="e_hora_inicio" value="<?= esc($event['e_hora_inicio']) ?>">
            </div>
            <div class="col-md-2">
                <label for="e_hora_fim" class="form-label">Hora Final</label>
                <input type="time" class="form-control" id="e_hora_fim" name="e_hora_fim" value="<?= esc($event['e_hora_fim'] ?? '') ?>">
            </div>
        </div>
        <div class="mb-3">
            <label for="e_location" class="form-label">Localização</label>
            <input type="text" class="form-control" id="e_location" name="e_location" value="<?= esc($event['e_location']) ?>">
        </div>
        <div class="mb-3">
            <label for="e_texto" class="form-label">Descrição do Evento</label>
            <textarea class="form-control" id="e_texto" name="e_texto" rows="3"><?= esc($event['e_texto']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="e_status" class="form-label">Status do Evento</label>
            <select class="form-select" id="e_status" name="e_status">
                <option value="0" <?= $event['e_status'] == 0 ? 'selected' : '' ?>>Aberto para inscrição</option>
                <option value="1" <?= $event['e_status'] == 1 ? 'selected' : '' ?>>Finalizado</option>
                <option value="9" <?= $event['e_status'] == 9 ? 'selected' : '' ?>>Cancelado</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="card_img" class="form-label">Imagem (Card) do Evento</label>
            <input type="file" class="form-control" id="card_img" name="card_img" accept="image/*">
            <?php if (!empty($event['e_ass_img'])): ?>
                <div class="mt-2">
                    <img src="<?= base_url($event['e_ass_img']) ?>" alt="Imagem atual" style="max-width:200px;">
                </div>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-success">Salvar Alterações</button>
        <a href="/admin/events" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?= $this->endSection() ?>
