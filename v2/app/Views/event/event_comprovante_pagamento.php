<div class="container mt-5">
	<div class="row justify-content-center">
		<div class="col-md-12">

			<!-- Detalhes da Inscrição -->
			<div class="card shadow-sm border-0 mb-4">
				<div class="card-body">
					<h5 class="card-title text-primary fw-bold">
						<i class="fa-solid fa-calendar-check"></i> <?= esc($subscribe['e_name']) ?>
					</h5>
					<p class="card-text">
						📆 <strong><?= esc($subscribe['e_data_i']) ?> a <?= esc($subscribe['e_data_f']) ?></strong><br>
						📍 <?= esc($subscribe['e_cidade'] ?? 'Local não informado') ?>
					</p>
				</div>
			</div>

			<div class="card shadow-sm border-0 mb-4">
				<div class="card-body">
					<h6 class="card-title text-primary fw-bold">
						Tipo de inscrição: <?= esc($subscribe['ei_modalidade']) ?>
					</h6>
					<p class="card-text">
						<strong class="text-success fs-5">R$ <?= esc(number_format($subscribe['ei_preco'], 2, ',', '.')); ?></strong><br>
					</p>
					<p class="text-danger fw-bold">📆 Data limite para pagamento: <?= esc($subscribe['ei_data_final']); ?></p>
				</div>
			</div>

			<!-- Mensagens de Sucesso ou Erro -->
			<?php if (session()->getFlashdata('success')) : ?>
				<div class="alert alert-success" role="alert">
					<i class="fa-solid fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
				</div>
			<?php endif; ?>
			<?php if (session()->getFlashdata('error')) : ?>
				<div class="alert alert-danger" role="alert">
					<i class="fa-solid fa-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
				</div>
			<?php endif; ?>

			<!-- Formulário de Upload -->
			<div class="card shadow-sm border-0">
				<div class="card-body">
					<h4 class="text-primary fw-bold mb-3">Envio de Comprovante de Pagamento</h4>
					<form action="<?= base_url('payment/'. $subscribe['id_ein'].'/upload') ?>" method="post" enctype="multipart/form-data">
						<?= csrf_field() ?>
						<div class="mb-3">
							<label for="payment_proof" class="form-label fw-bold">Selecione o comprovante (PDF, PNG, JPG):</label>
							<input type="file" class="form-control" name="payment_proof" id="payment_proof" required>
						</div>
						<button type="submit" class="btn btn-primary w-100">
							<i class="fa-solid fa-upload"></i> Enviar Comprovante
						</button>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>
