@extends('layouts.auth')

@section('title', 'etkinlik Yönetimi')

@section('links')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.css" />

    <style>
        .dt-length select.input-sm {
            line-height: 15px !important;
            color: #000;
        }

        div.dt-container div.dt-layout-row {
            margin: 0 0 1rem !important;
        }

        table#etkinlikler th,
        table#etkinlikler td {
            white-space: nowrap;
        }

        div.dt-container div.dt-search input {
            border: 1px solid #ccc;
            border-radius: 0.375rem;
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            color: #4a5568;
            background-color: #fff;
            background-clip: padding-box;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        div.dt-container div.dt-layout-row div.dt-layout-cell {
            padding: 0 !important;
        }
    </style>
@endsection

@section('content')
    <div class="flex flex-wrap items-center px-4">
        <h1 class="me-4">Etkinlik Yönetimi</h1>

        <select name="isletmeler_id" @class([
            'border border-gray-300 text-gray-700 rounded py-1.5 ml-auto w-full lg:w-auto',
            'hidden' => auth()->user()->isletmeler->count() == 1,
        ])>
            @foreach (auth()->user()->isletmeler as $detay)
                <option value="{{ encrypt($detay->isletme->isletmeler_id) }}">{{ $detay->isletme->baslik }}</option>
            @endforeach
        </select>

        <x-button class="etkinlik-ekle-modal !bg-green-400 text-white border-none gap-2 w-full lg:w-auto justify-center">
            <i class="bi bi-plus-lg"></i>
            <span>Etkinlik Ekle</span>
        </x-button>

        <p class="border-b  w-full mt-0"></p>
    </div>

    <div class="overflow-x-auto px-4 w-full">
        <table id="etkinlikler" class="table table-striped table-bordered table-hover max-w-full">
            <thead>
                <tr>
                    <th data-dt-order="disable">#</th>
                    <th>Başlık</th>
                    <th>Başlama tarihleri</th>
                    <th>Yrm</th>
                    <th>Bgn</th>
                    <th>Sohbetler</th>
                    <th>#</th>
                    <th data-dt-order="disable">#</th>
                    <th data-dt-order="disable">#</th>
                </tr>
            </thead>
            <tbody id="table-body">
            </tbody>
        </table>
    </div>

    <x-modal id="etkinlik-katilim-modal" title="Etkinlik Katılımcılar" class="w-full max-w-7xl overflow-y-auto">
        <div class="h-96 flex items-center justify-center">
            <div class="size-12 border-4 border-t-transparent border-gray-300 rounded-full wheel"></div>
        </div>
    </x-modal>

    <x-modal id="etkinlik-modal" title="" class="w-full sm:w-4/5 overflow-y-auto">
        <div class="h-96 flex items-center justify-center">
            <div class="size-12 border-4 border-t-transparent border-gray-300 rounded-full wheel"></div>
        </div>
    </x-modal>

    <x-modal id="confirm-modal" title="" headerClass="!bg-transparent !text-gray-900" headerCloseButton="false">
        <div class="space-y-8 pt-4">
            <div class="text-center space-y-2">
                <i class="bi bi-exclamation-circle-fill text-6xl text-gs-red"></i>

                <p class="text-sm text-gray-700 w-52 mx-auto">
                    İlgili etkinlik silenecektir. Etkinliği silmek istediğinize emin misiniz?
                </p>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <x-button class="justify-center close-modal canceled" data-modal="confirm-modal">İptal</x-button>
                <x-button class="!bg-gs-red text-white !border-0 justify-center confirmed">Onayla</x-button>
            </div>
        </div>
    </x-modal>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.js"></script>

    <script>
        function initCropper() {
            let cropper;
            let originalName = null;
            const image = document.getElementById('image');
            const input = document.getElementById('inputImage');
            const cropButton = document.getElementById('cropButton');

            // Dosya input değiştiğinde çalışır
            input.addEventListener('change', function(event) {
                if (event.target.files && event.target.files.length > 0) {
                    const file = event.target.files[0];
                    originalName = file.name;
                    if (/^image\/\w+/.test(file.type)) { // dosyanın bir görsel olduğunu doğrula
                        // Seçilen dosyayı nesne URL'sine çevirerek <img> etikete yükle
                        const imageURL = URL.createObjectURL(file);
                        image.src = imageURL;
                        image.style.display = 'block';
                        // Önceki bir cropper örneği varsa yok et (yeni resim yüklendi)
                        if (cropper) {
                            cropper.destroy();
                        }
                        // Cropper.js örneğini oluştur ve oranı sabitle (burada 1:1 oran)
                        cropper = new Cropper(image, {
                            aspectRatio: 4 / 3, // 1:1 oran (16/9 gibi başka bir oranla değiştirilebilir)
                            viewMode: 1 // Görüntü sınırları içinde kırpmayı kısıtla
                        });

                        const modal = document.getElementById('imageCropModal');
                        modalShow(modal);
                    } else {
                        alert("Lütfen bir resim dosyası seçin.");
                    }
                }
            });

            cropButton.addEventListener('click', function() {
                if (!cropper) return;

                // Kırpılmış canvas elde ediyoruz
                const canvas = cropper.getCroppedCanvas({
                    fillColor: '#fff', // Transparan alanları beyazla doldur
                });

                // toBlob ile JPEG formatında (0.8 kalite) blob oluşturuyoruz
                canvas.toBlob(function(blob) {
                    if (!blob) return;

                    // Blob'u bir File nesnesine çeviriyoruz
                    const fileName = originalName;
                    const fileOptions = {
                        type: "image/jpeg"
                    };
                    const croppedFile = new File([blob], fileName, fileOptions);

                    // İsteğe bağlı: Kırpılan resmi sayfada önizlemek için (base64 veya URL)
                    const croppedImageURL = URL.createObjectURL(croppedFile);
                    const bannerImage = document.getElementById('banner-image');
                    bannerImage.src = croppedImageURL;

                    // Şimdi bu File nesnesini <input type="file"> içine koyalım
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(croppedFile);
                    input.files = dataTransfer.files;

                    // Modal kapatma vs.
                    modalClose(document.getElementById('imageCropModal'));
                }, 'image/jpeg', 0.8);
            });
        }

        function confirmModal() {
            return new Promise((resolve, reject) => {
                const MODAL = document.getElementById('confirm-modal');
                MODAL.querySelector('.confirmed').addEventListener('click', () => {
                    resolve(true);
                    UniportalService.modal.hide('confirm-modal');
                });
                MODAL.querySelector('.canceled').addEventListener('click', () => resolve(false));
                UniportalService.modal.show('confirm-modal');
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const isletme_select = document.querySelector('select[name="isletmeler_id"]');
            const URL = `{{ route('yonetim.etkinlikler.dataTable', ['isletme_id' => '___ID___']) }}`;

            if (isletme_select.value) {
                datatable_verileri_getir('etkinlikler', URL.replace('___ID___', isletme_select.value));
            }

            isletme_select.addEventListener('change', function() {
                if (this.value) {
                    datatable_verileri_getir('etkinlikler', URL.replace('___ID___', isletme_select.value));
                }
            });
        });

        const MODAL = document.getElementById('etkinlik-modal');

        document.addEventListener('click', function(event) {

            event.target.closest('.etkinlik-duzenle-modal') && (async () => {
                const ID = event.target.closest('.etkinlik-duzenle-modal').dataset.id;
                const URL =
                    `{{ route('yonetim.etkinlikler.edit', ['etkinlik_id' => '___ID___']) }}`
                    .replace('___ID___', ID);

                const RESPONSE = await ApiService.fetchData(URL, {}, 'GET');

                if (RESPONSE.data.success) {
                    initSummernote('katilisimSartiSummernote');
                    initSummernote('aciklamaSummernote');
                    UniportalService.modal.show('etkinlik-modal');
                    MODAL.querySelector('[data-slot]').innerHTML = RESPONSE.data.html;
                    UniportalService.fileUpload.refresh();
                    initCropper();
                } else
                    ApiService.alert.error('Bir hata oluştu. Lütfen tekrar deneyiniz.');
            })();

            event.target.closest('.etkinlik-ekle-modal') && (async () => {
                const URL = `{{ route('yonetim.etkinlikler.create') }}`;
                const RESPONSE = await ApiService.fetchData(URL, {}, 'GET');

                if (RESPONSE.data.success) {
                    UniportalService.modal.show('etkinlik-modal');
                    MODAL.querySelector('[data-slot]').innerHTML = RESPONSE.data.html;
                    UniportalService.fileUpload.refresh();
                    initSummernote('katilisimSartiSummernote');
                    initSummernote('aciklamaSummernote');
                    initCropper();
                } else
                    ApiService.alert.error('Bir hata oluştu. Lütfen tekrar deneyiniz.');
            })();

            event.target.closest('.etkinlik-submit-button') && (async () => {
                event.preventDefault();
                const FORM = event.target.closest('.etkinlik-submit-button').closest('form');
                const URL = FORM.action;
                const DATA = new FormData(FORM);

                const RESPONSE = await ApiService.fetchData(URL, DATA, 'POST');

                if (RESPONSE.data.success) {
                    ApiService.alert.success(RESPONSE.data.message);
                    UniportalService.modal.hide('etkinlik-modal');
                    $('#etkinlikler').DataTable().ajax.reload(null, false);
                } else
                    ApiService.alert.error(RESPONSE.data.message);
            })();

            event.target.closest('.etkinlik-sil') && (async () => {
                if (!await confirmModal()) return;
                const ID = event.target.closest('.etkinlik-sil').dataset.id;
                const URL = `{{ route('yonetim.etkinlikler.destroy', ['etkinlik_id' => '___ID___']) }}`
                    .replace('___ID___', ID);

                const RESPONSE = await ApiService.fetchData(URL, {}, 'DELETE');

                if (RESPONSE.data.success) {
                    ApiService.alert.success(RESPONSE.data.message);
                    $('#etkinlikler').DataTable().ajax.reload(null, false);
                } else
                    ApiService.alert.error(RESPONSE.data.message);
            })();

            event.target.closest('.ziyaret-sohbet-baslat') && (() => {
                const button = event.target.closest('.ziyaret-sohbet-baslat');
                const ID = button.dataset.id;
                const name = button.dataset.name;

                document.querySelector('.open-aside-modal').click();
                document.querySelector('.searchNotSifirla ').click();
                document.querySelector('#modal-yeni-kanal').querySelector(
                        'input[name="baslik"]').value =
                    name;
                document.getElementById('search-channel').value = name;

                document.querySelector('#modal-yeni-kanal').querySelector(
                        'input[name="etkinlikler_id"]')
                    .value = ID;
                searchChannel(name);
            })();

            event.target.closest('.ziyaret-kanallar') && (() => {
                const button = event.target.closest('.ziyaret-kanallar');
                const name = button.dataset.name;

                document.querySelector('.open-aside-modal').click();
                document.querySelector('#modal-yeni-kanal').querySelector(
                        'input[name="baslik"]').value =
                    name;
                document.getElementById('search-channel').value = name;
                searchChannel(name);
            })();

            event.target.closest('.etkinlik-katilim-modal') && (async () => {
                const id = event.target.closest('.etkinlik-katilim-modal').dataset.id;
                const URL =
                    `{{ route('yonetim.etkinlikler.katilimcilar.show', ['etkinlik_id' => '___ID___']) }}`
                    .replace('___ID___', id);

                const RESPONSE = await ApiService.fetchData(URL, {}, 'GET');

                if (RESPONSE.data.success) {
                    UniportalService.modal.show('etkinlik-katilim-modal');
                    document.getElementById('etkinlik-katilim-modal').querySelector('[data-slot]')
                        .innerHTML =
                        RESPONSE.data.html;
                    showMoreText();
                    initDatatable('katilim-detay');
                } else
                    ApiService.alert.error('Bir hata oluştu. Lütfen tekrar deneyiniz.');
            })();

            event.target.closest('.etkinlik-katilim-cevap') && (async () => {
                event.preventDefault();
                const button = event.target.closest('.etkinlik-katilim-cevap');
                const form = button.closest('form');
                const URL = form.action;
                const kullanicilar = form.querySelectorAll('[name="kullanicilar_id[]"]');
                let send = false;

                kullanicilar.forEach(kullanici => {
                    if (kullanici.checked)
                        send = true;
                });

                if (!send) {
                    ApiService.alert.error('Lütfen en az bir katılımcı seçiniz.');
                    return;
                }

                const formData = new FormData();

                formData.append('durum', button.dataset.type);


                kullanicilar.forEach(kullanici => {
                    if (kullanici.checked)
                        formData.append('kullanicilar_id[]', kullanici.value);
                });

                const RESPONSE = await ApiService.fetchData(URL, formData, 'POST');

                if (RESPONSE.data.success) {

                    kullanicilar.forEach(kullanici => {
                        if (kullanici.checked) {
                            const span = kullanici.closest('tr').querySelector('[data-durum]')
                                .querySelector('span');
                            span.textContent = button.dataset.type;

                            if (button.dataset.type == 'Onaylandı') {
                                span.classList.remove('text-red-500', 'bg-red-100',
                                    'border-red-400', 'text-yellow-500', 'bg-yellow-100',
                                    'border-yellow-400');
                                span.classList.add('text-green-500', 'bg-green-100',
                                    'border-green-400');
                            } else {
                                span.classList.remove('text-green-500', 'bg-green-100',
                                    'border-green-400', 'text-yellow-500', 'bg-yellow-100',
                                    'border-yellow-400');
                                span.classList.add('text-red-500', 'bg-red-100',
                                    'border-red-400');
                            }
                        }
                    });

                    $('#etkinlikler').DataTable().ajax.reload(null, false);
                    ApiService.alert.success(RESPONSE.data.message);
                } else
                    ApiService.alert.error('Bir hata oluştu. Lütfen tekrar deneyiniz.');
            })();

            event.target.closest('.sohbet-baslat') && (async () => {
                const ID = event.target.closest('.sohbet-baslat').dataset.id;
                const etkinlik_id = event.target.closest('.sohbet-baslat').dataset.etkinlikId;
                const URL =
                    `{{ route('yonetim.etkinlikler.sohbet', ['kullanici_id' => '___ID___', 'etkinlik_id' => '___ETKINLIK_ID___']) }}`
                    .replace('___ID___', ID)
                    .replace('___ETKINLIK_ID___', etkinlik_id);

                const RESPONSE = await ApiService.fetchData(URL, {}, 'GET');

                if (RESPONSE.data.success) {
                    console.log(RESPONSE.data.message);
                    $('#etkinlikler').DataTable().ajax.reload(null, false);
                    document.querySelector('.open-aside-modal').click();
                    ApiService.alert.success(RESPONSE.data.message);
                } else
                    ApiService.alert.error('Bir hata oluştu. Lütfen tekrar deneyiniz.');
            })();

            event.target.closest('.close-modal') && function() {
                if (event.target.closest('.close-modal').closest('#imageCropModal'))
                    return

                MODAL.querySelector('[data-slot]').innerHTML =
                    `<div class="h-96 flex items-center justify-center"><div class="size-12 border-4 border-t-transparent border-gray-300 rounded-full wheel"></div></div>`;
            }();
        });

        document.addEventListener('change', function(event) {
            event.target.closest('[name=toggleAll]') && (function() {
                const form = event.target.closest('form');
                const checkboxes = form.querySelectorAll('[name="kullanicilar_id[]"]');

                if (event.target.checked) {
                    checkAll();
                } else {
                    uncheckAll();
                }

                function checkAll() {
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = true;
                    });
                }

                function uncheckAll() {
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = false;
                    });
                }
            })();
        });
    </script>
@endsection
