<a href="<?= base_url('admin/inscricoes/cracha/' . $data['id_ein']); ?>" class="btn btn-outline-primary mt-2 ms-2">Dados do Crachá</a>
<a href="<?= base_url('admin/inscricoes/fomento/' . $data['id_ein']); ?>" class="btn btn-outline-primary mt-2 ms-2">Agência de Fomento</a>
<?php if ($data['ein_pago'] == 1) { ?>
	<a href="<?= base_url('admin/inscricoes/recibo_pagamento/' . $data['id_ein']); ?>" class="btn btn-outline-primary mt-2 ms-2">Gerar Recibo</a>
<?php } ?>
