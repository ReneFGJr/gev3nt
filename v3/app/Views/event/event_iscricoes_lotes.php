<div class="container mt-5">
	<form>
		<div class="row">
			<?php foreach ($lotes as $id => $line) { ?>
				<div class="col-md-12 col-lg-4 mb-4">
					<div class="card mt-4 shadow-sm h-100">
						<div class="card-body d-flex flex-column">
							<label class="form-check-label" for="lote-<?= $line['id_ei']; ?>">
								<?= $line['ei_modalidade']; ?>
							</label>
							<?php if ($line['ei_preco'] == 0) { ?>
								<p class="h5 fw-bold text-primary">Gratuito</p>
							<?php } else { ?>
								<p class="h5 fw-bold text-primary">R$ <?= number_format($line['ei_preco'], 2, ',', '.'); ?></p>
							<?php } ?>
							<a href="<?= base_url('subscribe/' . $event['id_e'] . '/' . $line['id_ei']); ?>" class="btn btn-primary mt-auto">Inscreva-se</a>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</form>
</div>
