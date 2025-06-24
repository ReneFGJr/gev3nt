<h2>Olá, <?= esc($socio->mb_name) ?>. Escolha sua chapa:</h2>
<form method="post" action="/votacao/votar">
	<?php foreach ($chapas as $chapa): ?>
		<div>
			<input type="radio" name="id_chapa" value="<?= $chapa['id_chapa'] ?>" required>
			<?= esc($chapa['nome']) ?>
		</div>
	<?php endforeach; ?>
	<button type="submit">Votar</button>
</form>
