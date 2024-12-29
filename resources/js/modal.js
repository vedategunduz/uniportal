document.querySelectorAll('button[data-modal-target]').forEach(function (button) {
    button.addEventListener('click', function () {
        const modal = document.getElementById(button.dataset.modalTarget);
        const isHidden = modal.getAttribute('aria-hidden') === 'true';

        modal.setAttribute('aria-hidden', !isHidden);
        modal.classList.toggle('hidden');
    });

});
