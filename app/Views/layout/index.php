<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-6 col-lg-6">
        <h1>Emissão de Certificados</h1>
        <p>Em breve, esta seção permitirá que os organizadores de eventos emitam certificados personalizados para os participantes. Fique atento para mais novidades!</p>
    </div>
    <div class="col-md-12">
        <div class="card shadow-lg border-0" style="background: rgba(44,83,100,0.15); border-radius: 16px;">
            <div class="card-body p-2 text-center">
                <h1 class="mb-4" style="color:#90caf9; font-weight:700;">Bem-vindo ao Gev3nt</h1>
                <p class="lead mb-4" style="color:#f4f4f4;">Gerencie inscrições, eventos e participantes de forma simples, moderna e segura.</p>
                <?php if (!session('usuario')): ?>
                    <div class="d-grid gap-3 col-8 mx-auto mt-4">
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($certificados as $cert): ?>
                                            <tr>
                                                <td class="text-start"><?= esc($cert['e_name'] ?? '-') ?></td>
                                                <td><?= esc($cert['i_titulo_trabalho'] ?? '-') ?></td>
                                                <td><?= esc($cert['i_status'] == 1 ? 'Emitido' : 'Pendente') ?></td>
                                                <td><a href="#" class="btn btn-success btn-sm">Imprimir</a></td>
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
<?= $this->endSection() ?>