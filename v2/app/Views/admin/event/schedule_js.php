<script>
	function showSchedule(id) {
		idW = "<?php echo $work; ?>"
		if (confirm('Deseja ver a programação?')) {
			window.location.href = `http://g3vent/admin/workEvent/${idW}?id_esb=${id}`;
		}
	}

	function reloadSchedule(id) {
		idW = "<?php echo $work; ?>"
		if (confirm('Deseja ver a programação?')) {
			window.location.href = `http://g3vent/admin/workEvent/${idW}`;
		}
	}
</script>
