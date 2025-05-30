<div class="container-lg py-4">
	<h1 class="display-5 text-center mb-4 fw-bold text-primary">Programação ISKO Brasil</h1>

	<!-- Filtros -->
	<div class="row g-3 mb-4">
		<div class="col-md-12">
			<div class="btn-group w-100 shadow">
				<?php
				$active = 'active';
				foreach ($dias as $key => $day) {
					$dia = substr($day, 8, 2) . '/' . substr($day, 5, 2);
					echo "<button class='btn btn-outline-primary $active' data-day='day_$key'>$dia</button>";
					$active = '';
				}
				?>
			</div>
		</div>
		<div class="col-md-8">
			<div class="d-flex gap-2 flex-wrap">
				<button class="btn btn-sm btn-salas active" data-room="all">Todas</button>
				<?php
				$active = '';
				foreach ($salas as $key => $room) {
					$dia = substr($day, 8, 2) . '/' . substr($day, 5, 2);
					echo '<button class="btn btn-sm btn-salas ' . $active . '" data-room="room_' . $key . '">' . $room . '</button>';
					$active = '';
				}
				?>
			</div>
		</div>
	</div>

	<!-- Grade de Horários -->
	<div class="schedule-grid">



		<!-- Sessões Paralelas -->
		<div class="row g-3">

			<?php
			foreach ($programacao as $p) {
				$diaID = $p['day'];
				$dia = $p['sch_day'];
				$dia = substr($dia, 8, 2) . '/' . substr($dia, 5, 2);
				$hora_ini = $p['esb_hora_ini'];
				$hora_fim = $p['esb_hora_fim'];
				$local = $p['lc_nome'];
				$localID = $p['esb_local'];
				$titulo = $p['esb_titulo'];
				$participantes = $p['esb_participantes'];
				$sala = $p['sala'];
				$class = $p['lc_class'];
				$works = $p['works'];
				require("event_meuseventos_day_room_class.php");
			}
			?>
		</div>
	</div>
</div>

<style>
	.text-coffee {
		color: #333;
	}

	.border-coffee .btn-salas {
		border: 1px solid #dee2e6;
		transition: all 0.3s ease;
	}

	.btn-salas.active {
		border-color: var(--bs-primary);
		background-color: var(--bs-primary);
		color: white !important;
	}

	/*************************************** Background */

	.bg-coffee {
		background-color: rgb(189, 190, 190);
		border-left: 10px #333 solid;
	}

	.bg-gray {
		background-color: rgb(215, 219, 221);
		border-left: 10px solidrgb(32, 36, 39);
	}

	.bg-azul {
		background-color: rgb(212, 227, 238);
		border-left: 10px solid #2196F3;
	}

	.bg-rosa {
		background-color: #fce4ec;
		border-left: 10px solid #E91E63;
	}

	.bg-verde {
		background-color: rgb(216, 244, 218);
		border-left: 10px solid #4CAF50;
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
