<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <h2>Importar Usuários/Dados para o Evento</h2>

    <?php $importReport = $importReport ?? null; ?>
    <?php if (!empty($importReport)): ?>
        <div class="alert alert-<?= ($importReport['mode'] ?? '') === 'preview' ? 'warning' : 'info' ?> mb-4">
            <strong><?= ($importReport['mode'] ?? '') === 'preview' ? 'Prévia de importação.' : 'Importação processada.' ?></strong>
            <?= esc($importReport['createdSubscriptions'] ?? 0) ?> inscrição(ões) criada(s),
            <?= esc($importReport['createdUsers'] ?? 0) ?> usuário(s) novo(s),
            <?= esc($importReport['failed'] ? count($importReport['failed']) : 0) ?> falha(s).
            <?php if (($importReport['mode'] ?? '') === 'preview'): ?>
                Nenhum dado foi salvo ainda.
            <?php endif; ?>
        </div>

        <?php if (!empty($importReport['parsed'])): ?>
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">Prévia dos dados reconhecidos</div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Linha</th>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Título do trabalho</th>
                                <th>Coautores</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($importReport['parsed'] as $item): ?>
                                <tr>
                                    <td><?= esc($item['line']) ?></td>
                                    <td><?= esc($item['name']) ?></td>
                                    <td><?= esc($item['email']) ?></td>
                                    <td><?= esc($item['titulo'] ?? '') ?></td>
                                    <td><?= esc($item['coautores'] ?? '') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning mb-4">
                Nenhum e-mail foi reconhecido no conteúdo informado.
            </div>
        <?php endif; ?>

        <?php if (!empty($importReport['success'])): ?>
            <div class="card mb-4 border-success">
                <div class="card-header bg-success text-white">Sucessos</div>
                <ul class="list-group list-group-flush">
                    <?php foreach ($importReport['success'] as $item): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div>
                                <strong>Linha <?= esc($item['line']) ?>:</strong>
                                <?= esc($item['name']) ?> - <?= esc($item['email']) ?>
                                <span class="text-muted">(<?= esc($item['status']) ?>)</span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($importReport['failed'])): ?>
            <div class="card mb-4 border-danger">
                <div class="card-header bg-danger text-white">Fracassos</div>
                <ul class="list-group list-group-flush">
                    <?php foreach ($importReport['failed'] as $item): ?>
                        <li class="list-group-item">
                            <strong>Linha <?= esc($item['line']) ?>:</strong>
                            <?= esc($item['reason']) ?>
                            <div class="text-muted small">Entrada: <?= esc($item['input']) ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <form action="<?= base_url('admin/events/import/' . esc($id)) ?>" method="post">
        <div class="mb-3">
            <label for="import_data" class="form-label">Cole ou digite a lista de inscritos:</label>
            <textarea class="form-control" id="import_data" name="import_data" rows="10" placeholder="Nome;Email;Título do Trabalho;Coautores"><?= esc($importData ?? '') ?></textarea>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" name="mode" value="preview" class="btn btn-outline-primary">Pré-visualizar</button>
            <button type="submit" name="mode" value="import" class="btn btn-success">Importar</button>
            <a href="<?= base_url('admin/events/view/' . esc($id)) ?>" class="btn btn-secondary">Cancelar</a>
            <a href="<?= base_url('admin/events/view/' . esc($id)) ?>" class="btn btn-outline-primary">Voltar</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
