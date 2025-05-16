<div class="col-4 col-lg-2 text-center small" sstyle="font-size: 10px;">
	<?php
	echo substr($sch_day, 8, 2) . '/';
	echo substr($sch_day, 5, 2) . ' ' . $esb_hora_ini;
	?>
</div>

<div class="col-8 col-lg-10">
	<input type="radio" name="id_esb" value="<?= $id_esb ?>" onclick="showSchedule(<?= $id_esb ?>)">
	<span class="text-<?= $lc_class; ?> bold">
		<?php echo $esb_titulo; ?>
		<?php echo $lc_nome; ?>
		<sup><?= $id_esb ?></sup>
	</span>
</div>
