@extends('layouts.auth')

@section('title', 'Kampanya Ekle')
@section('links')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.css" />
@endsection

@section('content')
    <x-modal id="imageCropModal" class="sm:w-2/4" title="Kırp">
        <div class="relative h-96">
            <img id="image" class="max-w-full" alt="Yüklenecek görüntü">
        </div>
        <x-button id="cropButton" class="mt-4">
            Kırp
        </x-button>
    </x-modal>

    <div class="mb-4 relative group">
        <img id="banner-image" src="{{ asset('image/resim-yok.png') }}" class="max-h-96 w-full object-contain rounded"
            loading="lazy" alt="">
        <div class="absolute top-4 left-4 hidden group-hover:!block">
            <label for="inputImage"
                class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-gray-50 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:text-gray-500 disabled:hover:!bg-inherit transition ease-in-out duration-150 cursor-pointer">
                Kapak resmi değiştir
            </label>
        </div>
    </div>

    <form action="" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="flex flex-col gap-8">
            <input type="file" id="inputImage" name="kapakResmiYolu" class="hidden" accept="image/*">

            <p class="text-sm/6 font-medium text-gray-900">Kampanya Detayları</p>
            <select name="isletmeler_id" @class(['w-full border border-gray-300 rounded py-1.5'])>
                @if (auth()->user()->isletmeler->count() > 1)
                    <option value="">İşletme seçiniz</option>
                @endif
                @foreach (auth()->user()->isletmeler as $detay)
                    <option value="{{ encrypt($detay->isletme->isletmeler_id) }}">{{ $detay->isletme->baslik }}</option>
                @endforeach
            </select>

            <x-relative-input type="text" name="baslik" label="Kampanya başlığı" required />

            <input type="hidden" name="etkinlik_turleri_id" value="{{ encrypt(14) }}">

            <div class="grid sm:grid-cols-2 gap-2">
                <x-datetime name="etkinlikBaslamaTarihi" label="Kampanya başlama tarihi" />

                <x-datetime name="etkinlikBitisTarihi" label="Kampanya bitiş tarihi" />
            </div>

            <p class="text-sm/6 font-medium text-gray-900">Dosya ve Resimler</p>
            <x-file-upload url="yonetim/etkinlikler/dosya-yukle" />

            @include('yonetim.kampanya.partials.editor')

            <x-textarea rows="3" name="katilimSarti" placeholder="Katılım şartları"></x-textarea>

        </div>

        <div class="flex flex-col gap-8">
            <label for="harita" class="text-sm/6 font-medium text-gray-900">Google Harita</label>

            <x-textarea rows="3" name="harita" id="harita" placeholder=""></x-textarea>

            <p class="text-sm/6 font-medium text-gray-900">Katılım tipi</p>
            <div class="flex flex-col">
                <x-radio name="katilimTipi" value="genel" checked>
                    <span>Genel</span>
                    <span class="text-gray-500 font-normal">Kampanyaya herkes katılabilir.</span>
                </x-radio>
                <x-radio name="katilimTipi" value="uniportal">
                    <span>Uniportal</span>
                    <span class="text-gray-500 font-normal">Sadece Uniportal üyeleri katılabilir.</span>
                </x-radio>
                <x-radio name="katilimTipi" value="özel">
                    <span>Özel</span>
                    <span class="text-gray-500 font-normal">Sadece davet edilenler katılabilir.</span>
                </x-radio>
            </div>

            <p class="border-b"></p>

            <p class="text-sm/6 font-medium text-gray-900">Kampanya İzinleri</p>

            <x-checkbox name="yorumDurumu">
                <span>Yorumlara kapat</span>
                <span class="text-gray-500 font-normal">Kampanyayı yoruma kapatmak için seçiniz.</span>
            </x-checkbox>

            <x-checkbox name="sosyalMedyadaPaylas">
                <span>Sosyal medyamızda paylaş</span>
                <span class="text-gray-500 font-normal">
                    Kampanyanın sosyal medya hesabımızda paylaşılması için seçiniz.</span>
            </x-checkbox>

            <x-checkbox name="mailDurumu">
                <span>Mail bildirimleri almak istiyorum</span>
                <span class="text-gray-500 font-normal">
                    Katılım isteklerini mail ile almak için seçiniz.
                </span>
            </x-checkbox>

            <div class="text-right">
                <x-button type="submit"
                    class="kampanya-submit-button !bg-blue-600 !border-none !text-white !normal-case !tracking-wider">Kampanyayı
                    yayınla</x-button>
            </div>
        </div>

    </form>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.js"></script>
    <script>
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

        document.addEventListener('click', function(event) {
            event.target.closest('.kampanya-submit-button') && (async () => {
                event.preventDefault();

                const FORM = event.target.closest('form');
                const DATA = new FormData(FORM);

                DATA.append('aciklama', window.textEditor.getHTML());

                const URL = "{{ route('yonetim.kampanyalar.store') }}";
                const RESPONSE = await ApiService.fetchData(URL, DATA, 'POST');

                if (RESPONSE.status === 201) {
                    ApiService.alert.success(RESPONSE.data.message);
                } else {
                    // Hata varsa:
                    if (RESPONSE.errors) {
                        // Tüm validasyon hatalarını dönelim
                        for (const [field, messages] of Object.entries(RESPONSE.errors)) {
                            // messages bir dizi ise tek tek gezebilirsiniz
                            messages.forEach(msg => ApiService.alert.error(msg));
                        }
                    } else {
                        ApiService.alert.error(RESPONSE.message);
                    }
                }

            })();
        });
    </script>
@endsection
