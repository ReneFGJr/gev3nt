<div class="container mt-5">
	<!-- Header do Evento -->
	<div class="row align-items-center mb-4 p-3 bg-light rounded shadow-sm">
		<div class="col-auto">
			<img src="<?= $event['e_logo']; ?>" alt="<?= $event['e_name']; ?>" class="img-fluid rounded" style="max-height: 80px;">
		</div>
		<div class="col">
			<h1 class="h5 mb-1"><?= $event['e_name']; ?></h1>
			<p class="text-muted mb-1"><?= $event['e_description']; ?></p>
			<a href="<?= $event['e_url']; ?>" target="_blank" class="text-decoration-none text-primary small">Site do evento</a>
		</div>
		<div class="col-auto text-end">
			<p class="small text-muted mb-0">Inscrições até:</p>
			<p class="fw-bold mb-0"><?= date('d/m/Y', strtotime($event['e_sigin_until'])); ?></p>
		</div>
	</div>
</div>
