function createAlert(message, type = 'success') {
    const ALERT_CONTAINER = document.createElement('div');
    const ALERT_HEAD = document.createElement('p');
    const ALERT_MESSAGE = document.createElement('p');

    ALERT_HEAD.classList.add('mb-0');

    const CONTAINER_CLASS = [
        'border',
        'px-4',
        'py-3',
        'rounded-lg',
        'bottom-to-top-alert-animation',
    ];

    switch (type) {
        case 'success':
            CONTAINER_CLASS.push('border-emerald-300', 'bg-emerald-100', 'text-emerald-600');
            ALERT_HEAD.textContent = 'Başarılı!';
            ALERT_HEAD.classList.add('text-emerald-700', 'font-bold', 'me-2');
            break;
        case 'error':
            CONTAINER_CLASS.push('border-rose-300', 'bg-rose-100', 'text-rose-700');
            ALERT_HEAD.textContent = 'Hata!';
            ALERT_HEAD.classList.add('text-rose-700', 'font-bold', 'me-2');
            break;
        case 'info':
            CONTAINER_CLASS.push('border-blue-300', 'bg-blue-100', 'text-blue-600');
            ALERT_HEAD.textContent = 'Bilgi!';
            ALERT_HEAD.classList.add('text-blue-700', 'font-bold', 'me-2');
            break;
        case 'warning':
            CONTAINER_CLASS.push('border-yellow-300', 'bg-yellow-100', 'text-yellow-600');
            ALERT_HEAD.textContent = 'Uyarı!';
            ALERT_HEAD.classList.add('text-yellow-700', 'font-bold', 'me-2');
            break;
    }
    ALERT_CONTAINER.classList.add(...CONTAINER_CLASS);

    ALERT_MESSAGE.appendChild(ALERT_HEAD);
    ALERT_MESSAGE.innerHTML += message;
    ALERT_MESSAGE.classList.add('text-sm', 'mb-0');

    ALERT_CONTAINER.appendChild(ALERT_MESSAGE);

    document.getElementById('alerts').appendChild(ALERT_CONTAINER);

    setTimeout(function () {
        document.getElementById('alerts').removeChild(ALERT_CONTAINER);
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
