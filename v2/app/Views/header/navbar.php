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
<div class="dark-bg col-12 d-flex justify-content-between">
	<a href="<?= base_url($ROOT); ?>" class="navbar-brand">
		<i class="bi bi-house sizeB me-2"></i>
	</a>

	<?php if ($dt != []) { ?>
		<a href="<?= base_url("/meuseventos"); ?>" class="nav-link">
			<i class="bi bi-calendar-event sizeB ms-2"></i>
		</a>
		<div class="d-flex">
			<a href="<?= base_url("profile"); ?>" class="nav-link">
				<?= $dt['n_name']; ?>
			</a>
		</div>
	<?php } else { ?>
		<div class="d-flex">
			<a href="<?= base_url("signin"); ?>" class="nav-link">
				<i class="bi bi-person-circle sizeB ms-2"></i>
			</a>
		</div>
	<?php } ?>
</div>
