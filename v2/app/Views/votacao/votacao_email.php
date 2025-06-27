<style>
	body {
		font-family: 'Segoe UI', sans-serif;
		background-color: #2e2e2e;
		color: #ffffff;
		display: flex;
		justify-content: center;
		align-items: center;
		height: 100vh;
		padding: 2rem;
	}

	.form-container {
		background-color: #3c3c3c;
		padding: 2rem 2.5rem;
		border-radius: 12px;
		box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
		width: 100%;
		max-width: 400px;
	}

	h2 {
		text-align: center;
		margin-bottom: 1.5rem;
		color: #ffffff;
	}

	label {
		display: block;
		margin-bottom: 0.5rem;
		font-weight: bold;
	}

	input[type="email"] {
		width: 100%;
		padding: 0.8rem;
		border-radius: 8px;
		border: none;
		margin-bottom: 1.5rem;
		font-size: 1rem;
	}

	button {
		width: 100%;
		background-color: #1e90ff;
		color: white;
		padding: 1rem;
		border: none;
		border-radius: 10px;
		font-size: 1.1rem;
		cursor: pointer;
		transition: background 0.3s;
	}

	button:hover {
		background-color: #006fce;
	}
</style>

<div class="form-container">
	<h2>Votação para Diretoria ISKO Brasil 2026-2027</h2>
	<p>Informe seu e-mail para receber o link de votação para associados da ISKO Brasil.</p>
	<form method="post" action="<?php echo base_url('/votacao'); ?>">
		<label for="email">Digite seu e-mail:</label>
		<input type="email" name="email" id="email" required placeholder="seuemail@exemplo.com">
		<button type="submit">Enviar Link para votar</button>
	</form>
</div>
