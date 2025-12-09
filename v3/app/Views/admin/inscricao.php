	<div class="container mt-4">
		<div class="card">
			<div class="card-header text-center bg-primary text-white">
				<h4>Detalhes da Inscrição</h4>
			</div>
			<div class="card-body">
				<h5 class="card-title">Evento: <?= esc($data['e_name']) ?></h5>
				<p><strong>Local:</strong> <?= esc($data['e_cidade']) ?></p>
				<p><strong>Data:</strong> <?= esc($data['ein_data']) ?></p>
				<p><strong>Modalidade:</strong> <?= esc($data['ei_modalidade']) ?> (R$ <?= number_format($data['ei_preco'], 2, ',', '.') ?>)</p>

				<h3 class="mt-3">Dados do Participante</h3>
				<p><strong>Nome:</strong> <?= esc($data['n_nome']) ?>
					<br><strong>E-mail:</strong> <?= esc($data['n_email']) ?>
					<br><strong>CPF:</strong> <?= esc($data['n_cpf']) ?>
					<br><strong>Afiliação:</strong> <?= esc($data['cb_nome']); ?>
					<br><strong>Financiamento:</strong> <?= esc($data['cbb_name']); ?>
				</p>

				<div>

				</div>
				<label>Nome no Crachá
					<?php if ($data['n_badge_print'] == 1) {
						echo "(Imprimir)";
					} ?> </p>
				</label>
				<div class="border border-secondary rounded p-3 text-center">
					<h1><?= esc($data['n_badge_name']); ?></h1>
					<h2><?= esc($data['cb_sigla']); ?></h2>

				</div>
			</div>
			<?php if ($action == True) { ?>
				<div class="card-footer text-end">
					<?php if ($data['ein_pago'] == 0) { ?>
						<a href="<?= base_url('/admin/inscricoes/email_alert/' . esc($data['id_ein'])); ?>" class="btn btn-warning">E-mail comprovante</a>
					<?php } ?>
					<a href="<?= base_url('/admin/inscricoes/unchecked/' . esc($data['id_ein'])); ?>" class="btn btn-danger">Indeferir Inscrição</a>
					<a href="<?= base_url('/admin/inscricoes/checked/' . esc($data['id_ein'])); ?>" class="btn btn-success">Validar Inscrição</a>
				</div>
			<?php } ?>
		</div>
	</div>
