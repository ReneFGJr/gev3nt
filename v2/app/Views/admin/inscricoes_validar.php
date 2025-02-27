<?php
foreach ($inscricoes as $idx => $line) {
	$color = ' bg-warning';
?>
	<div class="card mb-2">
		<div class="card-header small <?= $color; ?>" style="font-size: 0.6rem;">
			<?= substr($line['ein_data'], 0, 10); ?>
		</div>
		<div class="card-body d-flex flex-column">
			<div class="d-flex justify-content-between align-items-center">
				<div>
					<a href="/admin/inscricoes/view/<?= esc($line['id_ein']) ?>" class="link">
						<strong><?= $line['n_nome'] ?></strong>
					</a>
					<br><?= $line['cb_nome']; ?>
					<br>
					<span style="font-size: 0.8rem;">
						<?= $line['ei_modalidade'] ?> (R$ <?= number_format($line['ei_preco'], 2, ',', '.'); ?>)
					</span>
				</div>
				<?php if ($line['ein_recibo'] == '') { ?>
					<a href="/admin/inscricoes/check/<?= $line['id_ein']; ?>" target="_blank" class="btn btn-primary">Validar</a>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>
