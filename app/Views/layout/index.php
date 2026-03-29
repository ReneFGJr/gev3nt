<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-7 col-lg-6">
        <div class="card shadow-lg border-0" style="background: rgba(44,83,100,0.15); border-radius: 16px;">
            <div class="card-body p-5 text-center">
                <h1 class="mb-4" style="color:#90caf9; font-weight:700;">Bem-vindo ao Gev3nt</h1>
                <p class="lead mb-4" style="color:#f4f4f4;">Gerencie inscrições, eventos e participantes de forma simples, moderna e segura.</p>
                <div class="d-grid gap-3 col-8 mx-auto mt-4">
                    <a href="<?= base_url('auth/login') ?>" class="btn btn-primary btn-lg fw-bold" style="background:#1976d2; border:none;">Login</a>
                    <a href="<?= base_url('auth/registrar') ?>" class="btn btn-outline-info btn-lg fw-bold">Fazer novo cadastro</a>
                    <a href="<?= base_url('auth/recuperar-senha') ?>" class="btn btn-link text-info">Recuperar senha</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
