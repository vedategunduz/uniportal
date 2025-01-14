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
    const ALERT_HEAD      = document.createElement('p');
    const ALERT_MESSAGE   = document.createElement('p');

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
        MODAL.querySelector('.modal-content').innerHTML = '';

        document.body.classList.remove('overflow-hidden');
    }
});

// Dinamik olarak eklenen Summernote çağırmak için
// @params id: Summernote çağrılacak elementin id'si
function callSummernote(id) {
    $(document).ready(function () {
        $(id).summernote({
            height: 200,
            lang: 'tr-TR',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview']],
                ['mybutton', ['uploadDoc']]
            ],
            buttons: {
                uploadDoc: function (context) {
                    var ui = $.summernote.ui;
                    var button = ui.button({
                        contents: '<i class="note-icon-plus"/> Dosya Yükle',
                        tooltip: 'Doküman Yükle (pdf, docx vs)',
                        click: function () {
                            let fileInput = $(
                                '<input/>').attr({
                                    type: 'file',
                                    accept: '.pdf,.doc,.docx'
                                });
                            fileInput.click();

                            fileInput.on('change',
                                function () {
                                    let file =
                                        fileInput[0]
                                            .files[0];
                                    if (file) {
                                        uploadFile(
                                            file,
                                            context
                                        );
                                    }
                                });
                        }
                    });
                    return button.render();
                }
            }
        });

        function uploadFile(file, context) {
            let data = new FormData();
            data.append('file', file);
            data.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: '',
                type: 'POST',
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.url) {
                        let fileLink =
                            `<a href="${response.url}" target="_blank">${file.name}</a>`;
                        context.invoke('editor.pasteHTML',
                            fileLink + '<br>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });
}

function callResimler() {
    // Tek bir dosya için resim gösterim işlemini yöneten fonksiyon
    function handleFileLoad(file, container) {
        // Skeletonu ekle
        const skeletonWrapper = document.createElement('div');
        skeletonWrapper.className = 'flex items-center gap-4 border-b pb-2 mb-2';
        skeletonWrapper.innerHTML = `
            <div class="skeleton skeleton-img"></div>
            <div class="flex flex-col justify-between mb-0 w-full">
                <div class="skeleton skeleton-text"></div>
                <div class="skeleton skeleton-text-small mb-1"></div>
                <div class="skeleton skeleton-text-small"></div>
            </div>`;
        container.appendChild(skeletonWrapper);

        const reader = new FileReader();
        reader.onload = function (e) {
            // Resim yüklendiğinde skeletonu gerçek içerik ile değiştir
            const fileSizeMB = (file.size / (1024 * 1024)).toFixed(1) + ' MB';
            skeletonWrapper.innerHTML = `
                <img src="${e.target.result}" alt="Resim Önizleme" class="size-14 rounded">
                <p class="flex flex-col justify-between mb-0">
                    <span class="text-sm">${file.name}</span>
                    <span class="text-xs">Galeri resmi</span>
                    <span class="text-xs text-gray-500">${fileSizeMB}</span>
                </p>
                <button type="button" class="ml-auto text-sm hover:underline remove-btn">
                    Resmi kaldır
                </button>`;

            // "Resmi kaldır" butonunu işaretle
            const removeBtn = skeletonWrapper.querySelector('.remove-btn');
            removeBtn.addEventListener('click', function () {
                skeletonWrapper.remove();
            });
        };
        reader.readAsDataURL(file);
    }

    // Çoklu dosya input olayını yöneten bölüm
    document.getElementById('resimYolu').addEventListener('change', function (event) {
        const container = document.getElementById('resimYoluContainer');
        // Çoklu dosya seçimine izin verildiği için var olan içerikleri korumak isteyebilirsiniz.
        // Eğer temizlemek isterseniz: container.innerHTML = '';

        const files = event.target.files;
        if (!files.length) return;

        Array.from(files).forEach(file => {
            if (file && file.type.startsWith('image/')) {
                handleFileLoad(file, container);
            }
        });
    });

    // Tek dosya input olayını yöneten bölüm
    document.getElementById('kapakResmiYolu').addEventListener('change', function (event) {
        const container = document.getElementById('kapakResmiContainer');
        // Tek dosya seçildiği için var olan içerikleri temizlemek isteyebilirsiniz.
        container.innerHTML = '';

        const file = event.target.files[0];
        if (!file) return;

        handleFileLoad(file, container);
    });
}
