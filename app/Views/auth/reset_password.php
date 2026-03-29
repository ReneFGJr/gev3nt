<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<style>
    .reset-bg {
        min-height: 100vh;
        background: linear-gradient(135deg, #1976d2 0%, #0f2027 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .reset-card {
        background: rgba(44,83,100,0.18);
        border-radius: 22px;
        box-shadow: 0 8px 32px 0 rgba(31,38,135,0.18);
        border: 1px solid rgba(255,255,255,0.08);
        padding: 2.5rem 2rem 2rem 2rem;
        max-width: 400px;
        width: 100%;
        position: relative;
        overflow: hidden;
    }
    .reset-card .icon {
        font-size: 2.5rem;
        color: #90caf9;
        margin-bottom: 0.5rem;
    }
    .reset-card .form-label {
        color: #e3f2fd;
        font-weight: 500;
    }
    .reset-card .form-control {
        background: rgba(255,255,255,0.08);
        color: #fff;
        border: 1px solid #b0bec5;
    }
    .reset-card .form-control:focus {
        border-color: #1976d2;
        box-shadow: 0 0 0 0.2rem rgba(25,118,210,0.15);
    }
    .reset-card .btn-primary {
        background: linear-gradient(90deg, #1976d2 60%, #64b5f6 100%);
        border: none;
        font-weight: 600;
        letter-spacing: 1px;
        box-shadow: 0 2px 8px rgba(25,118,210,0.10);
    }
    .reset-card .btn-primary:hover {
        background: linear-gradient(90deg, #1565c0 60%, #1976d2 100%);
    }
</style>
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
