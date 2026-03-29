<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div style="max-width: 400px; margin: 60px auto; background: rgba(44,83,100,0.15); border-radius: 12px; box-shadow: 0 2px 12px rgba(44,83,100,0.10); padding: 32px 28px;">
    <h2 style="text-align:center; color:#90caf9; margin-bottom: 24px;">Login</h2>
    <?php if (session('erro')): ?>
        <div style="background:#e57373; color:#fff; padding:10px 16px; border-radius:6px; margin-bottom:18px; text-align:center;">
            <?= esc(session('erro')) ?>
        </div>
    <?php endif; ?>
    <form method="post" action="<?= base_url('auth/login') ?>">
        <div style="margin-bottom: 18px;">
            <label for="email" style="color:#fff; font-weight:500;">E-mail</label>
            <input type="email" name="email" id="email" required style="width:100%; padding:10px; border-radius:6px; border:1px solid #b0bec5; margin-top:6px;">
        </div>
        <div style="margin-bottom: 24px;">
            <label for="senha" style="color:#fff; font-weight:500;">Senha</label>
            <input type="password" name="senha" id="senha" required style="width:100%; padding:10px; border-radius:6px; border:1px solid #b0bec5; margin-top:6px;">
        </div>
        <button type="submit" style="width:100%; background:#1976d2; color:#fff; padding:12px 0; border:none; border-radius:6px; font-size:1.1rem; font-weight:600;">Entrar</button>
    </form>
    <div style="margin-top: 18px; text-align:center;">
        <a href="<?= base_url('auth/registrar') ?>" style="color:#90caf9; font-weight:500; margin-right: 18px;">Criar conta</a>
        <a href="<?= base_url('auth/recuperar-senha') ?>" style="color:#90caf9; font-weight:500;">Esqueci a senha</a>
    </div>
</div>
<?= $this->endSection() ?>
