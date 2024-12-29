document.querySelectorAll('.accordion-button').forEach(function (button) {
    button.addEventListener('click', function () {
        let isActive = this.getAttribute('aria-expanded') === 'true';
        this.setAttribute('aria-expanded', !isActive);
        this.nextElementSibling.classList.toggle('hidden');
    });
});
