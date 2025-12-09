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
    		font-size: 20px;
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
    		padding: 10px 20px;
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
    		<p class="email-header">Recuperação de Senha</p>

    		<p class="email-content">
    			Olá, <strong><?= esc($n_nome); ?></strong>!<br><br>
    			Recebemos uma solicitação para redefinir sua senha. Caso não tenha sido você, ignore este e-mail. Caso contrário, clique no botão abaixo para definir uma nova senha:
    		</p>

    		<a href="<?= esc($link); ?>" class="email-button">Redefinir Senha</a>

    		<p class="email-content">
    			Este link expirará em **24 horas** por questões de segurança.
    		</p>

    		<p class="footer">
    			Caso o botão não funcione, copie e cole o seguinte link no seu navegador:<br>
    			<a href="<?= esc($link); ?>" target="_blank"><?= esc($link); ?></a>
    		</p>

    		<p class="footer">Equipe ISKO Brasil</p>
    	</div>
