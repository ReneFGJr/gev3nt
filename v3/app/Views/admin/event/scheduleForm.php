<form action="<?= base_url('admin/session_ed/'. $id_esb.'/'. $esb_event); ?>" method="post" class="form-horizontal">
	<input type="hidden" name="id_esb" value="<?= $id_esb; ?>">
	<div class="form-group">
		<label for="eventName">Event Name</label>
		<input type="text" class="form-control" id="esb_titulo" name="esb_titulo" value="<?= $esb_titulo; ?>" placeholder="Enter event name" required>
	</div>

	<div class="form-group">
		<label for="eventName">Event Name</label>
		<textarea type="text" rows=6 class="form-control" id="esb_participantes" name="esb_participantes" placeholder="Enter event esb_participantes"><?= $esb_participantes; ?></textarea>
	</div>
<?php

?>
	<div class="form-group">
		<label for="eventDate">Event Date</label>
		<select class="form-control" id="esb_day" name="esb_day" required>
		<option value="">Select a day</option>
			<?php
			foreach ($days as $day) {
				$selected = ($day['sch_day'] == $sch_day) ? 'selected' : '';
				echo "<option value='{$day['id_sch']}' {$selected}>{$day['sch_day']}</option>";
			}
			?>
		</select>
	</div>



	<div class="form-group">
		<label for="eventTime">Hora de início</label>
		<select class="form-control" id="esb_hora_ini" name="esb_hora_ini" required>
			<option value="">Select an end time</option>
			<?php
			foreach ($hours as $hour) {
				$selected = ($hour == $esb_hora_ini) ? 'selected' : '';
				echo "<option value='{$hour}' {$selected}>{$hour}</option>";
			}
			?>
		</select>
	</div>


	<div class="form-group">
		<label for="eventTime">Hora de final</label>
		<select class="form-control" id="esb_hora_fim" name="esb_hora_fim" required>
			<option value="">Select an end time</option>
			<?php
			foreach ($hours2 as $hour) {
				$selected = ($hour == $esb_hora_fim) ? 'selected' : '';
				echo "<option value='{$hour}' {$selected}>{$hour}</option>";
			}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="eventLocation">Sala</label>
		<select class="form-control" id="esb_local" name="esb_local" required>
			<option value="">Select a room</option>
			<?php
			foreach ($rooms as $room) {
				$selected = ($room['id_lc'] == $esb_local) ? 'selected' : '';
				echo 	'<option value="' . $room['id_lc'] . '" ' . $selected . '>' . $room['lc_nome'] . '</option>';
			}
			?>
		</select>

	</div>

	<button type="submit" class="btn btn-primary">Submit</button>
</form>
