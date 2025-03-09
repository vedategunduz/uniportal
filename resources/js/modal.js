function show(modal) {
    const MODAL = document.getElementById(modal);

    MODAL.classList.add('flex');
    MODAL.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function hide(modal) {
    const MODAL = document.getElementById(modal);

    MODAL.classList.add('hidden');
    MODAL.classList.remove('flex');
    document.body.classList.remove('overflow-hidden');
}

export { hide, show };
