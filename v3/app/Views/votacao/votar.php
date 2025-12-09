<style>
	body {
		font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		background-color: #2e2e2e;
		color: #ffffff;
		display: flex;
		flex-direction: column;
		align-items: center;
		padding: 2rem;
	}

	h2 {
		background-color: #1e90ff;
		padding: 1rem;
		border-radius: 10px;
		margin-bottom: 2rem;
		color: white;
		text-align: center;
		width: 100%;
		max-width: 500px;
	}

	form {
		background-color: #3c3c3c;
		padding: 2rem;
		border-radius: 12px;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
		width: 100%;
		max-width: 500px;
	}

	.opcao {
		background-color: #555;
		padding: 1rem;
		margin-bottom: 1rem;
		border-radius: 8px;
		display: flex;
		align-items: center;
		cursor: pointer;
		transition: background 0.3s;
	}

	.opcao:hover {
		background-color: #666;
	}

	.opcao input {
		margin-right: 1rem;
		transform: scale(1.5);
	}

	button {
		width: 100%;
		background-color: #28a745;
		border: none;
		color: white;
		padding: 1rem;
		border-radius: 10px;
		font-size: 1.2rem;
		cursor: pointer;
		transition: background 0.3s;
	}

	button:hover {
		background-color: #218838;
	}
</style>

<h2>Olá, <?= esc($socio['mb_name']) ?>. Escolha sua chapa:</h2>

<form method="post" action="<?=base_url('/votacao/votar');?>">
<input type="hidden" name="id_nb" value="<?= esc($socio['id_nb']) ?>">
	<?php foreach ($chapas as $chapa): ?>
		<label class="opcao">
			<input type="radio" name="id_chapa" value="<?= $chapa['id_chapa'] ?>" required>
			<?= esc($chapa['nome']) ?>
		</label>
	<?php endforeach; ?>
	<button type="submit">CONFIRMAR VOTO</button>
</form>
