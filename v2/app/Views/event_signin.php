<div class="row">
	<div class="col-sm-12">
		<h2 class="card-title text-center">Login de Usuário</h2>
		<hr>
		<form action="<?php echo base_url($url); ?>" method="post">
			<div class="mb-3">
				<label for="email" class="form-label small">Email</label>
				<input type="email" class="form-style" id="email" name="email" placeholder="Entre com seu e-mail" value="<?= get("email"); ?>" required>
				<?= ($check_email == 1) ? '<div class="alert alert-danger">E-mail já cadastrado - Recupere sua senha <a href="' . base_url('novasenha') . '">aqui</a>! </div>' : ''; ?>
			</div>
			<div class="mb-3">
				<label for="password" class="form-label small">Senha</label>
				<input type="password" class="form-style" id="password" name="password" placeholder="Sua senha" required>
			</div>
			<div class="text-center">
				<button type="submit" class="btn btn-primary w-100">Acessar</button>
			</div>
			<div class="mt-3">
				<a href="<?= base_url('novasenha'); ?>" class="link">Esqueceu a senha?</a> |
				<a href="<?= base_url('inscrever'); ?>" class="link">Não tem cadastro?</a>
			</div>
		</form>
	</div>
</div>
