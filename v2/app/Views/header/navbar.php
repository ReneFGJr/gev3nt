<?php
$Users = new \App\Models\User\Users();
$data = $Users->getCookie();
if ($data != []) {
	$dt = $data;
	$ROOT = '/main';
} else {
	$ROOT = '/';
	$dt = [];
}
?>
<div class="dark-bg col-12 d-flex align-items-center">
	<!-- Ícones alinhados à esquerda -->
	<div class="d-flex">
		<a href="<?= base_url('/'); ?>" class="navbar-brand" title="Página inicial">
			<i class="bi bi-house sizeB me-5"></i>
		</a>

		<?php if ($dt != []) { ?>
			<a href="<?= base_url($ROOT); ?>" class="navbar-brand" title="Meus eventos">
				<i class="bi bi-calendar-week sizeB me-5"></i>
			</a>

			<a href="<?= base_url("/meuseventos"); ?>" class="nav-link" title="Programação Próximo evento">
				<i class="bi bi-calendar-event sizeB me-5"></i>
			</a>
		<?php } ?>
	</div>

	<!-- Ícone de login ou nome do usuário alinhado à direita -->
	<div class="ms-auto">
		<?php if ($dt != []) { ?>
			<a href="<?= base_url("profile"); ?>" class="nav-link">
				<?= $dt['n_name']; ?>
			</a>
		<?php } else { ?>
			<a href="<?= base_url("signin"); ?>" class="nav-link">
				<i class="bi bi-person-circle sizeB ms-2"></i>
			</a>
		<?php } ?>
	</div>
</div>
