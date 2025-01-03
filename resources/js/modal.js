import { successAlert, errorAlert } from "./alert";

export async function changeModal(url) {
    try {
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        const DATA = await response.json();

        document.getElementById('etkinlikModalContent').innerHTML = DATA.html;

        // HELPER FUNCTIONS
        initCoverImageHandler();
        initKatilimSinirlama();
        initDropdowns();
        initForm();
        initSummernote();

    } catch (error) {
        console.error('Hata:', error);
    }
}

function initCoverImageHandler() {
    const coverInput = document.getElementById('etkinlikKapakResmi');
    if (!coverInput) return;

    coverInput.addEventListener('change', function (event) {
        const resimContainer = document.getElementById('resimcontainer');
        resimContainer.innerHTML = ''; // Önceki resmi temizle

        const dosya = event.target.files[0];
        if (dosya && dosya.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Etkinlik Kapak Resmi';
                resimContainer.appendChild(img);
            }
            reader.readAsDataURL(dosya);
        } else {
            resimContainer.innerHTML =
                '<p class="text-red-500">Lütfen geçerli bir resim dosyası seçin.</p>';
        }
    });
}

function initKatilimSinirlama() {
    const container = document.getElementById('katilimSinirlamaContainer');
    const textElement = document.getElementById('katilimSinirlamaText');

    if (!container || !textElement) return;

    const checkboxes = container.querySelectorAll('input[type="checkbox"]');

    // Başlangıçta seçili checkbox sayısını hesapla
    let katilimSinirlamaCount = Array.from(checkboxes).filter(checkbox => checkbox.checked).length;

    // Metni güncelle
    updateKatilimSinirlamaText(katilimSinirlamaCount, textElement);

    // Her checkbox'a event listener ekle
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            if (this.checked) {
                katilimSinirlamaCount++;
            } else {
                katilimSinirlamaCount--;
            }
            updateKatilimSinirlamaText(katilimSinirlamaCount, textElement);
        });
    });
}

function updateKatilimSinirlamaText(count, element) {
    if (count > 0) {
        element.innerText = `(${count} adet seçim yapıldı)`;
    } else {
        element.innerText = '(Opsiyonel)';
    }
}

function initDropdowns() {
    document.querySelectorAll('.dropdown-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const DROPDOWN_CONTENT = this.nextElementSibling;
            DROPDOWN_CONTENT.classList.toggle('hidden');
        });
    });
}

function initForm() {
    const FORM = document.getElementById('etkinlikForm');
    if (!FORM) return;

    FORM.addEventListener('submit', async function (event) {
        event.preventDefault();

        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const FORM_DATA = new FormData(FORM);
        const POST_URL = FORM.getAttribute('action');

        try {
            const RESPONSE = await fetch(POST_URL, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: FORM_DATA
            });

            // Eğer HTTP statü kodu 200-299 aralığında DEĞİLSE (yani !RESPONSE.ok)
            // özel olarak 422 durumunu kontrol edelim
            if (!RESPONSE.ok) {
                // 422 ise validation hataları dönmüş demektir
                if (RESPONSE.status === 422) {
                    // Gelen JSON verisini parse et
                    const errorData = await RESPONSE.json();

                    // İsterseniz her bir field ve mesajını DOM'a yazdırabilirsiniz
                    for (const [field, messages] of Object.entries(errorData.errors)) {
                        messages.forEach(msg => {
                            errorAlert(`${msg}`);
                        });
                    }

                    return; // Burada return diyerek sonraki kodlara geçmiyoruz.
                } else {
                    // 422 dışındaki hatalar için (örnek: 500 vs.)
                    throw new Error('Ağ yanıtı uygun değil: ' + RESPONSE.statusText);
                }
            }

            // RESPONSE.ok === true durumda, success yanıtı parse edebiliriz
            const RESPONSE_DATA = await RESPONSE.json();
            console.log('Başarılı:', RESPONSE_DATA);

            if (RESPONSE_DATA.success) {
                document.getElementById('etkinlikModal').classList.add('hidden');
                successAlert(RESPONSE_DATA.message);
            } else if (RESPONSE_DATA.error) {
                errorAlert('Oopss! Bir hata oluştu. Lütfen bildirin.');
            }
        } catch (error) {
            console.error('Hata:', error);
        }
    });
}

function initSummernote() {
    // Summernote başlatma kodu
    $(document).ready(function () {
        $('#etkinlikAciklama').summernote({
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
                            let fileInput = $('<input/>').attr({
                                type: 'file',
                                accept: '.pdf,.doc,.docx'
                            });
                            fileInput.click();

                            fileInput.on('change', function () {
                                let file = fileInput[0].files[0];
                                if (file) {
                                    uploadFile(file, context);
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
                        let fileLink = `<a href="${response.url}" target="_blank">${file.name}</a>`;
                        context.invoke('editor.pasteHTML', fileLink + '<br>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });
}
