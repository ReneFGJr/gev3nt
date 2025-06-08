<h3 class="mt-3">Dados do Participante</h3>
<p><strong>Nome:</strong> <?= esc($data['n_nome']) ?>
<br><strong>E-mail:</strong> <?= esc($data['n_email']) ?>
<br><strong>CPF:</strong> <?= esc($data['n_cpf']) ?>
<br><strong>Afiliação:</strong> <?= esc($data['cb_nome']); ?></p>

<form method="post">
	<input type="hidden" name="id_ein" value="<?= esc($data['id_ein']) ?>">
	<label>Agência de Fomento:</label>
	<select name="ein_budget" class="form-control border-primary border">
		<?php
		foreach ($fomentos as $fomento) {
			$selected = ($data['ein_budget'] == $fomento['id_cbb']) ? 'selected' : '';
			echo '<option value="' . $fomento['id_cbb'] . '" ' . $selected . '>' . $fomento['cbb_name'] . '</option>';
		}
		?>
	</select>
	<br>
	<input type="submit" class="btn btn-primary" value="Salvar">
</form>
