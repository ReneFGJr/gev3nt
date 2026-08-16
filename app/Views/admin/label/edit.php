<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Editar etiqueta</h2>
        <a href="<?= base_url('admin/label') ?>" class="btn btn-outline-secondary">Voltar</a>
    </div>

    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= session('error') ?></div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('admin/label/update/' . $label['id_label']) ?>">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" id="nome" name="nome" class="form-control" value="<?= esc(old('nome', $label['nome'])) ?>" required>
        </div>
        <div class="mb-3">
            <label for="instituicao" class="form-label">Instituição</label>
            <input type="text" id="instituicao" class="form-control" value="<?= esc($label['instituicao']) ?>" disabled>
        </div>
        <button type="submit" class="btn btn-primary">Salvar nome</button>
    </form>
</div>
<?= $this->endSection() ?>