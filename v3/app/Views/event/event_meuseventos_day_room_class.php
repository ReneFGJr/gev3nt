<!-- Sala de Pedra -->

<!-- Palestra de Abertura -->
<div class="col-md-12 schedule-item mt-4" data-day="day_<?= $diaID; ?>" data-room="room_<?= $sala; ?>">
	<div class="h-100 bg-<?= $class; ?> p-3 rounded-3 shadow">
		<div class="d-flex justify-content-between align-items-center mb-2">
			<div class="time-badge bg-dark text-white rounded-pill px-3 py-1"><?php echo $dia; ?> <?php echo $hora_ini; ?></div>
			<span class="badge bg-white text-azul border border-azul"><?php echo $local; ?></span>
		</div>
		<h5 class="fw-bold"><?php echo $titulo; ?></h5>
		<div class="speakers text-muted">
			<?=$participantes;?>
			<?php
			foreach ($works as $w) {
				$autores = $w['w_autores'];
				if ($autores == '') {
					$autores = $w['nome_autor1'] . ' ' . $w['sobrenome_autor1'];
				}

				echo '<div class="text-muted ms-4 mb-2" style="border-left:6px solid #888; padding-left: 5px;"><b>' . $w['titulo'] . '</b>';
				echo '<sup> (ID:'.$w['w_id'].')</sup>';
				echo '<div class="ms-3"><i>' . $autores . '</i></div>';
				echo '</div>';
			}
			?>
			<!-- <i class="bi bi-person-fill"></i> Joseph Busch <a href="https://taxonomystrategies.com/about-us/joseph-busch-resume/" target="_blank">[currículo]</a> -->
		</div>
	</div>
</div>
