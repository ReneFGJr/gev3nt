<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">CRUD - Tabela event</h2>
        <a href="<?= base_url('admin/event/create') ?>" class="btn btn-success" title="Novo registro" aria-label="Novo registro">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path d="M8 0a.5.5 0 0 1 .5.5v7h7a.5.5 0 0 1 0 1h-7v7a.5.5 0 0 1-1 0v-7h-7a.5.5 0 0 1 0-1h7v-7A.5.5 0 0 1 8 0z"/>
            </svg>
        </a>
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
                                    <a href="<?= base_url('admin/event/view/' . ($item['id_e'] ?? 0)) ?>" class="btn btn-outline-secondary btn-sm" title="Visualizar" aria-label="Visualizar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/>
                                            <path d="M8 5.5A2.5 2.5 0 1 0 8 10a2.5 2.5 0 0 0 0-4.5zM8 9A1 1 0 1 1 8 7a1 1 0 0 1 0 2z"/>
                                        </svg>
                                    </a>
                                    <a href="<?= base_url('admin/event/edit/' . ($item['id_e'] ?? 0)) ?>" class="btn btn-primary btn-sm" title="Editar" aria-label="Editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                            <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 3 10.707V13h2.293l7.5-7.5z"/>
                                        </svg>
                                    </a>
                                    <form action="<?= base_url('admin/event/delete/' . ($item['id_e'] ?? 0)) ?>" method="post" onsubmit="return confirm('Deseja remover este registro?');">
                                        <button type="submit" class="btn btn-danger btn-sm" title="Excluir" aria-label="Excluir">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1 0-2H5.5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1H13.5a1 1 0 0 1 1 1zm-11 1v9a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4h-8zm3-3a.5.5 0 0 0-.5.5V2h4v-.5A.5.5 0 0 0 9 1h-3z"/>
                                            </svg>
                                        </button>
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
