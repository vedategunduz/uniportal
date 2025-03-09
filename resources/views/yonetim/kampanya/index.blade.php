@extends('layouts.auth')

@section('title', 'Kampanya Yönetimi')

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

        table#kampanyalar th,
        table#kampanyalar td {
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
    <h1 class="px-4">Kampanya Yönetimi</h1>
    <div class="flex flex-wrap gap-4 mb-4 px-4">
        <select name="isletmeler_id" @class([
            'border border-gray-300 text-gray-700 rounded py-1.5',
            'hidden' => auth()->user()->isletmeler->count() == 1,
        ])>
            @foreach (auth()->user()->isletmeler as $detay)
                <option value="{{ encrypt($detay->isletme->isletmeler_id) }}">{{ $detay->isletme->baslik }}</option>
            @endforeach
        </select>

        <x-button class="kampanya-ekle-modal ml-auto !bg-green-400 text-white border-none">Yeni Kampanya Ekle</x-button>
    </div>

    <div class="overflow-x-auto px-4 w-full">
        <table id="kampanyalar" class="table table-striped table-bordered table-hover max-w-full">
            <thead>
                <tr>
                    <th data-dt-order="disable">#</th>
                    <th>Başlık</th>
                    <th>Başlama tarihleri</th>
                    <th data-dt-order="disable">#</th>
                    <th data-dt-order="disable">#</th>
                </tr>
            </thead>
            <tbody id="table-body"></tbody>
        </table>
    </div>

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
            const URL = `{{ route('yonetim.kampanyalar.dataTable', ['isletme_id' => '___ID___']) }}`;

            if (isletme_select.value) {
                datatable_verileri_getir('kampanyalar', URL.replace('___ID___', isletme_select.value));
            }

            isletme_select.addEventListener('change', function() {
                if (this.value) {
                    datatable_verileri_getir('kampanyalar', URL.replace('___ID___', isletme_select.value));
                }
            });
        });

        const MODAL = document.getElementById('etkinlik-modal');

        document.addEventListener('click', function(event) {

            event.target.closest('.kampanya-duzenle-modal') && (async () => {
                const ID = event.target.closest('.kampanya-duzenle-modal').dataset.id;
                const URL =
                    `{{ route('yonetim.kampanyalar.edit', ['etkinlik_id' => '___ID___']) }}`
                    .replace('___ID___', ID);

                const RESPONSE = await ApiService.fetchData(URL, {}, 'GET');

                if (RESPONSE.data.success) {
                    UniportalService.modal.show('etkinlik-modal');
                    MODAL.querySelector('[data-slot]').innerHTML = RESPONSE.data.html;
                    initSummernote('aciklamaSummernote');
                    initSummernote('katilimSartiSummernote');
                    UniportalService.fileUpload.refresh();
                    initCropper();
                } else
                    ApiService.alert.error('Bir hata oluştu. Lütfen tekrar deneyiniz.');
            })();

            event.target.closest('.kampanya-ekle-modal') && (async () => {
                const URL = `{{ route('yonetim.kampanyalar.create') }}`;
                const RESPONSE = await ApiService.fetchData(URL, {}, 'GET');

                if (RESPONSE.data.success) {
                    UniportalService.modal.show('etkinlik-modal');
                    MODAL.querySelector('[data-slot]').innerHTML = RESPONSE.data.html;
                    UniportalService.fileUpload.refresh();
                    initSummernote('aciklamaSummernote');
                    initSummernote('katilimSartiSummernote');
                    initCropper();
                } else
                    ApiService.alert.error('Bir hata oluştu. Lütfen tekrar deneyiniz.');
            })();

            event.target.closest('.kampanya-submit-button') && (async () => {
                event.preventDefault();
                const FORM = event.target.closest('.kampanya-submit-button').closest('form');
                const URL = FORM.action;
                const DATA = new FormData(FORM);

                const RESPONSE = await ApiService.fetchData(URL, DATA, 'POST');

                if (RESPONSE.data.success) {
                    ApiService.alert.success(RESPONSE.data.message);
                    UniportalService.modal.hide('etkinlik-modal');
                    $('#kampanyalar').DataTable().ajax.reload(null, false);
                } else
                    ApiService.alert.error(RESPONSE.data.message);
            })();

            event.target.closest('.kampanya-sil') && (async () => {
                if (!await confirmModal()) return;
                const ID = event.target.closest('.kampanya-sil').dataset.id;
                const URL = `{{ route('yonetim.kampanyalar.destroy', ['etkinlik_id' => '___ID___']) }}`
                    .replace('___ID___', ID);

                const RESPONSE = await ApiService.fetchData(URL, {}, 'DELETE');

                if (RESPONSE.data.success) {
                    ApiService.alert.success(RESPONSE.data.message);
                    $('#kampanyalar').DataTable().ajax.reload(null, false);
                } else
                    ApiService.alert.error(RESPONSE.data.message);
            })();

            event.target.closest('.close-modal') && function() {
                MODAL.querySelector('[data-slot]').innerHTML =
                    `<div class="h-96 flex items-center justify-center"><div class="size-12 border-4 border-t-transparent border-gray-300 rounded-full wheel"></div></div>`;
            }();
        });
    </script>
@endsection
