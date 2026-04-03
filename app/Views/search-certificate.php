<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="content shadow border-0">
                <div class="row text-center">
                    <h2 class="mb-4">Busca de Certificado</h2>
                    <?php if (!empty($query)): ?>
                        <div class="alert alert-info">Resultado da busca para: <strong><?= esc($query) ?></strong></div>
                        <?php if (!empty($nome)): ?>
                            <div class="mb-2">Nome encontrado: <strong><?= esc($nome) ?></strong></div>
                        <?php endif; ?>
                        <?php if (!empty($email)): ?>
                            <div class="mb-2">E-mail: <strong><?= esc($email) ?></strong></div>
                        <?php endif; ?>
                        <?php if (!empty($certificados)): ?>
                            <div class="table-responsive mt-4">
                                <table class="table table-striped table-bordered align-middle bg-white">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Evento</th>
                                            <th>Ano</th>
                                            <th>Título do Trabalho</th>
                                            <th>Status</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($certificados as $cert): ?>
                                            <tr>
                                                <td><?= esc($cert['e_name'] ?? '-') ?></td>
                                                <td><?= esc(!empty($cert['e_data']) ? date('Y', strtotime($cert['e_data'])) : '-') ?></td>
                                                <td><?= esc($cert['i_titulo_trabalho'] ?? '-') ?></td>
                                                <td><?= esc($cert['i_status'] == 1 ? 'Emitido' : 'Pendente') ?></td>
                                                <td><a href="<?= base_url('certificados/imprimir/' . $cert['id_i']) ?>" target="_blank" class="btn btn-success btn-sm">Imprimir</a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning mt-4">Nenhum certificado encontrado para o termo informado.</div>
                        <?php endif; ?>
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