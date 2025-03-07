@extends('layouts.auth')

@section('title', 'Kampanya Yönetimi')

@section('links')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.css" />
@endsection

@section('content')
    <div class="flex justify-between items-center bg-blue-700 text-gray-50 mb-8 p-2 rounded">
        <h4>Kampanya Yönetimi</h4>
        <div class="flex items-center gap-4">
            <select name="isletmeler_id" @class(['w-full border border-gray-300 text-gray-700 rounded py-1.5'])>
                {{-- @if (auth()->user()->isletmeler->count() > 1)
                    <option value="">İşletme seçiniz</option>
                @endif --}}
                @foreach (auth()->user()->isletmeler as $detay)
                    <option value="{{ encrypt($detay->isletme->isletmeler_id) }}">{{ $detay->isletme->baslik }}</option>
                @endforeach
            </select>

            <a href="{{ route('yonetim.kampanyalar.create') }}"
                class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded font-semibold text-xs !text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:text-gray-500 disabled:hover:!bg-inherit transition ease-in-out duration-150">Ekle</a>
        </div>
    </div>

    <div class="w-full overflow-x-auto">
        <table id="kampanyalar" class="display nowrap stripe">
            <thead>
                <tr>
                    <th></th>
                    <th>Başlık</th>
                    <th>Başlama tarihleri</th>
                    <th data-dt-order="disable"></th>
                    <th data-dt-order="disable"></th>
                </tr>
            </thead>
            <tbody id="table-body"></tbody>
        </table>
    </div>

    <x-modal id="etkinlik-modal" title="Detay" slotClass="h-full" class="w-full sm:w-4/5 overflow-y-auto"></x-modal>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.js"></script>

    <script>
        function verileriGetir(isletmeler_id) {
            $('#kampanyalar').DataTable({
                responsive: true,
                ordering: false,
                lengthMenu: [20, 40, 100, {
                    'label': 'Hepsi',
                    'value': -1
                }],
                ajax: {
                    url: `{{ route('yonetim.kampanyalar.dataTable', ['isletme_id' => '___ID___']) }}`.replace(
                        '___ID___', isletmeler_id),
                    type: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    dataSrc: 'data',
                },
            });
        }

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

        document.addEventListener('DOMContentLoaded', function() {
            const isletme_select = document.querySelector('select[name="isletmeler_id"]');

            if (isletme_select.value) {
                verileriGetir(isletme_select.value);
            }

            isletme_select.addEventListener('change', function() {
                if (this.value) {
                    $('#kampanyalar').DataTable().destroy();
                    verileriGetir(this.value);
                }
            });


        });
        document.addEventListener('click', function(event) {

            event.target.closest('.kampanya-duzenle-modal') && (async () => {

                const ID = event.target.closest('.kampanya-duzenle-modal').dataset.id;
                const URL =
                    `{{ route('yonetim.kampanyalar.edit', ['etkinlik_id' => '___ID___']) }}`
                    .replace('___ID___', ID);

                const RESPONSE = await ApiService.fetchData(URL, {}, 'GET');

                if (RESPONSE.data.success) {
                    const MODAL = document.getElementById('etkinlik-modal');

                    MODAL.querySelector('[data-slot]').innerHTML = RESPONSE.data.html;
                    modalShow(MODAL);
                    initCropper();
                } else {
                    ApiService.alert.error('Bir hata oluştu. Lütfen tekrar deneyiniz.');
                }
            })();

            event.target.closest('.kampanya-submit-button') && (async () => {
                event.preventDefault();
                const FORM = event.target.closest('.kampanya-submit-button').closest('form');
                const URL = FORM.action;
                const DATA = new FormData(FORM);

                const RESPONSE = await ApiService.fetchData(URL, DATA, 'POST');

                if (RESPONSE.data.success) {
                    ApiService.alert.success(RESPONSE.data.message);
                    modalClose(document.getElementById('etkinlik-modal'));
                    $('#kampanyalar').DataTable().ajax.reload();
                } else {
                    ApiService.alert.error(RESPONSE.data.message);
                }
            })();
        });
    </script>
@endsection
