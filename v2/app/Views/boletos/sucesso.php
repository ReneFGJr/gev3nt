<h3>Boleto registrado com sucesso!</h3>
<pre><?= esc(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?></pre>
<!-- Se a API retornar link para PDF ou linha digitável, exiba: -->
<?php if (!empty($response['urlBoleto'])): ?>
	<a href="<?= esc($response['urlBoleto']) ?>" target="_blank">Visualizar Boleto (PDF)</a>
<?php endif; ?>
