<div class="container-lg py-4">
	<h1 class="display-5 text-center mb-4 fw-bold text-primary">Programação ISKO Brasil</h1>

	<!-- Filtros -->
	<div class="row g-3 mb-4">
		<div class="col-md-12">
			<div class="btn-group w-100 shadow">
				<button class="btn btn-outline-primary active" data-day="day1">Dia 1</button>
				<button class="btn btn-outline-primary" data-day="day2">Dia 2</button>
				<button class="btn btn-outline-primary" data-day="day3">Dia 3</button>
			</div>
		</div>
		<div class="col-md-8">
			<div class="d-flex gap-2 flex-wrap">
				<button class="btn btn-sm btn-salas active" data-room="all">Todas</button>
				<button class="btn btn-sm btn-salas" data-room="azul">Sala Azul</button>
				<button class="btn btn-sm btn-salas" data-room="rosa">Sala Rosa</button>
				<button class="btn btn-sm btn-salas" data-room="verde">Sala Verde</button>
			</div>
		</div>
	</div>

	<!-- Grade de Horários -->
	<div class="schedule-grid">
		<!-- Sessão 1 -->
		<div class="schedule-item bg-light p-3 mb-3 rounded-3 shadow-sm" data-day="day1" data-room="all">
			<div class="time-badge bg-primary text-white rounded-pill px-3 py-1 d-inline-block">09:00</div>
			<div class="mt-2">
				<h5 class="mb-0">Credenciamento</h5>
				<span class="text-muted small">Área Principal</span>
			</div>
		</div>

		<!-- Sessão 2 -->
		<div class="schedule-item bg-light p-3 mb-3 rounded-3 shadow-sm" data-day="day1" data-room="all">
			<div class="time-badge bg-primary text-white rounded-pill px-3 py-1 d-inline-block">10:00</div>
			<div class="mt-2">
				<h5 class="mb-0">Palestra de Abertura</h5>
				<span class="text-muted small">Auditório Principal</span>
			</div>
		</div>
