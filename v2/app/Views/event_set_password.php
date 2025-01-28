<div class="row">
	<div class="col-sm-12">
		<h2 class="card-title text-center">Reenvio de Senha</h2>
		<hr>

		<form action="<?= base_url($url); ?>" method="post">
			<input type="hidden" name="email" value="<?= $n_email; ?>">
			<div class="mb-3">
				<label for="nome" class="form-label small">Nome completo</label>
				<div class="full fw-bold"><?= $n_nome; ?></div>
			</div>

			<div class="mb-3">
				<label for="cpf" class="form-label small">CPF</label>
				<div class="full fw-bold"><?= $n_cpf; ?></div>
			</div>

			<div class="mb-3">
				<label for="email" class="form-label small">e-mail</label>
				<div class="full fw-bold"><?= $n_email; ?></div>
			</div>

			<div class="mb-3">
				<label for="pass1" class="form-label small">Nova senha</label>
				<input type="password" class="form-control" id="pass1" name="pass1" placeholder="Informe nova senha" maxlength="11" value="<?= get('pass1'); ?>" <?= (get('extrangeiro') == 1) ? 'disabled' : ''; ?> required>
			</div>
			<div class="mb-3">
				<label for="pass1" class="form-label small">Repita a nova senha</label>
				<input type="password" class="form-control" id="pass2" name="pass2" placeholder="reinforme nova senha" maxlength="11" value="<?= get('pass2'); ?>" <?= (get('extrangeiro') == 1) ? 'disabled' : ''; ?> required>
				<?= ($check_password == 1) ? '<div class="alert alert-success mt-2">E-mail localizado</div>' : ''; ?>
				<?= ($check_password == 2) ? '<div class="alert alert-danger mt-2">E-mail NÂO localizado</div>' : ''; ?>
			</div>
			<div class="text-center">
				<button type="submit" class="btn btn-primary w-100">Salvar nova senha</button>
			</div>

			<div class="mt-3">
				<a href="<?= base_url('signup'); ?>" class="link">Não tem cadastro?</a> |
				<a href="<?= base_url('signin'); ?>" class="link">Fazer login</a>
			</div>
		</form>
	</div>
</div>
