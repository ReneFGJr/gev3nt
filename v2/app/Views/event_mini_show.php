<?php foreach ($events as $event) { ?>
	<?php
	$e_name = $event['e_name'];
	$e_description = $event['e_description'];
	$e_deadline = $event['e_sigin_until'];
	$e_image = $event['e_logo'];
	$e_id = $event['id_e'];
	?>
	<div class="card-body">
		<div class="card mt-4 shadow-sm">
			<div class="card-body">
				<h5 class="card-title text-center"><?= $e_name; ?></h5>
				<?php if (isset($e_image)) { ?>
					<img src="<?= $e_image; ?>" class="img-fluid" alt="<?= $e_name; ?>">
				<?php } ?>
				<hr>
				<div class="mb-8"></div>
				<p><?= $e_description; ?></p>
				<p><?= $e_deadline; ?></p>
				<p><a href="<?php echo base_url('subscribe/'.$e_id);?>" class="btn btn-primary sizeB">Inscreva-se</a></p>
			</div>
		</div>
	</div>
<?php } ?>
