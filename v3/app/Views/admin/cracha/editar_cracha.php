<h3 class="mt-3">Dados do Participante</h3>
<p><strong>Nome:</strong> <?= esc($data['n_nome']) ?></p>
<p><strong>E-mail:</strong> <?= esc($data['n_email']) ?></p>
<p><strong>CPF:</strong> <?= esc($data['n_cpf']) ?></p>
<p><strong>Afiliação:</strong> <?= esc($data['cb_nome']); ?></p>

<form method="post">
	<input text="text" name="n_badge_name" value="<?php echo $n_badge_name; ?>" class="form-control" placeholder="Nome do crachá" required>
	<br>
	<input text="text" name="nome" value="<?php echo $cb_sigla; ?>" class="form-control" placeholder="Nome do crachá" disabled>
	<br>
	<input type="submit" class="btn btn-primary" value="Salvar">
</form>
