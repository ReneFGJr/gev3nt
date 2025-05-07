<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<title>Visualização do Trabalho</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container my-4">

	<h2 class="mb-3"><?= esc($dados['titulo']) ?></h2>
	<i><?php
		if ($dados['w_autores'] != '') {
			echo esc($dados['w_autores']);
		} else {
			echo esc($dados['nome_autor1'] . ' ' . $dados['sobrenome_autor1']);
		}
		?></i>
	<hr>

	<div class="mb-3">
		<strong>ID Interno:</strong> <?= esc($dados['id_w']) ?> |
		<strong>ID Original:</strong> <?= esc($dados['w_id']) ?> |
		<strong>Status:</strong> <?= esc($dados['w_status']) ?> |
		<strong>Evento:</strong> <?= esc($dados['w_evento']) ?>
	</div>

	<div class="mb-4">
		<h5>Resumo</h5>
		<p><?= esc($dados['resumo']) ?></p>
	</div>

	<div class="mb-4">
		<h5>Autor Principal</h5>
		<ul>
			<li><strong>Nome:</strong> <?= esc($dados['nome_autor1'] . ' ' . $dados['sobrenome_autor1']) ?></li>
			<li><strong>Email:</strong> <?= esc($dados['email_autor1']) ?></li>
			<li><strong>País:</strong> <?= esc($dados['pais_autor1']) ?></li>
			<li><strong>Instituição:</strong> <?= esc($dados['instituicao_autor1']) ?></li>
			<li><strong>ORCID:</strong> <?= esc($dados['orcid_autor1']) ?></li>
		</ul>
	</div>

	<div class="mb-4">
		<h5>Decisões Editorais</h5>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Rodada</th>
					<th>Decisão</th>
					<th>Data</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td><?= esc($dados['decisao1']) ?></td>
					<td><?= esc($dados['data_decisao1']) ?></td>
				</tr>
				<tr>
					<td>2</td>
					<td><?= esc($dados['decisao2']) ?></td>
					<td><?= esc($dados['data_decisao2']) ?></td>
				</tr>
				<tr>
					<td>3</td>
					<td><?= esc($dados['decisao3']) ?></td>
					<td><?= esc($dados['data_decisao3']) ?></td>
				</tr>
				<tr>
					<td>4</td>
					<td><?= esc($dados['decisao4']) ?></td>
					<td><?= esc($dados['data_decisao4']) ?></td>
				</tr>
			</tbody>
		</table>
	</div>

	<footer class="text-muted small">
		Criado em: <?= esc($dados['created_at']) ?>
	</footer>

</body>

</html>
