<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <h2>Editar Registro - event</h2>
    <form action="<?= base_url('admin/event/update/' . ($item['id_e'] ?? 0)) ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="e_name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="e_name" name="e_name" value="<?= esc($item['e_name'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="e_url" class="form-label">URL</label>
            <input type="text" class="form-control" id="e_url" name="e_url" value="<?= esc($item['e_url'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="e_description" class="form-label">Descrição</label>
            <textarea class="form-control" id="e_description" name="e_description" rows="4"><?= esc($item['e_description'] ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label for="e_logo" class="form-label">Logo (caminho/URL)</label>
            <input type="text" class="form-control" id="e_logo" name="e_logo" value="<?= esc($item['e_logo'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="e_cidade" class="form-label">Cidade</label>
            <input type="text" class="form-control" id="e_cidade" name="e_cidade" value="<?= esc($item['e_cidade'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="e_assinatura" class="form-label">Texto do certificado</label>
            <textarea class="form-control" id="e_assinatura" name="e_assinatura" rows="6" placeholder="Digite o texto base do certificado..."><?= esc($item['e_assinatura'] ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label for="e_background_file" class="form-label">Background do certificado (somente JPG)</label>
            <input type="file" class="form-control" id="e_background_file" name="e_background_file" accept=".jpg,.jpeg,image/jpeg">
            <?php if (!empty($item['e_background'])): ?>
                <div class="form-text mt-2">
                    Atual: <a href="<?= base_url($item['e_background']) ?>" target="_blank" rel="noopener noreferrer"><?= esc($item['e_background']) ?></a>
                </div>
            <?php endif; ?>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label for="e_data_i" class="form-label">Data Inicial</label>
                <input type="date" class="form-control" id="e_data_i" name="e_data_i" value="<?= esc($item['e_data_i'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label for="e_data_f" class="form-label">Data Final</label>
                <input type="date" class="form-control" id="e_data_f" name="e_data_f" value="<?= esc($item['e_data_f'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label for="e_sigin_until" class="form-label">Inscrição até</label>
                <input type="date" class="form-control" id="e_sigin_until" name="e_sigin_until" value="<?= esc($item['e_sigin_until'] ?? '') ?>">
            </div>
        </div>
        <div class="mb-3">
            <label for="e_active" class="form-label">Ativo</label>
            <select class="form-select" id="e_active" name="e_active">
                <option value="1" <?= (int) ($item['e_active'] ?? 0) === 1 ? 'selected' : '' ?>>Sim</option>
                <option value="0" <?= (int) ($item['e_active'] ?? 0) === 0 ? 'selected' : '' ?>>Não</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Salvar Alterações</button>
        <a href="<?= base_url('admin/event') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?= $this->endSection() ?>
