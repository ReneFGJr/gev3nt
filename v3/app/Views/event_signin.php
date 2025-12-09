<div class="row">
	<div class="col-sm-12">
		<h2 class="card-title text-center">Login de Usuário</h2>
		<hr>
		<form action="<?php echo base_url($url); ?>" method="post">
			<div class="mb-3">
				<label for="email" class="form-label small">Email</label>
				<input type="email" class="form-style" id="email" name="email" placeholder="Entre com seu e-mail" value="<?= get("email"); ?>" required>
				<?= ($check_email == 1) ? '<div class="alert alert-success mt-2">E-mail localizado</div>' : ''; ?>
			</div>
			<div class="mb-3">
				<label for="password" class="form-label small">Senha</label>
				<input type="password" class="form-style" id="password" name="password" value="<?= get("password"); ?>" placeholder="Sua senha" required>
				<?= ($check_password == 2) ? '<div class="alert alert-danger mt-2">Senha inválida - clique <a href="' . base_url('novasenha') . '">aqui</a> para recuperar a senha.</div>' : ''; ?>
				<?= ($check_password == -1) ? '<div class="alert alert-danger mt-2">Usuário não localizado</div>' : ''; ?>
			</div>

			<br />

			<div class="text-center">
				<button type="submit" class="btn btn-primary w-100">Acessar</button>
			</div>
			<div class="mt-3">
				<a href="<?= base_url('novasenha'); ?>" class="link">Esqueceu a senha?</a> |
				<a href="<?= base_url('signup'); ?>" class="link">Não tem cadastro?</a>
			</div>
		</form>
	</div>
</div>
