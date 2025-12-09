<div class="col-1 col-lg-1 text-center small" sstyle="font-size: 10px;"></div>
<div class="col-4 col-lg-2 text-center small" sstyle="font-size: 10px;">
	<?php
	echo substr($sch_day, 8, 2) . '/';
	echo substr($sch_day, 5, 2) . ' ' . $esb_hora_ini;
	?>
</div>

<div class="col-7 col-lg-9">
	<span class="text-<?= $lc_class; ?> bold">
		<a href="<?= base_url('/admin/session_ed/' . $id_esb.'/'.$sch_event); ?>" class="text-decoration-none link">
			<?php echo $esb_titulo; ?>
		</a>
		<sup><?= $id_esb ?></sup>
	</span>
	<div style="font-size: 0.8rem; color:#333;"><?= $esb_participantes; ?></div>
</div>
