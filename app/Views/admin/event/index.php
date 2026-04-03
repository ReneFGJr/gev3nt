<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">CRUD - Tabela event</h2>
        <a href="<?= base_url('admin/event/create') ?>" class="btn btn-success">Novo Registro</a>
    </div>

    <?php if (session('success')): ?>
        <div class="alert alert-success"><?= esc(session('success')) ?></div>
    <?php endif; ?>

    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <?php if (empty($items)): ?>
        <div class="alert alert-info">Nenhum registro encontrado.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>URL</th>
                        <th>Ativo</th>
                        <th>Início</th>
                        <th>Fim</th>
                        <th>Inscrição até</th>
                        <th style="width: 220px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= esc((string) ($item['id_e'] ?? '')) ?></td>
                            <td><?= esc($item['e_name'] ?? '-') ?></td>
                            <td><?= esc($item['e_url'] ?? '-') ?></td>
                            <td><?= (int) ($item['e_active'] ?? 0) === 1 ? 'Sim' : 'Não' ?></td>
                            <td><?= esc($item['e_data_i'] ?? '-') ?></td>
                            <td><?= esc($item['e_data_f'] ?? '-') ?></td>
                            <td><?= esc($item['e_sigin_until'] ?? '-') ?></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="<?= base_url('admin/event/edit/' . ($item['id_e'] ?? 0)) ?>" class="btn btn-primary btn-sm">Editar</a>
                                    <form action="<?= base_url('admin/event/delete/' . ($item['id_e'] ?? 0)) ?>" method="post" onsubmit="return confirm('Deseja remover este registro?');">
                                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
