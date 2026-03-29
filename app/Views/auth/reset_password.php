<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="reset-bg">
    <div class="reset-card">
        <div class="icon text-center mb-2">
            <i class="bi bi-shield-lock"></i>
        </div>
        <h2 class="text-center mb-4" style="color:#90caf9; font-weight:700; letter-spacing:1px;">Nova Senha</h2>
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
        <form method="post" action="<?= base_url('auth/resetar-senha') ?>">
            <input type="hidden" name="token" value="<?= esc($token) ?>">
            <div class="mb-3">
                <label for="n_password" class="form-label">Nova senha</label>
                <input type="password" name="n_password" id="n_password" class="form-control" required autofocus>
            </div>
            <div class="mb-4">
                <label for="n_password_confirm" class="form-label">Confirme a nova senha</label>
                <input type="password" name="n_password_confirm" id="n_password_confirm" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-2">Redefinir senha</button>
        </form>
        <div class="mt-3 text-center">
            <a href="<?= base_url('auth/login') ?>" style="color:#90caf9; font-weight:500;">Voltar ao login</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