<?php /*
		<!-- Sessões Paralelas -->
		<div class="row g-3">
			<!-- Sala Azul -->
			<div class="col-md-12 schedule-item" data-day="day1" data-room="azul">
				<div class="h-100 bg-azul p-3 rounded-3 shadow">
					<div class="d-flex justify-content-between align-items-center mb-2">
						<div class="time-badge bg-dark text-white rounded-pill px-3 py-1">27/06 14:00</div>
						<span class="badge bg-white text-azul border border-azul">Sala Azul</span>
					</div>
					<h5 class="fw-bold">Indexação em Repositórios Digitais</h5>
					<p class="small mb-1">A importância da indexação de documentos em repositórios digitais</p>
					<div class="speakers text-muted small">
						<i class="bi bi-person-fill"></i> João da Silva<br>
						<i class="bi bi-person-fill"></i> Rene Faustino Gabriel<br>
						<i class="bi bi-person-fill"></i> Viviane de Fátima Túlio
					</div>
				</div>
			</div>

			<!-- Sala Azul -->
			<div class="col-md-12 schedule-item" data-day="day1" data-room="azul">
				<div class="h-100 bg-azul p-3 rounded-3 shadow">
					<div class="d-flex justify-content-between align-items-center mb-2">
						<div class="time-badge bg-dark text-white rounded-pill px-3 py-1">27/06 14:30</div>
						<span class="badge bg-white text-azul border border-azul">Sala Azul</span>
					</div>
					<h5 class="fw-bold">Indexação em Repositórios Digitais 2</h5>
					<p class="small mb-1">A importância da indexação de documentos em repositórios digitais</p>
					<div class="speakers text-muted small">
						<i class="bi bi-person-fill"></i> João da Silva<br>
						<i class="bi bi-person-fill"></i> Rene Faustino Gabriel<br>
						<i class="bi bi-person-fill"></i> Viviane de Fátima Túlio
					</div>
				</div>
			</div>

			<!-- Sala Azul -->
			<div class="col-md-12 schedule-item" data-day="day1" data-room="azul">
				<div class="h-100 bg-azul p-3 rounded-3 shadow">
					<div class="d-flex justify-content-between align-items-center mb-2">
						<div class="time-badge bg-dark text-white rounded-pill px-3 py-1">27/06 15:00</div>
						<span class="badge bg-white text-azul border border-azul">Sala Azul</span>
					</div>
					<h5 class="fw-bold">Indexação em Repositórios Digitais 3</h5>
					<p class="small mb-1">A importância da indexação de documentos em repositórios digitais</p>
					<div class="speakers text-muted small">
						<i class="bi bi-person-fill"></i> João da Silva<br>
						<i class="bi bi-person-fill"></i> Rene Faustino Gabriel<br>
						<i class="bi bi-person-fill"></i> Viviane de Fátima Túlio
					</div>
				</div>
			</div>

			<!-- Sala Rosa -->
			<div class="col-md-12 schedule-item" data-day="day1" data-room="rosa">
				<div class="h-100 bg-rosa p-3 rounded-3 shadow">
					<div class="d-flex justify-content-between align-items-center mb-2">
						<div class="time-badge bg-dark text-white rounded-pill px-3 py-1">27/06 14:00</div>
						<span class="badge bg-white text-rosa border border-rosa">Sala Rosa</span>
					</div>
					<h5 class="fw-bold">Gestão do Conhecimento</h5>
					<p class="small mb-1">Novas abordagens na organização da informação</p>
					<div class="speakers text-muted small">
						<i class="bi bi-person-fill"></i> Maria Oliveira<br>
						<i class="bi bi-person-fill"></i> Carlos Andrade
					</div>
				</div>
			</div>

			<!-- Sala Verde -->
			<div class="col-md-12 schedule-item" data-day="day1" data-room="verde">
				<div class="h-100 bg-verde p-3 rounded-3 shadow">
					<div class="d-flex justify-content-between align-items-center mb-2">
						<div class="time-badge bg-dark text-white rounded-pill px-3 py-1">27/06 14:00</div>
						<span class="badge bg-white text-verde border border-verde">Sala Verde</span>
					</div>
					<h5 class="fw-bold">Tecnologias Emergentes</h5>
					<p class="small mb-1">IA aplicada à organização da informação</p>
					<div class="speakers text-muted small">
						<i class="bi bi-person-fill"></i> Ana Paula Costa<br>
						<i class="bi bi-person-fill"></i> Fernando Almeida
					</div>
				</div>
			</div>

			<!-- Sala Azul -->
			<div class="col-md-12 schedule-item" data-day="day2" data-room="azul">
				<div class="h-100 bg-azul p-3 rounded-3 shadow">
					<div class="d-flex justify-content-between align-items-center mb-2">
						<div class="time-badge bg-dark text-white rounded-pill px-3 py-1">28/06 14:00</div>
						<span class="badge bg-white text-azul border border-azul">Sala Azul</span>
					</div>
					<h5 class="fw-bold">Indexação em Repositórios Digitais 3</h5>
					<p class="small mb-1">A importância da indexação de documentos em repositórios digitais</p>
					<div class="speakers text-muted small">
						<i class="bi bi-person-fill"></i> João da Silva<br>
						<i class="bi bi-person-fill"></i> Rene Faustino Gabriel<br>
						<i class="bi bi-person-fill"></i> Viviane de Fátima Túlio
					</div>
				</div>
			</div>
		</div>
		*/ ?>
	</div>
</div>

<style>
	.btn-salas {
		border: 1px solid #dee2e6;
		transition: all 0.3s ease;
	}

	.btn-salas.active {
		border-color: var(--bs-primary);
		background-color: var(--bs-primary);
		color: white !important;
	}

	.bg-azul {
		background-color: #e3f2fd;
		border-left: 4px solid #2196F3;
	}

	.bg-rosa {
		background-color: #fce4ec;
		border-left: 4px solid #E91E63;
	}

	.bg-verde {
		background-color: #e8f5e9;
		border-left: 4px solid #4CAF50;
	}

	.text-azul {
		color: #2196F3;
	}

	.text-rosa {
		color: #E91E63;
	}

	.text-verde {
		color: #4CAF50;
	}

	.schedule-item {
		transition: transform 0.2s ease;
	}

	.schedule-item:hover {
		transform: translateY(-3px);
	}
</style>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Filtro por dia
		document.querySelectorAll('[data-day]').forEach(btn => {
			btn.addEventListener('click', function() {
				document.querySelectorAll('[data-day]').forEach(b => b.classList.remove('active'));
				this.classList.add('active');
				const day = this.dataset.day;
				document.querySelectorAll('.schedule-item').forEach(item => {
					item.style.display = item.dataset.day === day ? 'block' : 'none';
				});
			});
		});

		// Filtro por sala
		document.querySelectorAll('[data-room]').forEach(btn => {
			btn.addEventListener('click', function() {
				document.querySelectorAll('[data-room]').forEach(b => b.classList.remove('active'));
				this.classList.add('active');
				const room = this.dataset.room;
				document.querySelectorAll('.schedule-item').forEach(item => {
					const show = room === 'all' || item.dataset.room === room;
					item.style.display = show ? 'block' : 'none';
				});
			});
		});
	});
</script>
