@extends('layouts.auth')

@section('title', 'Profil')

@section('links')
@endsection

@section('content')
    <section class="p-4">
        <header>
            <div class="bg-gray-100 rounded h-48"></div>

            <section class="flex items-end px-4 -mt-12">
                <div class="shrink-0 border-8 rounded-full   border-white relative">
                    <img src="{{ $kullanici->profilFotoUrl }}" class="size-48 rounded-full" alt="">

                    @if (auth()->id() === $kullanici->kullanicilar_id)
                        <div class="absolute bottom-2 right-2">
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

                    <!-- Takipçi ve Takip Edilen -->
                    <div class="text-sm text-gray-600">
                        <span class="font-medium takipci-count">{{ $kullanici->takipciler->count() }}</span>
                        <span class="mx-1"><i class="bi bi-person text-base"></i></span>

                        <span class="font-medium">{{ $kullanici->takipEdilenler->count() }}</span>
                        <span><i class="bi bi-person-check text-base"></i></span>
                    </div>
                </div>

                @if (auth()->id() !== $kullanici->kullanicilar_id)
                    <div class="flex space-x-2 ml-auto">
                        <x-button
                            class="!bg-blue-600 hover:!bg-blue-700 focus:!ring-blue-500 text-white rounded-full border-none !text-xs">
                            Mesaj gönder
                        </x-button>
                        <x-button data-id="{{ encrypt($kullanici->kullanicilar_id) }}" @class([
                            'takip-et text-white rounded-full border-none !text-xs',
                            '!bg-green-400 hover:!bg-green-500 focus:!ring-green-500' => !$kullanici->takipciler->contains(
                                'kullanicilar_id',
                                auth()->id()),
                            '!bg-rose-600 hover:!bg-rose-700 focus:!ring-rose-500' => $kullanici->takipciler->contains(
                                'kullanicilar_id',
                                auth()->id()),
                        ])>
                            {{ $kullanici->takipciler->contains('kullanicilar_id', auth()->id()) ? 'Takipten çık' : 'Takip et' }}
                        </x-button>
                    </div>
                @endif

            </section>
        </header>

        <x-modal id="imageCropModal" class="w-full sm:max-w-md" zIndex="!z-30" title="Kırp">
            <div class="relative h-96">
                <img class="image" class="max-w-full" alt="Yüklenecek görüntü">
            </div>
            <x-button class="mt-4 crop">
                Kırp
            </x-button>
        </x-modal>

        <x-modal id="paylasim-modal" title="Paylaşım" class="w-full max-w-md overflow-y-auto">
            <form action="{{ route('yonetim.kullanici.paylasim.store') }}" method="POST" enctype="multipart/form-data">
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

        <x-modal id="paylasim-detay-modal" title="Detay" slotClass="h-full"
            class="w-full sm:w-4/5 overflow-y-auto"></x-modal>


        <div class="grid grid-cols-3 gap-4">
            <section class="col-span-2">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg px-2 font-semibold text-gray-900 uppercase tracking-widest">Paylaşımlar</h3>
                    @if (auth()->id() === $kullanici->kullanicilar_id)
                        <x-button class="open-modal" data-modal="paylasim-modal">Ekle</x-button>
                    @endif
                </div>
                <livewire:kullanici-paylasim-component :kullanici="$kullanici" />
            </section>

            <section class="col-span-1">
                @if ($kullanici->isletmeler->count())
                    <h3 class="text-lg px-2 font-semibold text-gray-900 uppercase tracking-widest text-right">
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
                                <span class="font-medium italic">{{ $detay->unvan->baslik }}</span>
                                <span class="mx-1"><i class="bi bi-dot text-base"></i></span>
                                <span>{{ $detay->birim->baslik }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </section>

    <x-modal id="paylasim-yorum-sil-confirm" title="" headerClass="!bg-transparent !text-gray-900"
        headerCloseButton="false" data-yorum-sil-confirm-modal>

        <div class="space-y-8 pt-4">
            <div class="text-center space-y-2">
                <i class="bi bi-exclamation-circle-fill text-6xl text-gs-red"></i>

                <p class="text-sm text-gray-700 w-52 mx-auto">İlgili yorum silinecektir. Yorumu silmek istediğinize emin
                    misiniz?</p>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <x-button class="justify-center close-modal canceled"
                    data-modal="paylasim-yorum-sil-confirm">İptal</x-button>
                <x-button class="!bg-gs-red text-white !border-0 justify-center confirmed">Onayla</x-button>
            </div>
        </div>
    </x-modal>

    <div id="yorumYanitTemplate" class="hidden">
        <div class="flex justify-between items-center bg-gray-100 px-4 py-2" data-yorum-yanit-template>
            <p class="text-sm text-gray-500 mb-0">
                <span class="text-blue-400">@ornekKullanici</span>
                adlı kişiye yanıt veriyorsunuz.
            </p>
            <x-button class="!shadow-none !border-0 !bg-transparent">
                <i class="bi bi-x text-base"></i>
            </x-button>
        </div>
    </div>
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
            viewMode: 0,
            fillColor: '#fff',
            fileType: 'image/jpeg',
            quality: 1
        });

        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('paylasimEklendi', (data) => {
                setTimeout(() => {
                    UniportalService.dropdown.refresh();
                }, 500);
            });

            Livewire.on('paylasimSilindi', (data) => {
                setTimeout(() => {
                    UniportalService.dropdown.refresh();
                }, 500);
            });
            document.addEventListener('click', function(event) {
                const target = event.target;

                target.closest('.paylas') && (async () => {
                    event.preventDefault();
                    const form = target.closest('form');
                    const url = form.action;
                    const formData = new FormData(form);

                    const response = await ApiService.fetchData(url, formData, 'POST');

                    console.log(response);

                    if (response.data.success) {
                        form.reset();
                        UniportalService.modal.hide('paylasim-modal');

                        Livewire.dispatch('paylasimEklendi', {
                            paylasim_id: response.data.id
                        });

                        ApiService.alert.success('Paylaşım başarıyla oluşturuldu.');
                    } else {
                        ApiService.alert.error(
                            'Paylaşım oluşturulurken bir hata oluştu.');
                    }

                })();

                target.closest('.paylasim-sil') && (async () => {
                    const id = target.dataset.id;
                    const url = "{{ route('yonetim.kullanici.paylasim.destroy', '___ID___') }}"
                        .replace('___ID___', id);

                    const response = await ApiService.fetchData(url, {}, 'DELETE');

                    if (response.data.success) {
                        Livewire.dispatch('paylasimSilindi', {
                            paylasim_id: id
                        });
                        ApiService.alert.success('Paylaşım başarıyla silindi.');
                    } else {
                        ApiService.alert.error('Paylaşım silinirken bir hata oluştu.');
                    }
                })();

                target.closest('.paylasim-begen') && (async () => {
                    const id = target.dataset.id;
                    const url =
                        "{{ route('yonetim.kullanici.paylasim.begenToggle', '___ID___') }}"
                        .replace('___ID___', id);

                    const response = await ApiService.fetchData(url, {}, 'PATCH');

                    if (response.data.success) {
                        target.querySelector('span').textContent = response.data.begeni;
                        target.querySelector('i').classList.toggle('bi-heart-fill');
                        target.querySelector('i').classList.toggle('bi-heart');
                    } else {
                        ApiService.alert.error('Paylaşım beğenilirken bir hata oluştu.');
                    }
                })();

                target.closest('.open-paylasim-detay-modal') && (async () => {
                    const id = target.closest('.open-paylasim-detay-modal').dataset.id;
                    const url = "{{ route('yonetim.kullanici.paylasim.show', '___ID___') }}"
                        .replace('___ID___', id);

                    const response = await ApiService.fetchData(url, {}, 'GET');

                    if (response.data.success) {
                        const modal = document.querySelector('#paylasim-detay-modal');
                        modal.querySelector('[data-slot]').innerHTML = response.data.html;
                        UniportalService.modal.show('paylasim-detay-modal');
                    } else {
                        ApiService.alert.error(
                            'Paylaşım detayları getirilirken bir hata oluştu.');
                    }
                })();

                event.target.matches('.paylasim-yorum-begen') && (async () => {
                    const BUTTON = event.target;
                    const YORUM_ID = BUTTON.dataset.yorumId;
                    const PAYLASIM_ID = BUTTON.dataset.paylasimId;

                    const URL =
                        "{{ route('yonetim.kullanici.paylasim.yorum.begenToggle', ['___PAYLASIM_ID___', '___YORUM_ID___']) }}"
                        .replace(
                            '___PAYLASIM_ID___', PAYLASIM_ID).replace('___YORUM_ID___',
                            YORUM_ID);

                    const RESPONSE = await ApiService.fetchData(URL, {}, 'PATCH');

                    if (RESPONSE.data.success) {
                        BUTTON.querySelector('i').classList.toggle('bi-heart-fill');
                        BUTTON.querySelector('i').classList.toggle('bi-heart');
                        BUTTON.querySelector('i').classList.toggle('text-rose-500');

                        const BEGENI_WRAPPER = BUTTON.closest('[data-yorum-wrapper]')
                            .querySelector(
                                '[data-yorum-begeni-wrapper]');
                        const BEGENI_COUNT = BEGENI_WRAPPER.querySelector(
                            '[data-yorum-begeni-count]');

                        BEGENI_COUNT && (BEGENI_COUNT.textContent = RESPONSE.data.begeni);

                        RESPONSE.data.begeni > 0 ? BEGENI_WRAPPER.classList.remove('hidden') :
                            BEGENI_WRAPPER.classList.add('hidden');

                    } else {
                        ApiService.alert.error(RESPONSE.message);
                    }
                })();

                event.target.matches('.paylasim-yorum-submit-button') && (async () => {
                    const FORM = event.target.closest('form');
                    const TEXTAREA = FORM.querySelector('textarea[name=yorum]');

                    if (TEXTAREA.value.length === 0) {
                        ApiService.alert.error('Yorum alanı boş bırakılamaz.');
                        return;
                    }

                    const URL = FORM.action;
                    const DATA = new FormData(FORM);

                    const RESPONSE = await ApiService.fetchData(URL, DATA, 'POST');

                    if (RESPONSE.data.success) {
                        TEXTAREA.value = '';
                        TEXTAREA.style.height = '38px';

                        Livewire.dispatch('yorumEklendi', {
                            eklenenYorum: RESPONSE.data.yorum,
                            tip: RESPONSE.data.tip
                        });
                        // setTimeout(() => {
                        //     window.UniportalService.dropdown.refresh();
                        // }, 400);

                        ApiService.alert.success(RESPONSE.data.message);

                        FORM.querySelector('input[name=etkinlik_yorumlari_id]')?.remove();
                        FORM.querySelector('[data-yorum-yanit-template]')?.remove();
                        FORM.dataset.heightAdjusted && delete FORM.dataset.heightAdjusted;

                        showMoreWrapper();
                    } else {
                        ApiService.alert.error(RESPONSE.message);
                    }
                })();

                event.target.closest('.paylasim-yorum-yanit-goster') && (async () => {
                    const BUTTON = event.target.closest('.paylasim-yorum-yanit-goster');
                    const YORUM_WRAPPER = BUTTON.closest('[data-yorum-wrapper]');
                    const YANIT_WRAPPER = YORUM_WRAPPER.querySelector(
                        '[data-yorum-yanit-wrapper]');

                    YANIT_WRAPPER.classList.toggle('hidden');
                })();

                const replyButton = event.target.closest('.paylasim-yorum-yanitla-button');
                if (replyButton) {
                    const modal = replyButton.closest('[data-modal]');
                    const modalContent = modal.querySelector('[data-modal-content]');
                    const form = modal.querySelector('[data-paylasim-yorum-form]');

                    // Butonun bulunduğu yorum wrapper'ının konumunu alıp, modal içerik içinde doğru konuma scroll ediyoruz.
                    yorumWrappers = modalContent.querySelectorAll('[data-yorum-wrapper]');
                    yorumWrappers.forEach(wrapper => wrapper.firstElementChild.classList.remove(
                        'bg-gray-100'));

                    const yorumWrapper = replyButton.closest('[data-yorum-wrapper]').firstElementChild;
                    yorumWrapper.classList.add('bg-gray-100');

                    const yorumRect = yorumWrapper.getBoundingClientRect();
                    const containerRect = modalContent.getBoundingClientRect();
                    modalContent.scrollTop = (yorumRect.top - containerRect.top) + modalContent.scrollTop;

                    // Yorum textarea'sına odaklanıyoruz.
                    form.querySelector('textarea[name=yorum]').focus();

                    // Önceden eklenmiş yanıt inputu veya şablon varsa temizliyoruz.
                    form.querySelector('input[name=etkinlik_yorumlari_id]')?.remove();
                    form.querySelector('[data-yorum-yanit-template]')?.remove();

                    // Gizli input oluşturup, butondan gelen yanıt ID'sini ekliyoruz.
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'etkinlik_yorumlari_id';
                    hiddenInput.value = replyButton.dataset.yorumId;

                    // Şablonu klonlayıp, kullanıcı adını güncelliyoruz.
                    const template = document.getElementById('yorumYanitTemplate');
                    const replyElement = template.querySelector('[data-yorum-yanit-template]').cloneNode(
                        true);
                    const usernameSpan = replyElement.querySelector('span.text-blue-400');
                    if (usernameSpan) usernameSpan.textContent = `@${replyButton.dataset.sender}`;

                    // Modal content'in orijinal yüksekliğini saklıyoruz.
                    if (!modalContent.dataset.originalHeight) {
                        modalContent.dataset.originalHeight = modalContent.clientHeight;
                    }
                    const originalHeight = parseInt(modalContent.dataset.originalHeight, 10);

                    // Klonlanmış elemanı forma ekleyip, modal yüksekliğini ayarlıyoruz.
                    const insertedReply = form.insertAdjacentElement('afterbegin', replyElement);
                    if (!form.dataset.heightAdjusted) {
                        modalContent.style.height = (originalHeight - insertedReply.clientHeight) + 'px';
                        form.dataset.heightAdjusted = 'true';
                    }

                    // Gizli inputu formun sonuna ekliyoruz.
                    form.appendChild(hiddenInput);

                    // Eklenen elementteki kapatma butonuna işlev kazandırıyoruz.
                    const closeBtn = insertedReply.querySelector('button');
                    if (closeBtn) {
                        closeBtn.addEventListener('click', () => {
                            insertedReply.remove();
                            hiddenInput.remove();
                            yorumWrapper.classList.remove('bg-gray-100');
                            modalContent.style.height = originalHeight + 'px';
                            delete form.dataset.heightAdjusted;
                        });
                    }
                }

                event.target.closest('.paylasim-yorum-sil') && (async () => {
                    const BUTTON = event.target.closest('.paylasim-yorum-sil');
                    const YORUM_ID = BUTTON.dataset.yorumId;
                    const PAYLASIM_ID = BUTTON.dataset.paylasimId;

                    const confirmResult = await modalConfirm();

                    if (!confirmResult)
                        return;

                    const URL =
                        "{{ route('yonetim.kullanici.paylasim.yorum.destroy', ['___PAYLASIM_ID___', '___YORUM_ID___']) }}"
                        .replace('___PAYLASIM_ID___', PAYLASIM_ID).replace('___YORUM_ID___',
                            YORUM_ID);

                    const RESPONSE = await ApiService.fetchData(URL, {}, 'DELETE');

                    if (RESPONSE.data.success) {
                        Livewire.dispatch('yorumSilindi', {
                            silinenYorumId: YORUM_ID,
                        });

                        ApiService.alert.success(RESPONSE.data.message);
                    } else {
                        ApiService.alert.error(RESPONSE.message);
                    }
                })();

                target.closest('.takip-et') && (async () => {
                    const ID = target.dataset.id;
                    const URL = "{{ route('yonetim.kullanici.takip.toggle', '___ID___') }}"
                        .replace('___ID___', ID);

                    const RESPONSE = await ApiService.fetchData(URL, {}, 'POST');

                    if (RESPONSE.data.success) {

                        if (target.textContent == 'Takip et') {
                            target.textContent = 'Takipten çık';
                            target.classList.remove('!bg-green-400', 'hover:!bg-green-500',
                                'focus:!ring-green-500');
                            target.classList.add('!bg-rose-600', 'hover:!bg-rose-700',
                                'focus:!ring-rose-500');
                        } else {
                            target.textContent = 'Takip et';
                            target.classList.remove('!bg-rose-600', 'hover:!bg-rose-700',
                                'focus:!ring-rose-500');
                            target.classList.add('!bg-green-400', 'hover:!bg-green-500',
                                'focus:!ring-green-500');
                        }

                        document.querySelector('.takipci-count').textContent = RESPONSE.data
                            .count;

                        ApiService.alert.success(RESPONSE.data.message);
                    } else {
                        ApiService.alert.error(RESPONSE.message);
                    }
                })();
            });
        });
    </script>
@endsection
