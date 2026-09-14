document.addEventListener('DOMContentLoaded', function () {
	const body = document.body;
	const toggleButtons = document.querySelectorAll('[data-sidebar-toggle]');
	const sidebarToggle = document.querySelector('[data-sidebar-toggle]:not(.sidebar-overlay)');

	toggleButtons.forEach(function (button) {
		button.addEventListener('click', function () {
			const isOpen = body.classList.toggle('sidebar-open');

			if (sidebarToggle) {
				sidebarToggle.setAttribute('aria-expanded', String(isOpen));
			}
		});
	});

	document.querySelectorAll('.sidebar-link').forEach(function (link) {
		link.addEventListener('click', function () {
			body.classList.remove('sidebar-open');
		});
	});
});
