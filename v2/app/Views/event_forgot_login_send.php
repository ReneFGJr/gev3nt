<div class="row">
	<div class="col-sm-12">
		<h2 class="card-title text-center">Reenvio de Senha</h2>
		<hr>
		<p>Foi enviado um <e-mail class="fw-bold"><?= get("email"); ?></e-mail> para você com as instruções para redefinir sua senha.</p>
		<p>Por favor, verifique sua caixa de entrada e siga as instruções.</p>
		<p><a href="<?= base_url("signin"); ?>" class="btn btn-primary">Voltar para o login</a></p>
	</div>
	<div class="mt-3">
		<a href="<?= base_url('signup'); ?>" class="link">Não tem cadastro?</a> |
		<a href="<?= base_url('signin'); ?>" class="link">Fazer login</a> |
		<a href="<?= $link; ?>" class="link">TT</a>
	</div>
</div>
