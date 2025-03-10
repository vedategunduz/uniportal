const BASE_URL = window.location.origin;
const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

window.addEventListener('click', async function (event) {
    if (event.target.matches('.open-aside-modal')) {
        const MODAL = document.getElementById(event.target.dataset.modal);

        MODAL.classList.add('active');

        document.body.classList.add('overflow-hidden');
    }

    if (event.target.matches('.close-aside-modal')) {
        const MODAL = document.getElementById(event.target.dataset.modal);

        MODAL.classList.remove('active');

        document.body.classList.remove('overflow-hidden');
    }

    if (event.target.closest('.aside-message-accordion-button')) {
        const accordionButtons = document.querySelectorAll('.aside-message-accordion-button.active');
        const ACCORDION_HEADERS = Array.from(accordionButtons, button => button.parentElement);
        // const ACCORDION_HEADERS = document.querySelectorAll('.aside-message-accordion-button.active').parentElement;

        ACCORDION_HEADERS.forEach((header) => {
            if (header !== event.target.closest('.aside-message-accordion-button').parentElement) {
                header.querySelector('.aside-message-accordion-button').classList.remove('active');
                header.querySelector('.aside-message-accordion-button').classList.remove('!border-l-blue-400');
                header.nextElementSibling.style.maxHeight = 0;
            }
        });

        const ACCORDION_HEADER = event.target.closest('.aside-message-accordion-button');
        const ACCORDION_BODY = ACCORDION_HEADER.parentElement.nextElementSibling;

        ACCORDION_HEADER.classList.toggle('active');
        ACCORDION_HEADER.classList.toggle('!border-l-blue-400');

        if (ACCORDION_HEADER.classList.contains('active')) {
            ACCORDION_BODY.style.maxHeight = ACCORDION_BODY.scrollHeight + 'px';
            ACCORDION_BODY.querySelector('.mesaj-container').scrollTo(0, ACCORDION_BODY.querySelector('.mesaj-container').scrollHeight);
        } else {
            ACCORDION_BODY.style.maxHeight = 0;
        }
    }

    if (event.target.matches('.aside-accordion')) {
        const button = event.target;
        const accordionMenu = button.nextElementSibling;
        const buttonArrow = button.querySelector('.arrow');

        button.classList.toggle('active');

        if (button.classList.contains('active')) {
            buttonArrow.classList.add('rotate-180');

            accordionMenu.style.maxHeight = 'fit-content';

            // accordionMenu.classList.remove('hidden');
        } else {
            buttonArrow.classList.remove('rotate-180');
            accordionMenu.style.maxHeight = 0;
            // accordionMenu.classList.add('hidden');
        }

        let parentContent = accordionMenu.parentElement.closest('.accordion-content');
        while (parentContent) {
            const parentButton = parentContent.previousElementSibling;
            if (parentButton && parentButton.classList.contains('active')) {
                parentContent.style.maxHeight = parentContent.scrollHeight + accordionMenu.scrollHeight + 'px';
            }
            parentContent = parentContent.parentElement.closest('.accordion-content');
        }
    }
});

// function deneme() {
//     const accordionButtons = document.querySelectorAll('.aside-message-accordion-button.active');
//     const ACCORDION_HEADERS = Array.from(accordionButtons, button => button.parentElement);
//     // const ACCORDION_HEADERS = document.querySelectorAll('.aside-message-accordion-button.active').parentElement;

//     ACCORDION_HEADERS.forEach((header) => {
//         if (header !== event.target.closest('.aside-message-accordion-button').parentElement) {
//             header.querySelector('.aside-message-accordion-button').classList.remove('active');
//             header.querySelector('.aside-message-accordion-button').classList.remove('!border-l-blue-400');
//             header.nextElementSibling.style.maxHeight = 0;
//         }
//     });

//     const ACCORDION_HEADER = event.target.closest('.aside-message-accordion-button');
//     const ACCORDION_BODY = ACCORDION_HEADER.parentElement.nextElementSibling;

//     ACCORDION_HEADER.classList.toggle('active');
//     ACCORDION_HEADER.classList.toggle('!border-l-blue-400');

//     if (ACCORDION_HEADER.classList.contains('active')) {
//         ACCORDION_BODY.style.maxHeight = ACCORDION_BODY.scrollHeight + 'px';
//         ACCORDION_BODY.querySelector('.mesaj-container').scrollTo(0, ACCORDION_BODY.querySelector('.mesaj-container').scrollHeight);
//     } else {
//         ACCORDION_BODY.style.maxHeight = 0;
//     }
// }

function showMoreText(clamp = 3) {
    document.querySelectorAll('.show-more-text').forEach((element) => {
        element.addEventListener('click', function () {
            const wrapper = element.previousElementSibling;
            wrapper.classList.toggle(`line-clamp-${clamp}`);
            wrapper.querySelector('[data-iframe]').classList.toggle('hidden');
            element.querySelector('i').classList.toggle('bi-arrow-down-circle-fill');
            element.querySelector('i').classList.toggle('bi-arrow-up-circle-fill');
        });
    });
}

function modalShow(modal) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.classList.add('overflow-hidden');
}

