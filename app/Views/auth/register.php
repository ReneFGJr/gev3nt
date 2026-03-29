<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container" style="max-width: 540px; margin: 60px auto; background: rgba(44,83,100,0.18); border-radius: 16px; box-shadow: 0 4px 18px rgba(44,83,100,0.13); padding: 38px 32px;">
    <h2 class="text-center mb-4" style="color:#90caf9; letter-spacing:1px;">Criar Conta</h2>
    <?php if (session('erro')): ?>
        <div class="alert alert-danger text-center" style="font-size:1.1rem;">
            <?= esc(session('erro')) ?>
        </div>
    <?php endif; ?>
    <form method="post" action="<?= base_url('auth/registrar') ?>">
        <fieldset class="mb-3 border rounded-3 p-3">
            <legend class="float-none w-auto px-2" style="font-size:1.1rem; color:#90caf9;">Dados Pessoais</legend>
            <div class="row g-3 align-items-center mb-2">
                <div class="col-md-8">
                    <label for="n_nome" class="form-label">Nome completo</label>
                    <input type="text" name="n_nome" id="n_nome" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="n_cracha" class="form-label">Crachá</label>
                    <input type="text" name="n_cracha" id="n_cracha" class="form-control">
                </div>
            </div>
            <div class="row g-3 align-items-center mb-2">
                <div class="col-md-6">
                    <label for="n_cpf" class="form-label">CPF</label>
                    <input type="text" name="n_cpf" id="n_cpf" maxlength="14" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="n_orcid" class="form-label">ORCID</label>
                    <input type="text" name="n_orcid" id="n_orcid" maxlength="19" placeholder="0000-0000-0000-0000" class="form-control">
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-3 border rounded-3 p-3">
            <legend class="float-none w-auto px-2" style="font-size:1.1rem; color:#90caf9;">Afiliação</legend>
            <div class="mb-3">
                <label for="n_afiliacao" class="form-label">Instituição (ROR)</label>
                <select name="n_afiliacao" id="n_afiliacao" class="form-select" required>
                    <option value="">Selecione...</option>
                    <?php if (isset($instituicoes) && is_array($instituicoes)): ?>
                        <?php foreach ($instituicoes as $inst): ?>
                            <option value="<?= esc($inst['id']) ?>"><?= esc($inst['nome']) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </fieldset>
        <fieldset class="mb-3 border rounded-3 p-3">
            <legend class="float-none w-auto px-2" style="font-size:1.1rem; color:#90caf9;">Acesso</legend>
            <div class="mb-3">
                <label for="n_email" class="form-label">E-mail</label>
                <input type="email" name="n_email" id="n_email" class="form-control" required>
            </div>
            <div class="row g-3 align-items-center mb-2">
                <div class="col-md-6">
                    <label for="n_password" class="form-label">Senha</label>
                    <input type="password" name="n_password" id="n_password" class="form-control" required minlength="6">
                </div>
                <div class="col-md-6">
                    <label for="n_password_confirm" class="form-label">Repetir senha</label>
                    <input type="password" name="n_password_confirm" id="n_password_confirm" class="form-control" required minlength="6">
                </div>
            </div>
        </fieldset>
        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" style="font-size:1.15rem; letter-spacing:1px; margin-top:8px;">Registrar</button>
    </form>
    <div class="mt-4 text-center">
        <a href="<?= base_url('auth/login') ?>" style="color:#90caf9; font-weight:500;">Já tenho conta</a>
    </div>
</div>
<?= $this->endSection() ?>
