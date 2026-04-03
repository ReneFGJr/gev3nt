<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <h2>Eventos</h2>
    <a href="/admin/events/create" class="btn btn-primary mb-3">Novo Evento</a>
    <?php if (session('success')): ?>
        <div class="alert alert-success"><?= session('success') ?></div>
    <?php endif; ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Data Inicial</th>
                    <th>Data Final</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?= esc($event['id_e']) ?></td>
                        <td><?= esc($event['e_name']) ?></td>
                        <td><?= esc($event['e_data_i']) ?></td>
                        <td><?= esc($event['e_data_f']) ?></td>
                        <td>
                            <a href="/admin/events/view/<?= esc($event['id_e']) ?>" title="Visualizar" class="btn btn-sm btn-outline-secondary me-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/>
                                    <path d="M8 5.5A2.5 2.5 0 1 0 8 10a2.5 2.5 0 0 0 0-4.5zM8 9A1 1 0 1 1 8 7a1 1 0 0 1 0 2z"/>
                                </svg>
                            </a>
                            <a href="/admin/events/edit/<?= esc($event['id_e']) ?>" title="Editar" class="btn btn-sm btn-outline-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 3 10.707V13h2.293l7.5-7.5z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
