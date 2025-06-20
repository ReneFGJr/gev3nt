<form method="get">
	<label>Informe o nome da emissão do certificado</label>
	<input type="text" name="search" value="<?= get('search') ?>" class="form-control border border-secondary" placeholder="Digite o nome do evento ou certificado" required>
	<input type="radio" name="type" value="type" value="1" <?php if (get("type")=='1') { echo 'checked'; }?> > autor
	<input type="radio" name="type" value="type" value="2" <?php if (get("type")=='2') { echo 'checked'; }?> > ouvinte/outros
	<br>
	<button type="submit" class="btn btn-primary mt-2">Procurar</button>
</form>
