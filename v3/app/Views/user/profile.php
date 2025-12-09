<div class="row justify-content-center">
	<div class="col-md-12">
		<div class="profile-card">
			<!-- Cabeçalho do Perfil -->
			<div class="profile-header">
				<img src="https://via.placeholder.com/120" alt="Foto do Perfil">
				<h1><?= esc($n_nome) ?></h1>
				<p><?= esc($n_email) ?></p>
			</div>

			<!-- Informações do Perfil -->
			<div class="profile-info">
				<h3>Informações Pessoais</h3>
				<p><strong>ID:</strong> <?= esc($id_n) ?></p>
				<p><strong>CPF:</strong> <?= esc($n_cpf) ?></p>
				<p><strong>ORCID:</strong> <?= esc($n_orcid) ?></p>
				<p><strong>Afiliação:</strong> <?= esc($cb_nome) ?></p>
				<p><strong>Data de Criação:</strong> <?= esc($n_created) ?></p>
			</div>

			<!-- Biografia -->
			<div class="profile-info">
				<h3>Biografia</h3>
				<p><?= esc($n_biografia) ?></p>
			</div>

			<!-- Botão de Editar -->
			<div class="text-center">
				<a href="<?= site_url('usuario/editar/' . $id_n) ?>" class="btn btn-primary">Editar Perfil</a>
				<a href="<?= site_url('logoff') ?>" class="btn btn-danger">Sair / Logoff</a>
			</div>
		</div>
	</div>
</div>
