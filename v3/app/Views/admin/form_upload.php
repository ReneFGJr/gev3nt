	<h2>Importar Arquivo CSV</h2>

	<?php if (session()->getFlashdata('message')): ?>
		<p><?= session()->getFlashdata('message') ?></p>
	<?php endif; ?>

	<form action="<?= base_url($action) ?>" method="post" enctype="multipart/form-data">
		<?= csrf_field() ?>
		<input type="file" name="csv_file" accept=".csv" required>
		<br><br>
		<button type="submit">Enviar e Importar</button>
	</form>
