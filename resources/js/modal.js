document.querySelectorAll('button[data-modal-target]').forEach(function (button) {
    button.addEventListener('click', function () {
        const modal = document.getElementById(button.dataset.modalTarget);

        modal.classList.toggle('hidden');
    });

});
