self.addEventListener("install", (event) => {
	event.waitUntil(
		caches.open("app-cache").then((cache) => {
			return cache.addAll([
				"/inscricao/",
				"/inscricao/manifest.json",
				"/inscricao/assets/icons/icon-192x192.png",
				"/inscricao/assets/icons/icon-512x512.png",
			]);
		})
	);
});

self.addEventListener("fetch", (event) => {
	event.respondWith(
		caches.match(event.request).then((response) => {
			return response || fetch(event.request);
		})
	);
});
