@extends('layouts.auth')

@section('title', 'Kampanya Yönetimi')
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
        <img id="banner-image" src="{{ asset('image/pika.jpg') }}" class="max-h-96 w-full object-contain rounded"
            loading="lazy" alt="">
        <div class="absolute top-4 left-4 hidden group-hover:!block">
            <label for="inputImage"
                class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-gray-50 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:text-gray-500 disabled:hover:!bg-inherit transition ease-in-out duration-150 cursor-pointer">
                Kapak resmi değiştir
            </label>
        </div>
    </div>
    <form action="" class="space-y-4">
        <input type="file" id="inputImage" name="kapakResmiYolu" class="hidden" accept="image/*">

        <select name="isletmeler_id" @class([
            'w-full border border-gray-300 rounded py-1.5',
            'hidden' => auth()->user()->isletmeler->count() == 1,
        ])>
            <option value="">İşletme seçiniz</option>
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

        @include('yonetim.kampanya.partials.editor')

        <x-file-upload url="yonetim/etkinlikler/dosya-yukle" />

        <x-checkbox name="yorumDurumu">
            <span class="">Yorumlara kapat</span>
            <span class="text-gray-500 font-normal">Kampanyayı yoruma kapatmak için seçiniz.</span>
        </x-checkbox>

        <x-checkbox name="sosyalMedyadaPaylas">
            <span class="">Sosyal medyamızda paylaş</span>
            <span class="text-gray-500 font-normal">
                Kampanyanın sosyal medya hesabımızda paylaşılması için seçiniz.</span>
        </x-checkbox>

        <x-button type="submit" class="kampanya-submit-button">
            Kaydet
        </x-button>

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

        // // "Kırp" butonuna tıklandığında çalışır
        // cropButton.addEventListener('click', function() {
        //     if (cropper) {
        //         // Kırpılmış bölgeyi bir HTML5 canvas elementine al
        //         const canvas = cropper.getCroppedCanvas();
        //         // Canvas içeriğini bir resim URL'sine (base64) dönüştür
        //         const croppedImageDataURL = canvas.toDataURL('image/jpeg', 0.1);
        //         // Sonucu göster (önceki içeriği temizleyip yeni <img> ekleyerek)
        //         const bannerImage = document.getElementById('banner-image');
        //         bannerImage.src = croppedImageDataURL;
        //         modalClose(document.getElementById('imageCropModal'));
        //     }
        // });
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
                    console.log(RESPONSE);
                    ApiService.alert.error(RESPONSE);
                }
            })();
        });
    </script>
@endsection
