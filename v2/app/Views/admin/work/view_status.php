<hr>
<h5>Alterar Status do Trabalho #<?= esc($dados['id_w']) ?></h5>

<form action="<?= base_url('admin/work/' . $dados['id_w']) ?>" method="post">
	<?= csrf_field() ?>

	<div class="mb-3">
		<select name="w_status" id="w_status" class="form-select" required>
			<option value="0" <?= $dados['w_status'] == 0 ? 'selected' : '' ?>>0 - Em avaliação</option>
			<option value="1" <?= $dados['w_status'] == 1 ? 'selected' : '' ?>>1 - Aprovado</option>
			<option value="2" <?= $dados['w_status'] == 2 ? 'selected' : '' ?>>2 - Programado no evento</option>
			<option value="8" <?= $dados['w_status'] == 8 ? 'selected' : '' ?>>8 - Não aprovado</option>
			<option value="9" <?= $dados['w_status'] == 9 ? 'selected' : '' ?>>9 - Cancelado</option>
		</select>
	</div>

	<button type="submit" class="btn btn-primary">Salvar</button>
	<a href="<?= base_url('admin/works') ?>" class="btn btn-secondary ms-2">Voltar</a>
	<a href="<?php echo base_url('admin/work/' . esc($dados['id_w'] . '?update=' . date("Y-md-d:h:i:s"))); ?>
		class=" btn btn-secondary ms-2" class="btn btn-secondary ms-2">Atualizar (via API)</a>
</form>
