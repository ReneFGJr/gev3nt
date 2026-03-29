<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div style="max-width: 480px; margin: 60px auto; background: rgba(44,83,100,0.18); border-radius: 16px; box-shadow: 0 4px 18px rgba(44,83,100,0.13); padding: 38px 32px;">
    <h2 style="text-align:center; color:#90caf9; margin-bottom: 28px; letter-spacing:1px;">Criar Conta</h2>
    <?php if (session('erro')): ?>
        <div style="background:#e57373; color:#fff; padding:12px 18px; border-radius:8px; margin-bottom:20px; text-align:center; font-size:1.1rem;">
            <?= esc(session('erro')) ?>
        </div>
    <?php endif; ?>
    <form method="post" action="<?= base_url('auth/registrar') ?>">
        <div style="display: flex; gap: 12px; margin-bottom: 18px;">
            <div style="flex:2;">
                <label for="n_nome" style="color:#fff; font-weight:500;">Nome completo</label>
                <input type="text" name="n_nome" id="n_nome" required style="width:100%; padding:10px; border-radius:6px; border:1px solid #b0bec5; margin-top:6px;">
            </div>
            <div style="flex:1;">
                <label for="n_cracha" style="color:#fff; font-weight:500;">Crachá</label>
                <input type="text" name="n_cracha" id="n_cracha" style="width:100%; padding:10px; border-radius:6px; border:1px solid #b0bec5; margin-top:6px;">
            </div>
        </div>
        <div style="margin-bottom: 18px;">
            <label for="n_email" style="color:#fff; font-weight:500;">E-mail</label>
            <input type="email" name="n_email" id="n_email" required style="width:100%; padding:10px; border-radius:6px; border:1px solid #b0bec5; margin-top:6px;">
        </div>
        <div style="display: flex; gap: 12px; margin-bottom: 18px;">
            <div style="flex:1;">
                <label for="n_cpf" style="color:#fff; font-weight:500;">CPF</label>
                <input type="text" name="n_cpf" id="n_cpf" maxlength="14" required style="width:100%; padding:10px; border-radius:6px; border:1px solid #b0bec5; margin-top:6px;">
            </div>
            <div style="flex:1;">
                <label for="n_orcid" style="color:#fff; font-weight:500;">ORCID</label>
                <input type="text" name="n_orcid" id="n_orcid" maxlength="19" placeholder="0000-0000-0000-0000" style="width:100%; padding:10px; border-radius:6px; border:1px solid #b0bec5; margin-top:6px;">
            </div>
        </div>
        <div style="margin-bottom: 18px;">
            <label for="n_afiliacao" style="color:#fff; font-weight:500;">Instituição (ROR)</label>
            <select name="n_afiliacao" id="n_afiliacao" required style="width:100%; padding:10px; border-radius:6px; border:1px solid #b0bec5; margin-top:6px;">
                <option value="">Selecione...</option>
                <?php if (isset($instituicoes) && is_array($instituicoes)): ?>
                    <?php foreach ($instituicoes as $inst): ?>
                        <option value="<?= esc($inst['id']) ?>"><?= esc($inst['nome']) ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div style="display: flex; gap: 12px; margin-bottom: 18px;">
            <div style="flex:1;">
                <label for="n_password" style="color:#fff; font-weight:500;">Senha</label>
                <input type="password" name="n_password" id="n_password" required minlength="6" style="width:100%; padding:10px; border-radius:6px; border:1px solid #b0bec5; margin-top:6px;">
            </div>
            <div style="flex:1;">
                <label for="n_password_confirm" style="color:#fff; font-weight:500;">Repetir senha</label>
                <input type="password" name="n_password_confirm" id="n_password_confirm" required minlength="6" style="width:100%; padding:10px; border-radius:6px; border:1px solid #b0bec5; margin-top:6px;">
            </div>
        </div>
        <button type="submit" style="width:100%; background:#1976d2; color:#fff; padding:14px 0; border:none; border-radius:8px; font-size:1.15rem; font-weight:600; letter-spacing:1px; margin-top:8px;">Registrar</button>
    </form>
    <div style="margin-top: 22px; text-align:center;">
        <a href="<?= base_url('auth/login') ?>" style="color:#90caf9; font-weight:500;">Já tenho conta</a>
    </div>
</div>
<?= $this->endSection() ?>
