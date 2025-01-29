<div class="container py-5">
	<h1 class="text-center mb-4 fw-bold">📅 Meus Eventos</h1>

	<!-- 🔵 Eventos Futuros -->
	<section class="mb-5">
		<h2 class="text-primary fw-bold"><i class="fa-solid fa-calendar-plus"></i> Eventos Futuros</h2>
		<div class="row g-4">
			<?php if (empty($futureEvents)): ?>
				<p class="text-muted">Nenhum evento futuro encontrado.</p>
			<?php else: ?>
				<?php foreach ($futureEvents as $event): ?>
					<div class="col-md-12 col-lg-12">
						<div class="card shadow-sm border-0">
							<div class="card-body rounded-3 border-secondary border-2">
								<h5 class="card-title text-primary fw-bold">
									<i class="fa-solid fa-calendar-check"></i> <?= esc($event['e_name']) ?>
								</h5>
								<p class="card-text">
									📆 <strong><?= esc($event['e_data_i']) ?> a <?= esc($event['e_data_f']) ?></strong><br>
									📍 <?= esc($event['e_cidade'] ?? 'Local não informado') ?>
								</p>
								<button class="btn btn-outline-primary btn-sm">
									<a href="<?=base_url('meuseventos');?>"><i class="fa-solid fa-info-circle"></i> Detalhes</a>
								</button>
								<?php if ($event['ein_pago'] == 1) { ?>
								<button class="btn btn-outline-primary btn-sm">
									<i class="fa-solid fa-info-circle"></i> INSCRIÇÂO PAGA
								</button>
								<?php } else { ?>
								<button class="btn btn-outline-danger btn-sm">
									<i class="fa-solid fa-info-circle"></i> PENDENTE PAGAMENTO
								</button>
								<?php } ?>

								<?php echo view('widget/icone_create', $event); ?>

							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</section>

	<!-- 🔴 Eventos Encerrados -->
	<section>
		<h2 class="text-danger fw-bold"><i class="fa-solid fa-calendar-xmark"></i> Eventos Encerrados</h2>
		<div class="row g-4">
			<?php if (empty($pastEvents)): ?>
				<p class="text-muted">Nenhum evento encerrado encontrado.</p>
			<?php else: ?>
				<?php foreach ($pastEvents as $event): ?>
					<div class="col-md-6 col-lg-4">
						<div class="card shadow-sm border-0 bg-light">
							<div class="card-body">
								<h5 class="card-title text-danger fw-bold">
									<i class="fa-solid fa-calendar-minus"></i> <?= esc($event['e_name']) ?>
								</h5>
								<p class="card-text">
									📆 <strong><?= esc($event['e_data_i']) ?> a <?= esc($event['e_data_f']) ?></strong><br>
									📍 <?= esc($event['e_cidade'] ?? 'Local não informado') ?>
								</p>
								<button class="btn btn-outline-danger btn-sm">
									<i class="fa-solid fa-eye"></i> Ver Certificado
								</button>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</section>

</div>
