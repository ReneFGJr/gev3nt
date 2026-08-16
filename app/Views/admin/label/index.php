<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <h2>Etiquetas Argox OS214</h2>

    <div class="d-flex justify-content-end mb-3">
        <a href="<?= base_url('admin/label/inport') ?>" class="btn btn-primary">Incluir etiquetas</a>
    </div>

    <?php if (session('success')): ?>
        <div class="alert alert-success"><?= session('success') ?></div>
    <?php endif; ?>
    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= session('error') ?></div>
    <?php endif; ?>

    <?php $filters = $filters ?? ['q' => '']; ?>
    <form method="get" action="<?= base_url('admin/label') ?>" class="row g-2 mb-3">
        <div class="col-md-9">
            <input type="text" class="form-control" name="q" placeholder="Buscar por nome ou instituição" value="<?= esc($filters['q'] ?? '') ?>">
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-outline-primary w-100">Buscar</button>
            <a href="<?= base_url('admin/label') ?>" class="btn btn-outline-secondary">Limpar</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Instituição</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($labels)): ?>
                    <tr>
                        <td colspan="4" class="text-center">Nenhuma etiqueta encontrada.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($labels as $label): ?>
                        <tr>
                            <td><?= esc($label['id_label']) ?></td>
                            <td>
                                <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                                    <span><?= esc($label['nome']) ?></span>
                                    <div class="d-flex align-items-center gap-2 ms-auto">
                                        <a href="<?= base_url('admin/label/print/' . $label['id_label']) ?>" class="btn btn-sm btn-outline-primary" title="Imprimir">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                                                <path d="M2 7a2 2 0 0 0-2 2v3a1 1 0 0 0 1 1h1v2a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-2h1a1 1 0 0 0 1-1V9a2 2 0 0 0-2-2H2zm11 2a.5.5 0 1 1 0 1 .5.5 0 0 1 0-1z"/>
                                                <path d="M11 0H5a1 1 0 0 0-1 1v4h8V1a1 1 0 0 0-1-1zM4 14v-3h8v3H4z"/>
                                            </svg>
                                        </a>
                                        <a href="<?= base_url('admin/label/edit/' . $label['id_label']) ?>" class="btn btn-sm btn-outline-secondary" title="Editar nome">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 3 10.707V13h2.293l7.5-7.5z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td><?= esc($label['instituicao']) ?></td>
                            <td>
                                <?php if ((int) $label['status'] === 1): ?>
                                    <span class="badge text-bg-success">Impresso</span>
                                <?php else: ?>
                                    <span class="badge text-bg-warning">Para imprimir</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>