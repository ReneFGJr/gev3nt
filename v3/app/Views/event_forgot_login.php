<div class="row">
	<div class="col-sm-12">
		<h2 class="card-title text-center">Reenvio de Senha</h2>
		<hr>
		<form action="<?= base_url($url); ?>" method="post">
			<div class="mb-3">
				<label for="cpf" class="form-label small">CPF</label>
				<input type="text" class="form-control" id="cpf" name="cpf" placeholder="Informe seu CPF" maxlength="11" value="<?= get('cpf'); ?>" <?= (get('extrangeiro') == 1) ? 'disabled' : ''; ?> required>
				<?= ($check_cpf == 1) ? '<div class="alert alert-success mt-2">CPF ok</div>' : ''; ?>
				<?= ($check_cpf == 9) ? '<div class="alert alert-danger mt-2">CPF Inválido</div>' : ''; ?>
				<div class="form-check mt-2">
					<input type="checkbox" class="form-check-input" id="extrangeiro" name="extrangeiro" value="1" onclick="fieldCpfToggle()" <?= (get('extrangeiro') == 1) ? 'checked' : ''; ?>>
					<label for="extrangeiro" class="form-check-label small">Sou estrangeiro</label>
				</div>
			</div>
			<div class="mb-3">
				<label for="email" class="form-label small">Email</label>
				<input type="email" class="form-control" id="email" name="email" placeholder="Entre com seu e-mail" value="<?= get('email'); ?>" required>
				<?= ($check_email == 1) ? '<div class="alert alert-success mt-2">E-mail localizado</div>' : ''; ?>
				<?= ($check_email == 2) ? '<div class="alert alert-danger mt-2">E-mail NÂO localizado</div>' : ''; ?>
			</div>
			<div class="text-center">
				<button type="submit" class="btn btn-primary w-100">Enviar nova senha</button>
			</div>

			<div class="mt-3">
				<a href="<?= base_url('signup'); ?>" class="link">Não tem cadastro?</a> |
				<a href="<?= base_url('signin'); ?>" class="link">Fazer login</a>
			</div>
		</form>
	</div>
</div>

<script>
	function fieldCpfToggle() {
		const cpfField = document.getElementById('cpf');
		const isChecked = document.getElementById('extrangeiro').checked;

		if (isChecked) {
			cpfField.setAttribute('disabled', 'disabled');
			cpfField.value = 'Estrangeiro';
		} else {
			cpfField.removeAttribute('disabled');
			cpfField.value = '';
		}
	}
</script>
