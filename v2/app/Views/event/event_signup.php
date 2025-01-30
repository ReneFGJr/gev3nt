<div class="row">
	<div class="col-sm-12">
		<h2 class="card-title text-center">Registro de Usuário</h2>
		<hr>
		<form action="<?php echo base_url($url); ?>" method="post">
			<div class="mb-3">
				<label for="fullName" class="form-label small">Nome completo</label>
				<input type="text" class="form-style" id="fullName" name="name" placeholder="Entre com seu nome completo" value="<?= get("name"); ?>" required>
			</div>
			<div class="mb-3">
				<label for="cpf" class="form-label small">CPF</label>
				<input type="text" class="form-style" id="cpf" name="cpf" placeholder="Informe seu CPF" maxlength="11" value="<?= get("cpf"); ?>" required>
				<?= ($check_cpf == 1) ? '<div class="alert alert-danger">E-mail já cadastrado</div>' : ''; ?>
				<?= ($check_cpf == 9) ? '<div class="alert alert-danger">E-mail já cadastrado</div>' : ''; ?>
				<div class="form-check mt-2">
					<input type="checkbox" class="form-check-input" id="extrangeiro" name="extrangeiro" value="1" onclick="fieldCpfToggle()" <?= (get('extrangeiro') == 1) ? 'checked' : ''; ?>>
					<label for="extrangeiro" class="form-check-label small">Sou estrangeiro</label>
				</div>
			</div>
			<div class="mb-3">
				<label for="email" class="form-label small">Email</label>
				<input type="email" class="form-style" id="email" name="email" placeholder="Entre com seu e-mail" value="<?= get("email"); ?>" required>
				<?= ($check_email == 1) ? '<div class="alert alert-danger">E-mail já cadastrado - Recupere sua senha <a href="' . base_url('novasenha') . '">aqui</a>! </div>' : ''; ?>
			</div>
			<div class="mb-3">
				<label for="badgeName" class="form-label small">Name para o crachá (até 20 caracteres)</label>
				<input type="text" class="form-style" id="badgeName" name="badge_name" value="<?= get("badge_name"); ?>" placeholder="Enter name for badge (max 20 characters)" maxlength="20" required>
			</div>
			<div class="mb-3">
				<label for="institution" class="form-label small">Instituição de afiliação</label>
				<select name="institution" class="form-style">
					<?php
					foreach ($corporateBoard as $id => $line) {

						echo '<option value="' . $line['id_cb'] . '" >' . $line['cb_nome'] . '</option>';
					}
					?>
				</select>
			</div>
			<div class="text-center">
				<button type="submit" class="btn btn-primary w-100">Registrar-se</button>
			</div>

			<div class="mt-3">
				<a href="<?= base_url('novasenha'); ?>" class="link">Esqueceu a senha?</a> |
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
