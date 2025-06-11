<?= \Config\Services::validation()->listErrors() ?>
<?php if (session()->getFlashdata('error')): ?>
	<div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>
<form action="<?= site_url('boleto/registrar') ?>" method="post">
	<?= csrf_field() ?>
	<div>
		<label>Convênio</label>
		<input type="text" name="numeroConvenio" value="<?= get('numeroConvenio') ?>">
	</div>
	<div>
		<label>Carteira</label>
		<input type="text" name="numeroCarteira" value="<?= get('numeroCarteira') ?>">
	</div>
	<div>
		<label>Variação Carteira</label>
		<input type="text" name="numeroVariacaoCarteira" value="<?= get('numeroVariacaoCarteira') ?>">
	</div>
	<div>
		<label>Modalidade</label>
		<input type="text" name="codigoModalidade" value="<?= get('codigoModalidade') ?>">
	</div>
	<div>
		<label>Valor</label>
		<input type="text" name="valor" value="<?= get('valor') ?>">
	</div>
	<div>
		<label>Vencimento (YYYY-MM-DD)</label>
		<input type="date" name="vencimento" value="<?= get('vencimento') ?>">
	</div>
	<div>
		<label>Nome do Pagador</label>
		<input type="text" name="cliente_nome" value="<?= get('cliente_nome') ?>">
	</div>
	<div>
		<label>Documento do Pagador</label>
		<input type="text" name="cliente_documento" value="<?= get('cliente_documento') ?>">
	</div>
	<!-- outros campos: endereço, instruções, etc. -->
	<button type="submit">Registrar Boleto</button>
</form>
