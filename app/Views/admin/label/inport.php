<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Incluir etiquetas</h2>
        <a href="<?= base_url('admin/label') ?>" class="btn btn-outline-secondary">Voltar</a>
    </div>

    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= session('error') ?></div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('admin/label/inport') ?>">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="labels_content" class="form-label">Dados das etiquetas</label>
            <textarea id="labels_content" name="labels_content" class="form-control" rows="12" placeholder="Nome;Instituicao&#10;Maria da Silva;Universidade X&#10;Joao Souza	Instituto Y"><?= esc(old('labels_content')) ?></textarea>
            <div class="form-text">Informe uma etiqueta por linha no formato Nome;Instituicao, Nome[TAB]Instituicao ou Nome com 2+ espacos antes da Instituicao.</div>
        </div>

        <button type="submit" class="btn btn-primary">Salvar etiquetas</button>
    </form>
</div>
<?= $this->endSection() ?>