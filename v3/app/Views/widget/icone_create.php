<button id="addToHomeScreen" class="btn btn-outline-primary btn-sm">Adicionar à Tela Inicial</button>

<script>
	let deferredPrompt;

	window.addEventListener('beforeinstallprompt', (e) => {
		e.preventDefault();
		deferredPrompt = e;
		document.getElementById('addToHomeScreen').style.display = 'block';
	});

	document.getElementById('addToHomeScreen').addEventListener('click', () => {
		if (deferredPrompt) {
			deferredPrompt.prompt();
			deferredPrompt.userChoice.then((choiceResult) => {
				if (choiceResult.outcome === 'accepted') {
					console.log('Usuário aceitou instalar o atalho');
				} else {
					console.log('Usuário recusou o atalho');
				}
				deferredPrompt = null;
			});
		}
	});
</script>
