const BASE_URL = window.location.origin;
const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

async function fetchData(url, data = {}, isFormData = false, method = 'POST') {
    try {
        const headers = {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
        }

        let body;

        if (isFormData)
            body = data;
        else {
            headers['Content-Type'] = 'application/json';
            body = JSON.stringify(data);
        }

        const RESPONSE = await fetch(`${BASE_URL}/${url}`, {
            method: method,
            headers: headers,
            body: body
        });

        return await RESPONSE.json();
    } catch (error) {
        console.error(`public app.js ==> ${error}`);
    }
}

function createAlert(message, type = 'success') {
    const ALERT_CONTAINER = document.createElement('div');
    const ALERT_MESSAGE = document.createElement('p');
    const ALERT_HEAD = document.createElement('p');

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
    ALERT_MESSAGE.classList.add('text-sm');

    ALERT_CONTAINER.appendChild(ALERT_MESSAGE);

    document.getElementById('alerts').appendChild(ALERT_CONTAINER);

    setTimeout(function () {
        document.getElementById('alerts').removeChild(ALERT_CONTAINER);
    }, 5000);
}

function successAlert(message) {
    createAlert(message, 'success');
}

function errorAlert(message) {
    createAlert(message, 'error');
}

function infoAlert(message) {
    createAlert(message, 'info');
}

function warningAlert(message) {
    createAlert(message, 'warning');
}

document.querySelectorAll('.open-modal').forEach(function (element) { });

window.addEventListener('click', function (event) {
    if (event.target.matches('.open-modal')) {
        const MODAL = document.getElementById(event.target.dataset.modal);

        MODAL.classList.remove('hidden');
        MODAL.classList.add('flex');

        document.body.classList.add('overflow-hidden');
    }

    if (event.target.matches('.close-modal')) {
        const MODAL = document.getElementById(event.target.dataset.modal);

        MODAL.classList.remove('flex');
        MODAL.classList.add('hidden');

        document.body.classList.remove('overflow-hidden');
    }
});
