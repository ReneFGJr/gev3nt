<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="forgot-bg">
    <div class="forgot-card">
        <div class="icon text-center mb-2">
            <i class="bi bi-envelope-paper"></i>
        </div>
        <h2 class="text-center mb-4" style="color:#90caf9; font-weight:700; letter-spacing:1px;">Recuperar Senha</h2>
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
        <form method="post" action="<?= base_url('auth/recuperar-senha') ?>">
            <div class="mb-4">
                <label for="n_email" class="form-label">E-mail cadastrado</label>
                <input type="email" name="n_email" id="n_email" class="form-control" required autofocus>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-2">Enviar link de recuperação</button>
        </form>
        <div class="mt-3 text-center">
            <a href="<?= base_url('auth/login') ?>" style="color:#90caf9; font-weight:500;">Voltar ao login</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
