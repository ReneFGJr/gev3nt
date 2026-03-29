<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="login-bg">
    <div class="login-card shadow-lg border-0">
        <div class="text-center mb-3">
            <span class="d-inline-block bg-info bg-gradient rounded-circle p-3 mb-2">
                <i class="bi bi-person-plus fs-1 text-white"></i>
            </span>
            <h2 class="mb-2 fw-bold" style="color:#90caf9; letter-spacing:1px;">Criar Conta</h2>
            <p class="text-secondary mb-4" style="color:#b0bec5;">Preencha os dados para se cadastrar</p>
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
        <form method="post" action="<?= base_url('auth/registrar') ?>" onsubmit="return validarSenhaCadastro();">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="n_nome" class="form-label">Nome completo <span class="text-danger">*</span></label>
                    <input type="text" name="n_nome" id="n_nome" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="n_email" class="form-label">E-mail <span class="text-danger">*</span></label>
                    <input type="email" name="n_email" id="n_email" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="n_cracha" class="form-label">Nome para crachá</label>
                    <input type="text" name="n_cracha" id="n_cracha" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="n_cpf" class="form-label">CPF <span class="text-danger">*</span></label>
                    <input type="text" name="n_cpf" id="n_cpf" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="n_orcid" class="form-label">ORCID</label>
                    <input type="text" name="n_orcid" id="n_orcid" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="n_afiliacao" class="form-label">Instituição/Afiliação <span class="text-danger">*</span></label>
                    <select name="n_afiliacao" id="n_afiliacao" class="form-select" required>
                        <option value="">Selecione...</option>
                        <?php if (isset($instituicoes) && is_array($instituicoes)): ?>
                            <?php foreach ($instituicoes as $inst): ?>
                                <option value="<?= esc($inst['nome']) ?>"><?= esc($inst['nome']) ?></option>
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
        </form>
        <script>
        function validarSenhaCadastro() {
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
