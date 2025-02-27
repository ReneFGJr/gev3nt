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
				<p><strong>Nome:</strong> <?= esc($data['n_nome']) ?></p>
				<p><strong>E-mail:</strong> <?= esc($data['n_email']) ?></p>
				<p><strong>CPF:</strong> <?= esc($data['n_cpf']) ?></p>
				<p><strong>Afiliação:</strong> <?= esc($data['cb_nome']); ?></p>
			</div>
			<?php if ($action == True) { ?>
				<div class="card-footer text-end">
					<a href="/admin/inscricoes/unchecked/<?= esc($data['id_ein']) ?>" class="btn btn-danger">Indeferir Inscrição</a>
					<a href="/admin/inscricoes/checked/<?= esc($data['id_ein']) ?>" class="btn btn-success">Validar Inscrição</a>
				</div>
			<?php } ?>
		</div>
	</div>
