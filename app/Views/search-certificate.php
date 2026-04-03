<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <h2 class="mb-4">Busca de Certificado</h2>
                    <?php if (!empty($query)): ?>
                        <div class="alert alert-info">Resultado da busca para: <strong><?= esc($query) ?></strong></div>
                        <p class="text-muted">(Aqui você pode exibir os resultados reais da busca...)</p>
                    <?php else: ?>
                        <div class="alert alert-warning">Nenhum termo de busca informado.</div>
                    <?php endif; ?>
                    <a href="/" class="btn btn-primary mt-3">Voltar para o início</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
