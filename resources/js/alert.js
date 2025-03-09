function createAlert(message, type = 'success') {
    const alertContainer = document.createElement('div');
    alertContainer.classList.add(
        'p-6',
        'rounded',
        'bg-white',
        'text-gray-700',
        'flex',
        'items-start',
        'flex-wrap',
        'gap-4',
        'shadow',
        'min-w-60',
        'max-w-screen-sm',
        'bottom-to-top-alert-animation'
    );

    const icon = document.createElement('i');
    const textDiv = document.createElement('div');
    const title = document.createElement('p');
    const body = document.createElement('p');
    title.classList.add('mb-0');
    body.classList.add('text-opacity-70', 'mb-0');

    switch (type) {
        case 'success':
            icon.className = 'bi bi-check-square-fill text-green-400 text-xl';
            title.textContent = 'Başarılı!';
            title.classList.add('font-semibold', 'text-green-400');
            break;
        case 'error':
            icon.className = 'bi bi-x-square-fill text-red-600 text-xl';
            title.textContent = 'Hata!';
            title.classList.add('font-semibold', 'text-red-600');
            break;
        case 'warning':
            icon.className = 'bi bi-exclamation-triangle-fill text-orange-500 text-xl';
            title.textContent = 'Uyarı';
            title.classList.add('font-semibold', 'text-orange-500');
            break;
        case 'info':
            icon.className = 'bi bi-info-circle-fill text-blue-500 text-xl';
            title.textContent = 'Bilgi';
            title.classList.add('font-semibold', 'text-blue-500');
            break;
    }

    body.textContent = message;
    textDiv.appendChild(title);
    textDiv.appendChild(body);
    alertContainer.appendChild(icon);
    alertContainer.appendChild(textDiv);

    document.getElementById('alerts').appendChild(alertContainer);

    setTimeout(() => {
        alertContainer.remove();
    }, 5000);
}

function success(message) {
    createAlert(message, 'success');
}

function error(message) {
    createAlert(message, 'error');
}

function info(message) {
    createAlert(message, 'info');
}

function warning(message) {
    createAlert(message, 'warning');
}

export { success, error, info, warning };
