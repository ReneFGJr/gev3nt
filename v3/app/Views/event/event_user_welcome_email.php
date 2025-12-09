<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bem-vindo à ISKO Brasil!</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f4f4f9;
			margin: 0;
			padding: 0;
		}

		.email-container {
			max-width: 500px;
			margin: 20px auto;
			background: #ffffff;
			padding: 20px;
			border-radius: 8px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			text-align: center;
		}

		.email-header {
			font-size: 22px;
			font-weight: bold;
			color: #333;
		}

		.email-content {
			font-size: 16px;
			color: #555;
			margin-top: 15px;
		}

		.email-button {
			display: inline-block;
			margin-top: 20px;
			padding: 12px 20px;
			font-size: 16px;
			color: #fff;
			background-color: #007bff;
			text-decoration: none;
			border-radius: 5px;
		}

		.email-button:hover {
			background-color: #0056b3;
		}

		.footer {
			font-size: 12px;
			color: #999;
			margin-top: 20px;
		}
	</style>
</head>

<body>

	<div class="email-container">
		<p class="email-header">Bem-vindo à ISKO Brasil, <?= esc($n_nome); ?>!</p>

		<p class="email-content">
			Obrigado por se cadastrar! Para garantir a segurança da sua conta e ativar seu acesso, pedimos que você confirme seu e-mail clicando no botão abaixo:
		</p>

		<a href="<?= esc($link); ?>" class="email-button text-white">Confirmar E-mail</a>

		<p class="email-content">
			Caso não tenha se registrado, ignore este e-mail.
		</p>

		<p class="footer">
			Se o botão acima não funcionar, copie e cole este link no seu navegador:<br>
			<a href="<?= esc($link); ?>" target="_blank"><?= esc($link); ?></a>
		</p>

		<p class="footer">Equipe ISKO Brasil</p>
	</div>
