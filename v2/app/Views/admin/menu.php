<nav class="navbar navbar-expand-lg bg-body-tertiary d-print-none">
	<div class="container-fluid">
		<a class="navbar-brand" href="#">Navbar</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<a class="nav-link active" aria-current="page" href="<?= base_url('/admin'); ?>">Home</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						Programação
					</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="<?= base_url('/admin/works'); ?>">Trabalhos</a></li>
						<li><a class="dropdown-item" href="<?= base_url('/admin/sessions'); ?>">Blocos da programação</a></li>
						<li><a class="dropdown-item" href="<?= base_url('/admin/accepts'); ?>">Comunicação de aceites</a></li>
						<li><a class="dropdown-item" href="<?= base_url('/admin/authors'); ?>">Autores Aprovados</a></li>
						<li><a class="dropdown-item" href="<?= base_url('/presentations'); ?>">Apresentações (Evento)</a></li>
					</ul>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						Inscrições
					</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="<?= base_url('/admin/inscricoes/validar'); ?>">Validar inscrições</a></li>
						<li>
							<hr class="dropdown-divider">
						</li>
						<li><a class="dropdown-item" href="<?= base_url('/admin/summary'); ?>">Resumo Geral</a></li>
						<li><a class="dropdown-item" href="<?= base_url('/admin/inscricoes/validar2'); ?>">Relatório Inscrições</a></li>
						<li><a class="dropdown-item" href="<?= base_url('/admin/attendanceList'); ?>">Relação Inscritos</a></li>
						<li><a class="dropdown-item" href="<?= base_url('/admin/inscricoes/etiqueta'); ?>">Imprimir Etiquetas</a></li>

					</ul>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						Certificados
					</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="<?= base_url('/admin/certificados/presentation'); ?>">Certificados Apresentação</a></li>
						<li><a class="dropdown-item" href="<?= base_url('/admin/certificados/gerar'); ?>">Gerar certificados</a></li>
						<li><a class="dropdown-item" href="<?= base_url('/admin/certificados/email'); ?>">Enviar certificados por e-mail</a></li>
						<li><hr></li>
						<li><a class="dropdown-item" href="<?= base_url('/admin/certificados/avulsos_modelos'); ?>">Certificados Modelos</a></li>
						<li><a class="dropdown-item" href="<?= base_url('/admin/certificados/avulsos'); ?>">Certificados Avulsos</a></li>
						<li><a class="dropdown-item" href="<?= base_url('/admin/certificados/import_persons'); ?>">Importar Nomes</a></li>
					</ul>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						Tools
					</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="<?= base_url('/admin/import'); ?>">Importar OJS</a></li>
						<li><a class="dropdown-item" href="<?= base_url('/admin/import_api'); ?>">Atualizar Trabalhos OJS (API)</a></li>
					</ul>
				</li>

			</ul>
			<form class="d-flex" role="search">
				<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
				<button class="btn btn-outline-success" type="submit">Search</button>
			</form>
		</div>
	</div>
</nav>
