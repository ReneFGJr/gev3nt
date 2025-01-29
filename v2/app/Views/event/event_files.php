
	<div class="container mt-5">
		<div class="card shadow-lg border-0">
			<div class="card-header bg-primary text-white text-center">
				<h3><i class="fa-solid fa-file-invoice"></i> Comprovantes de Pagamento</h3>
			</div>
			<div class="card-body">

				<?php if (session()->getFlashdata('success')) : ?>
					<div class="alert alert-success" role="alert">
						<i class="fa-solid fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
					</div>
				<?php endif; ?>

				<?php if (session()->getFlashdata('error')) : ?>
					<div class="alert alert-danger" role="alert">
						<i class="fa-solid fa-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
					</div>
				<?php endif; ?>

				<?php if (!empty($files) && is_array($files)) : ?>
					<div class="table-responsive">
						<table class="table table-hover align-middle">
							<thead class="table-dark">
								<tr>
									<th>#</th>
									<th>Tipo</th>
									<th>Documento</th>
									<th>Arquivo</th>
									<th>Ações</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($files as $index => $file) : ?>
									<tr class="shadow-sm">
										<td><?= esc($index + 1) ?></td>
										<td><span class="badge bg-info"><?= esc($file['f_type']) ?></span></td>
										<td><i class="fa-solid fa-file-pdf text-danger"></i> <?= esc($file['f_doc']) ?></td>
										<td>
											<a href="<?= base_url($file['f_name']) ?>" target="_blank" class="btn btn-sm btn-success">
												<i class="fa-solid fa-eye"></i> Visualizar
											</a>
										</td>
										<td>
											<a href="<?= base_url('payment/delete/' . esc($file['if_f'])) ?>" class="btn btn-sm btn-danger">
												<i class="fa-solid fa-trash"></i> Excluir
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				<?php else : ?>
					<div class="alert alert-warning text-center">
						<i class="fa-solid fa-folder-open"></i> Nenhum comprovante encontrado.
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
