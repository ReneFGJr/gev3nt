<form action="<?= base_url('subscribe/' . $event['id_e'].'/'.$lote[0]['id_ei']); ?>" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="lote" value="<?= $lote[0]['id_ei']; ?>">
	<div class="container mt-5">
		<!-- Título da página -->
		<div class="text-center mb-4">
			<h1 class="h3">Confirmação de Inscrição</h1>
			<p class="text-muted">Revise as informações antes de confirmar sua inscrição e envie o comprovante de matrícula, caso necessário.</p>
		</div>

		<!-- Dados da Inscrição -->
		<div class="card shadow-sm">
			<div class="card-body">
				<h2 class="h5 mb-4 text-primary">Detalhes da Inscrição</h2>
				<div class="row mb-3">
					<div class="col-md-8">
						<p class="mb-1 text-muted">Modalidade</p>
						<p class="fw-bold"><?= $lote[0]['ei_modalidade']; ?></p>
					</div>
					<div class="col-md-4">
						<p class="mb-1 text-muted">Evento de</p>
						<p class="fw-bold"><?= date('d/m/Y', strtotime($event['e_data_i'])); ?>
							até
							<?= date('d/m/Y', strtotime($event['e_data_f'])); ?></p>
					</div>
				</div>
				<div class="row mb-3">
					<div class="col-md-4">
						<p class="mb-1 text-muted">Preço</p>
						<p class="h5 fw-bold text-success">R$ <?= number_format($lote[0]['ei_preco'], 2, ',', '.'); ?></p>
					</div>
					<div class="col-md-8">
						<p class="mb-1 text-muted">Descrição</p>
						<p class="fw-bold"><?= $lote[0]['ei_descricao'] ?: 'Sem descrição disponível'; ?></p>
						<p><?=$event['e_forma_pagamento'];?></p>
					</div>
				</div>
			</div>
		</div>

		<!-- Upload de Comprovante -->
		<?php if ($lote[0]['el_matricula'] == 1) { ?>
			<div class="card shadow-sm mt-4">
				<div class="card-body">
					<h2 class="h5 mb-3 text-primary">Enviar Comprovante de Matrícula</h2>
					<div class="mb-3">
						<label for="comprovante" class="form-label">Selecione um documento PDF:</label>
						<input type="file" class="form-control" id="comprovante" name="comprovante" accept=".pdf" required>
						<small class="form-text text-muted">O arquivo deve estar no formato PDF e ter no máximo 5MB.</small>
					</div>
				</div>
			</div>
		<?php } ?>

		<!-- Botões de Ação -->
		<div class="d-flex justify-content-between mt-4">
			<a href="javascript:history.back()" class="btn btn-outline-secondary">Voltar</a>
			<input type="submit" class="btn btn-primary" value="Confirmar Inscrição">
		</div>
	</div>
</form>
