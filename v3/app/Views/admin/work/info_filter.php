<!-- Campo de filtro -->
<input type="text" id="filtroTitulo" class="form-control mb-3" placeholder="Filtrar por título..." onkeyup="filtrarTrabalhos()">

<!-- Script JavaScript para filtro -->
<script>
	function filtrarTrabalhos() {
		let input = document.getElementById('filtroTitulo');
		let filtro = input.value.toLowerCase();
		let blocos = document.querySelectorAll('.container.mb-3');

		blocos.forEach(function(bloco) {
			let texto = bloco.innerText.toLowerCase();
			bloco.style.display = texto.includes(filtro) ? '' : 'none';
		});
	}
</script>
