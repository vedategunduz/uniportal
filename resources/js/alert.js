// Genel uyarı fonksiyonu
function createAlert(message, type = 'success') {
    const ALERT_CONTAINER = document.createElement('div');
    const ALERT_MESSAGE = document.createElement('p');
    const ALERT_HEAD = document.createElement('span');

    const CONTAINER_CLASS = [
        'border',
        'px-4',
        'py-3',
        'rounded',
        'fixed',
        'bottom-12',
        'right-12',
        'bottom-to-top-alert-animation',
        'z-30',
    ];

    switch (type) {
        case 'success':
            CONTAINER_CLASS.push('border-emerald-300', 'bg-emerald-100', 'text-emerald-600');
            ALERT_HEAD.textContent = 'Başarılı!';
            ALERT_HEAD.classList.add('text-emerald-700', 'me-2');
            break;
        case 'error':
            CONTAINER_CLASS.push('border-rose-300', 'bg-rose-100', 'text-rose-600');
            ALERT_HEAD.textContent = 'Hata!';
            ALERT_HEAD.classList.add('text-rose-700', 'me-2');
            break;
        case 'info':
            CONTAINER_CLASS.push('border-blue-300', 'bg-blue-100', 'text-blue-600');
            ALERT_HEAD.textContent = 'Bilgi!';
            ALERT_HEAD.classList.add('text-blue-700', 'me-2');
            break;
        case 'warning':
            CONTAINER_CLASS.push('border-yellow-300', 'bg-yellow-100', 'text-yellow-600');
            ALERT_HEAD.textContent = 'Uyarı!';
            ALERT_HEAD.classList.add('text-yellow-700', 'me-2');
            break;
    }

    ALERT_CONTAINER.classList.add(...CONTAINER_CLASS);
    ALERT_MESSAGE.classList.add('text-sm');
    ALERT_MESSAGE.appendChild(ALERT_HEAD);
    ALERT_MESSAGE.innerHTML += message;
    ALERT_CONTAINER.appendChild(ALERT_MESSAGE);
    document.body.appendChild(ALERT_CONTAINER);

    setTimeout(function () {
        document.body.removeChild(ALERT_CONTAINER);
    }, 5000);
}

// Kolay erişim için fonksiyonlar
export function successAlert(message) {
    createAlert(message, 'success');
}

export function errorAlert(message) {
    createAlert(message, 'error');
}

export function infoAlert(message) {
    createAlert(message, 'info');
}

export function warningAlert(message) {
    createAlert(message, 'warning');
}