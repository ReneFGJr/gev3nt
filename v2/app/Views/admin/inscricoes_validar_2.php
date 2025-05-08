<?php
foreach ($inscricoes as $idx => $line) {
	$color = ' bg-warning';
?>
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-lg-2 col-4">
				<?= substr($line['ein_data'], 0, 10); ?>
			</div>
			<div class="col-lg-7 col-8">
				<a href="<?= base_url('/admin/inscricoes/view/' . esc($line['id_ein'])); ?>" class="link">
					<strong><?= $line['n_nome'] ?></strong>
				</a>
				<br><?= $line['cb_nome']; ?>
				<br><?= $line['ei_modalidade'] ?>
			</div>
			<div class="col-lg-2 col-8 text-end">
				<span style="font-size: 0.8rem;">
					R$ <?= number_format($line['ei_preco'], 2, ',', '.'); ?>
				</span>
			</div>
			<div class="col-lg-1 col-1">
				<?php if ($line['ein_recibo'] == '') { ?>
					<a href="<?= base_url('/admin/inscricoes/check/' . $line['id_ein']); ?>" target="_blank" class="btn btn-primary">Validar</a>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>
