<?= $this->extend('layout/header') ?>
<?= $this->section('styles') ?>
<style>
    .certificate-search-group .form-control,
    .certificate-search-group .btn {
        min-height: 52px;
    }

    @media (max-width: 767.98px) {
        .certificate-search-group {
            display: grid;
            gap: .75rem;
        }

        .certificate-search-group .btn {
            width: 100%;
        }
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container py-4 py-md-5">
    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <h1 class="mb-3">Emissão de Certificados</h1>
            <form action="<?= base_url('search-certificate'); ?>" method="get" class="mb-4">
                <div class="input-group certificate-search-group">
                    <input type="text" name="query" class="form-control form-control-lg" placeholder="Digite seu nome completo ou e-mail" required>
                    <button class="btn btn-primary btn-lg" type="submit">Buscar Certificado</button>
                </div>
            </form>
            <p>Digite seu nome completo ou e-mail para buscar seus certificados.</p>
        </div>
        <div class="col-12">
            <div class="card shadow-lg border-0" style="background: rgba(44,83,100,0.15); border-radius: 16px;">
                <div class="card-body p-3 p-md-4 text-center">
                    <?php if (!session('usuario')): ?>
                        <div class="d-grid gap-3 col-12 col-sm-10 col-md-8 col-lg-5 mx-auto mt-2 mt-md-3">
                            <a href="<?= base_url('auth/login') ?>" class="btn btn-primary btn-lg fw-bold" style="background:#1976d2; border:none;">Login</a>
                            <a href="<?= base_url('auth/registrar') ?>" class="btn btn-outline-info btn-lg fw-bold">Fazer novo cadastro</a>
                            <a href="<?= base_url('auth/recuperar-senha') ?>" class="btn btn-link text-info">Recuperar senha</a>
                        </div>
                    <?php else: ?>
                        <div class="mt-4">
                            <h4 class="mb-3" style="color:#90caf9;">Meus Certificados</h4>
                            <?php if (empty($certificados)): ?>
                                <div class="alert alert-info text-start" role="alert">
                                    <i class="bi bi-award me-2"></i> Nenhum certificado disponível no momento.<br>
                                    Assim que você participar de eventos, seus certificados aparecerão aqui para download.
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered align-middle bg-white">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Evento</th>
                                                <th>Título do Trabalho</th>
                                                <th>Autores</th>
                                                <th>Status</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($certificados as $cert): ?>
                                                <tr>
                                                    <td class="text-start"><?= esc($cert['e_name'] ?? '-') ?></td>
                                                    <td><?= esc($cert['i_titulo_trabalho'] ?? '-') ?></td>
                                                    <td class="text-start"><?= esc($cert['i_autores'] ?? '-') ?></td>
                                                    <td><?= esc(($cert['i_status'] ?? 0) == 1 ? 'Emitido' : 'Pendente') ?></td>
                                                    <td class="text-nowrap"><a href="<?= base_url('certificados/imprimir/' . $cert['id_i']) ?>" target="_blank" class="btn btn-success btn-sm">Imprimir</a></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>