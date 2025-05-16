
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