function modalClose(modal) {
    modal.classList.remove('flex');
    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

function initSummernote(selector, height = 100) {
    console.log('Summernote initialized');
    $(document).ready(function () {
        $(`#${selector}`).summernote({
            height: height,
            lang: 'tr-TR',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
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
            data.append('_token', CSRF_TOKEN);

            $.ajax({
                url: `${BASE_URL}/editor/file/upload`,
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

function datatable_verileri_getir(selector, URL) {
    $(`#${selector}`).DataTable().destroy();

    $(`#${selector} `).DataTable({
        // responsive: true,
        lengthMenu: [20, 40, 100, {
            'label': 'Hepsi',
            'value': -1
        }],
        language: {
            "decimal": ",",
            "emptyTable": "Tabloda veri yok",
            "info": " _START_ - _END_ arasında _TOTAL_ kayıt gösteriliyor",
            "infoEmpty": "0 kayıttan 0'ı gösteriliyor",
            "infoFiltered": " (Toplam _MAX_ kayıttan filtrelendi)",
            "infoPostFix": "",
            "thousands": ".",
            "lengthMenu": "_MENU_ adet kayıt göster",
            "loadingRecords": "Yükleniyor...",
            "processing": "İşleniyor...",
            "search": '<i class="bi bi-search"></i>',
            "zeroRecords": "Eşleşen kayıt bulunamadı",
            "paginate": {
                "first": '<i class="bi bi-chevron-double-left"></i>',
                "last": '<i class="bi bi-chevron-double-right"></i>',
                "next": '<i class="bi bi-chevron-right"></i>',
                "previous": '<i class="bi bi-chevron-left"></i>'
            },
            "aria": {
                "orderable": "Bu sütunu sırala",
                "orderableReverse": "Bu sütunun ters sırayla sıralanmasını sağla"
            }
        },
        layout: {
            topStart: {
                pageLength: {
                    className: 'hidden'
                },
            },
            bottomStart: 'info',
            bottomEnd: 'paging'
        },
        ajax: {
            url: URL,
            type: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            dataSrc: 'data',
        },
    });
}

document.querySelector('.burger-menu')?.addEventListener('click', function () {
    document.querySelector('.collapsible-menu').classList.toggle('show');
    document.body.classList.toggle('overflow-hidden');
});

const overflowXContainer = document.querySelectorAll('.overflow-x-auto');

// Yatay scroll oluştur
overflowXContainer.forEach(function (container) {
    container.addEventListener('wheel', function (e) {
        // Dikey scroll değerini yatay kaydırmaya ekleyelim
        if (e.deltaY !== 0) {
            e.preventDefault();
            container.scrollLeft += (e.deltaY * 0.2);
        }
    });
});

function initCropper(options) {
    const cropperContainer = document.querySelector(options.cropperContainerSelector);
    const image = cropperContainer.querySelector(options.imageSelector);
    const input = document.querySelector(options.inputSelector);
    const cropButton = document.querySelector(options.cropButtonSelector);
    // Eğer varsa kırpılmış resmin önizlemesinin yapılacağı eleman
    const bannerImage = options.bannerImageSelector ? document.querySelector(options.bannerImageSelector) : null;

    let cropper;
    let originalName = null;

    // Dosya input değiştiğinde çalışacak olay
    input.addEventListener('change', function (event) {
        if (event.target.files && event.target.files.length > 0) {
            const file = event.target.files[0];
            originalName = file.name;
            if (/^image\/\w+/.test(file.type)) { // Dosyanın resim olduğundan emin ol
                const imageURL = URL.createObjectURL(file);
                image.src = imageURL;
                image.style.display = 'block';

                // Önceki cropper varsa yok et
                if (cropper) {
                    cropper.destroy();
                }

                // Cropper.js örneğini oluştur (opsiyonel ayarlar kullanılabilir)
                cropper = new Cropper(image, {
                    aspectRatio: options.aspectRatio || 1,
                    viewMode: options.viewMode || 1
                });

                // Modal'ı göster
                UniportalService.modal.show(options.modalId);
            } else {
                alert("Lütfen bir resim dosyası seçin.");
            }
        }
    });

    // Crop butonuna tıklandığında
    cropButton.addEventListener('click', function () {
        if (!cropper) return;

        // Kırpılmış canvas'ı elde et (fillColor ile boş alan doldurulur)
        const canvas = cropper.getCroppedCanvas({
            fillColor: options.fillColor || '#fff'
        });

        canvas.toBlob(function (blob) {
            if (!blob) return;

            const fileOptions = { type: options.fileType || "image/jpeg" };
            const croppedFile = new File([blob], originalName, fileOptions);

            // İsteğe bağlı: Kırpılmış resmi önizleme (bannerImage mevcutsa)
            if (bannerImage) {
                const croppedImageURL = URL.createObjectURL(croppedFile);
                bannerImage.src = croppedImageURL;
            }

            // Dosyayı <input type="file"> içine yerleştir
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            input.files = dataTransfer.files;

            // Modal'ı kapat
            UniportalService.modal.hide(options.modalId);
        }, options.fileType || 'image/jpeg', options.quality || 0.5);
    });
}
