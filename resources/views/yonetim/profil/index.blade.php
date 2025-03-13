@extends('layouts.auth')

@section('title', 'Profil')

@section('links')
    <style>
        .image-wrapper img {
            width: 192px;
            height: 192px;
            object-fit: contain
            border-radius: 50%;
        }

        .cropper-view-box,
        .cropper-face,
        .cropper-container,
        .cropper-drag-box {
            border-radius: 50%;

            /* img {
                width: 192px !important;
                height: 192px !important;
                border-radius: 50%;
            } */
        }

        .cropper-canvas {
            width: 192px !important;
            height: 192px !important;
        }

        .cropper-view-box {
            outline: 0;
            box-shadow: 0 0 0 1px #39f;
        }
    </style>
@endsection

@section('content')
    <section class="p-4">
        <header>
            <div class="bg-gray-100 rounded h-48"></div>

            <section class="flex items-center px-4 -mt-12">
                <div class="shrink-0 border-8 rounded-full   border-white relative">
                    <div class="image-wrapper">
                        <img src="{{ asset('image/create_event_default.jpg') }}" alt="">
                    </div>

                    @if (auth()->id() === $kullanici->kullanicilar_id)
                        <div class="absolute bottom-0 right-0">
                            <x-button class="!py-0.5 !px-2 rounded-full">
                                <i class="bi bi-camera text-lg text-gray-600"></i>
                            </x-button>
                        </div>
                    @endif
                </div>

                <div class="ms-4 space-y-0.5">
                    <!-- İsim -->
                    <div class="text-xl font-semibold text-gray-800 leading-tight">
                        {{ $kullanici->ad . ' ' . $kullanici->soyad }}
                    </div>

                    <!-- Unvan ve Birim (aynı satır) -->
                    <div class="text-sm text-gray-600">
                        <span class="font-medium italic">{{ $kullanici->anaUnvan->baslik }}</span>
                        <span class="mx-1"><i class="bi bi-dot text-base"></i></span>
                        <span>{{ $kullanici->anaBirim->baslik }}</span>
                    </div>

                    <!-- İşletme -->
                    <div class="text-sm">
                        <x-popover :isletme="$kullanici->anaIsletme">
                            <a href="#" class="font-medium text-blue-500 hover:text-blue-600">
                                {{ $kullanici->anaIsletme->baslik }}
                            </a>
                        </x-popover>
                    </div>
                </div>

                <div class="flex space-x-2 ml-auto">
                    <x-button
                        class="!bg-blue-600 hover:!bg-blue-700 focus:!ring-blue-500 text-white rounded-full border-none !text-xs">
                        Mesaj gönder
                    </x-button>
                    <x-button
                        class="!bg-indigo-600 hover:!bg-indigo-700 focus:!ring-indigo-500 text-white rounded-full border-none !text-xs">
                        Takip et
                    </x-button>
                </div>

            </section>
        </header>

        <x-modal id="imageCropModal" class="sm:w-2/4" zIndex="!z-30" title="Kırp">
            <div class="relative h-96">
                <img class="image" class="max-w-full" alt="Yüklenecek görüntü">
            </div>
            <x-button class="mt-4 crop">
                Kırp
            </x-button>
        </x-modal>

        <x-modal id="paylasim-modal" title="Paylaşım" class="w-full max-w-md overflow-y-auto">
            <form action="{{ route('yonetim.kullanici.paylasim.store') }}" method="POST">
                <div class="mb-4 relative">
                    <img src="{{ asset('image/resim-yok.png') }}"
                        class="banner-image max-h-96 w-full object-contain rounded" loading="lazy" alt="">

                    <div class="absolute top-4 left-4">
                        <label for="paylasimKapakResmiYolu"
                            class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-gray-50 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:text-gray-500 disabled:hover:!bg-inherit transition ease-in-out duration-150 cursor-pointer">
                            Resmi değiştir
                        </label>
                    </div>
                </div>
                <input type="file" id="paylasimKapakResmiYolu" name="kapakFotoUrl" class="hidden" accept="image/*">

                <x-file-upload text="/Resim seç ya da buraya bırak" />

                <x-textarea name="aciklama" class="w-full" rows="3" placeholder="Açıklama"></x-textarea>

                <x-button class="paylas  mt-4 !bg-blue-600 hover:!bg-blue-700 focus:!ring-blue-500 text-white border-none">
                    Paylaş
                </x-button>
            </form>
        </x-modal>

        <div class="grid grid-cols-3 gap-4">
            <section class="col-span-2">
                <h3 class="text-lg px-2 font-semibold text-gray-900 uppercase tracking-widest">Paylaşımlar</h3>
                <x-button class="open-modal" data-modal="paylasim-modal">Ekle</x-button>
            </section>

            <section class="col-span-1">
                @if ($kullanici->isletmeler->count())
                    <h3 class="text-lg px-2 font-semibold text-gray-900 uppercase tracking-widest">
                        Çalıştığı İşletmeler
                    </h3>
                @endif

                <div class="space-y-2">
                    @foreach ($kullanici->isletmeler as $detay)
                        <div class="p-4 border rounded shadow-sm bg-white">
                            <x-popover :isletme="$detay->isletme">
                                <a href="#" class="text-base font-medium text-blue-500 hover:text-blue-600">
                                    {{ $detay->isletme->baslik }}
                                </a>
                            </x-popover>

                            <div class="mt-1 text-sm text-gray-600">
                                {{ $detay->unvan->baslik }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        initCropper({
            cropperContainerSelector: '#imageCropModal', // Modal kapsayıcısının seçicisi
            imageSelector: '.image', // Modal içerisindeki görüntü elemanı
            inputSelector: '#paylasimKapakResmiYolu', // Dosya input elemanı
            cropButtonSelector: '.crop', // Crop butonunun seçicisi
            bannerImageSelector: '#paylasim-modal .banner-image', // (Opsiyonel) Önizleme resmi
            modalId: 'imageCropModal', // Modal ID'si
            aspectRatio: 3 / 4, // Örnek olarak 4:3 oranı
            viewMode: 1,
            fillColor: '#fff',
            fileType: 'image/jpeg',
            quality: 1
        });

        function getRoundedCanvas(sourceCanvas) {
            var canvas = document.createElement('canvas');
            var context = canvas.getContext('2d');
            var width = sourceCanvas.width;
            var height = sourceCanvas.height;

            canvas.width = width;
            canvas.height = height;
            context.imageSmoothingEnabled = true;
            context.drawImage(sourceCanvas, 0, 0, width, height);
            context.globalCompositeOperation = 'destination-in';
            context.beginPath();
            context.arc(width / 2, height / 2, Math.min(width, height) / 2, 0, 2 * Math.PI, true);
            context.fill();
            return canvas;
        }

        window.addEventListener('DOMContentLoaded', function() {
            var image = document.querySelector('.image-wrapper img');
            var button = document.querySelector('.pp-crop');
            var result = document.querySelector('.image-wrapper');
            var croppable = false;
            var cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1,
                ready: function() {
                    croppable = true;
                },
            });

            button.onclick = function() {
                var croppedCanvas;
                var roundedCanvas;
                var roundedImage;

                if (!croppable) {
                    return;
                }

                // Crop
                croppedCanvas = cropper.getCroppedCanvas();

                // Round
                roundedCanvas = getRoundedCanvas(croppedCanvas);

                // Show
                roundedImage = document.createElement('img');
                roundedImage.src = roundedCanvas.toDataURL()
                result.innerHTML = '';
                result.appendChild(roundedImage);
            };
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('click', function(event) {
                const target = event.target;

                target.closest('.paylas') && (async () => {
                    event.preventDefault();
                    const form = target.closest('form');
                    const url = form.action;
                    const formData = new FormData(form);

                    const response = await ApiService.fetchData(url, formData, 'POST');

                    if (response.data.success) {
                        UniportalService.alert.success('Paylaşım başarıyla oluşturuldu.');
                    } else {
                        UniportalService.alert.error(
                            'Paylaşım oluşturulurken bir hata oluştu.');
                    }

                })();
            });
        });
    </script>
@endsection
