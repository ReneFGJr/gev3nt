	<style>
		#calendar {
			max-width: 900px;
			margin: 2rem auto;
		}
	</style>

	<div class="container">
		<h1 class="my-4 text-center">Meus Eventos</h1>
		<div id="calendar"></div>
	</div>


	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const eventos = <?= json_encode($eventos) ?>;

			const calendarEl = document.getElementById('calendar');
			const calendar = new FullCalendar.Calendar(calendarEl, {
				initialView: 'dayGridMonth',
				locale: 'pt-br',
				events: eventos.map(evento => ({
					title: evento.titulo,
					start: evento.data_inicio,
					end: evento.data_fim,
					description: evento.descricao
				})),
				eventContent: function(info) {
					return {
						html: `<div class="fc-event-title">${info.event.title}</div>`
					};
				}
			});

			calendar.render();
		});
	</script>
</body>

</html>
