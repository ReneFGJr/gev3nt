<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-3">
                <span class="d-inline-block bg-primary bg-gradient rounded-circle p-3 mb-2">
                    <i class="bi bi-person-circle fs-1 text-white"></i>
                </span>
                <h2 class="mb-2 fw-bold" style="color:#90caf9; letter-spacing:1px;">Login</h2>
                <p class="text-secondary mb-4" style="color:#b0bec5;">Acesse sua conta para continuar</p>
            </div>
            <?php if (session('erro')): ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?= esc(session('erro')) ?>
                </div>
            <?php endif; ?>
            <?php if (session('sucesso')): ?>
                <div class="alert alert-success text-center" role="alert">
                    <?= esc(session('sucesso')) ?>
                </div>
            <?php endif; ?>
            <form method="post" action="<?= base_url('auth/login') ?>" class="mb-3">
                <div class="mb-3 text-start">
                    <label for="n_email" class="form-label">E-mail</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-envelope text-primary"></i></span>
                        <input type="email" name="n_email" id="n_email" class="form-control border-start-0" required autofocus placeholder="Digite seu e-mail">
                    </div>
                </div>
                <div class="mb-4 text-start">
                    <label for="n_password" class="form-label">Senha</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-lock text-primary"></i></span>
                        <input type="password" name="n_password" id="n_password" class="form-control border-start-0" required placeholder="Digite sua senha">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mb-2">Entrar</button>
            </form>
            <div class="d-flex justify-content-between align-items-center mt-2">
                <a href="<?= base_url('auth/registrar') ?>" class="link-info">Criar conta</a>
                <a href="<?= base_url('auth/recuperar-senha') ?>" class="link-info">Esqueci a senha</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>