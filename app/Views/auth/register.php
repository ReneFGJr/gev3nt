<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<?php
$step = $step ?? 'check_email';
$checkedEmail = $checkedEmail ?? '';
$formData = $formData ?? [];
$erroMsg = $erro ?? session('erro');
$sucessoMsg = session('sucesso');
?>
<div class="login-bg">
    <div class="login-card shadow-lg border-0">
        <div class="text-center mb-3">
            <span class="d-inline-block bg-info bg-gradient rounded-circle p-3 mb-2">
                <i class="bi bi-person-plus fs-1 text-white"></i>
            </span>
            <h2 class="mb-2 fw-bold" style="color:#90caf9; letter-spacing:1px;">Criar Conta</h2>
            <p class="text-secondary mb-4" style="color:#b0bec5;">Informe seu e-mail para iniciar o cadastro</p>
        </div>
        <?php if ($erroMsg): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= esc($erroMsg) ?>
            </div>
        <?php endif; ?>
        <?php if ($sucessoMsg): ?>
            <div class="alert alert-success text-center" role="alert">
                <?= esc($sucessoMsg) ?>
            </div>
        <?php endif; ?>

        <?php if ($step === 'check_email'): ?>
            <form method="post" action="<?= base_url('auth/registrar') ?>">
                <input type="hidden" name="mode" value="check_email">
                <div class="mb-3">
                    <label for="n_email" class="form-label">E-mail <span class="text-danger">*</span></label>
                    <input type="email" name="n_email" id="n_email" class="form-control" value="<?= esc($checkedEmail) ?>" required>
                </div>
                <button type="submit" class="btn btn-info w-100 fw-bold py-2 my-4">Continuar</button>
            </form>
        <?php elseif ($step === 'email_exists'): ?>
            <div class="text-center">
                <p class="mb-3">O e-mail <strong><?= esc($checkedEmail) ?></strong> ja possui cadastro.</p>
                <div class="d-flex gap-2 justify-content-center flex-wrap">
                    <a href="<?= base_url('auth/login') ?>" class="btn btn-primary">Fazer login</a>
                    <a href="<?= base_url('auth/recuperar-senha') ?>" class="btn btn-outline-warning">Recuperar senha</a>
                    <a href="<?= base_url('auth/registrar') ?>" class="btn btn-outline-secondary">Usar outro e-mail</a>
                </div>
            </div>
        <?php else: ?>
            <form method="post" action="<?= base_url('auth/registrar') ?>" onsubmit="return validarSenhaCadastro();">
                <input type="hidden" name="mode" value="complete_register">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="n_nome" class="form-label">Nome completo <span class="text-danger">*</span></label>
                        <input type="text" name="n_nome" id="n_nome" class="form-control" value="<?= esc($formData['n_nome'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="n_email" class="form-label">E-mail <span class="text-danger">*</span></label>
                        <input type="email" name="n_email" id="n_email" class="form-control" value="<?= esc($checkedEmail) ?>" readonly required>
                    </div>
                    <div class="col-md-6">
                        <label for="n_cracha" class="form-label">Nome para crachá</label>
                        <input type="text" name="n_cracha" id="n_cracha" class="form-control" value="<?= esc($formData['n_cracha'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="n_cpf" class="form-label">CPF <span class="text-danger">*</span></label>
                        <input type="text" name="n_cpf" id="n_cpf" class="form-control" value="<?= esc($formData['n_cpf'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="n_orcid" class="form-label">ORCID</label>
                        <input type="text" name="n_orcid" id="n_orcid" class="form-control" value="<?= esc($formData['n_orcid'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="n_afiliacao" class="form-label">Instituição/Afiliação <span class="text-danger">*</span></label>
                        <select name="n_afiliacao" id="n_afiliacao" class="form-select" required>
                            <option value="">Selecione...</option>
                            <?php if (isset($instituicoes) && is_array($instituicoes)): ?>
                                <?php foreach ($instituicoes as $inst): ?>
                                    <option value="<?= esc($inst['nome']) ?>" <?= (($formData['n_afiliacao'] ?? '') === $inst['nome']) ? 'selected' : '' ?>><?= esc($inst['nome']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="n_password" class="form-label">Senha <span class="text-danger">*</span></label>
                        <input type="password" name="n_password" id="n_password" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="n_password_confirm" class="form-label">Confirme a senha <span class="text-danger">*</span></label>
                        <input type="password" name="n_password_confirm" id="n_password_confirm" class="form-control" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-info w-100 fw-bold py-2 my-4">Cadastrar</button>
                <a href="<?= base_url('auth/registrar') ?>" class="btn btn-outline-secondary w-100">Trocar e-mail</a>
            </form>
        <?php endif; ?>

        <script>
        function validarSenhaCadastro() {
            var senhaInput = document.getElementById('n_password');
            var senha2Input = document.getElementById('n_password_confirm');
            if (!senhaInput || !senha2Input) {
                return true;
            }

            var senha = document.getElementById('n_password').value;
            var senha2 = document.getElementById('n_password_confirm').value;
            if (senha !== senha2) {
                alert('As senhas não conferem!');
                return false;
            }
            return true;
        }
        </script>
        <div class="d-flex justify-content-between align-items-center mt-2">
            <a href="<?= base_url('auth/login') ?>" class="link-info">Já tenho conta</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
