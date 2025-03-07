@extends('layouts.auth')

@section('title', 'Kampanya Yönetimi')

@section('content')
    @php
        use Carbon\Carbon;

        $tarih = Carbon::parse($etkinlik->etkinlikBaslamaTarihi)->translatedFormat('d F Y H:i');
        $tarih2 = Carbon::parse($etkinlik->etkinlikBitisTarihi)->translatedFormat('d F Y H:i');
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <article class="md:col-span-2 editor-gosterim">
            <header class="shadow-md rounded p-4">
                <h1 class="font-extrabold">{{ $etkinlik->baslik }}</h1>

                <div class="p-4 border rounded mb-4">
                    <p class="flex items-center gap-2">
                        <span class="inline-block px-4 p-2 bg-indigo-50 text-indigo-700 rounded">
                            <i class="bi bi-clock-history"></i>
                        </span>
                        <span>Kampanya Tarihleri</span>
                    </p>
                    <p class="m-0">
                        <time datetime="{{ $tarih }}">{{ $tarih }}</time> -
                        <time datetime="{{ $tarih2 }}">{{ $tarih2 }}</time>
                    </p>
                </div>

                <div role="group" class="flex flex-wrap gap-2" aria-label="Etkinlik işlemleri">
                    @auth
                        @php
                            $kontrol = !$etkinlik->katilimcilar->contains('kullanicilar_id', auth()->id());
                        @endphp
                        <x-button
                            class="!shadow-none px-14 !border-none !bg-green-400 hover:!bg-green-400 text-white etkinlik-katil-modal"
                            :disabled="!$kontrol" data-id="{{ encrypt($etkinlik->etkinlikler_id) }}">
                            <i class="bi bi-person-plus-fill text-base"></i>
                            <span class="text-xs ms-1 capitalize">
                                @if ($kontrol)
                                    Katıl
                                @else
                                    Zaten katıldın
                                @endif
                            </span>
                        </x-button>
                    @endauth
                    <x-button class="!shadow-none etkinlik-begen" data-id="{{ encrypt($etkinlik->etkinlikler_id) }}"
                        :disabled="!auth()->check()">
                        <div class="flex items-center gap-2">
                            <i @class([
                                'bi text-red-500 text-base',
                                'bi-heart-fill' => $etkinlik->begeni->contains(
                                    'kullanicilar_id',
                                    auth()->id()),
                                'bi-heart' => !$etkinlik->begeni->contains('kullanicilar_id', auth()->id()),
                            ])></i>
                            <span>{{ $etkinlik->begeni->count() }}</span>
                        </div>
                    </x-button>
                    <x-button class="!shadow-none">
                        <div class="flex items-center gap-2">
                            <i class="bi bi-chat-left-text !text-blue-500 text-base"></i>
                            <span>{{ $etkinlik->yorum->count() }}</span>
                        </div>
                    </x-button>
                    <x-button>
                        <i class="bi bi-calendar-plus text-base text-green-400"></i>
                        <span class="ms-2">Takvime Ekle</span>
                    </x-button>
                    <x-button class="ml-auto share-btn">
                        <i class="bi bi-share-fill text-base"></i>
                    </x-button>
                </div>
            </header>

            <section>
                <p class="text-sm">{!! $etkinlik->aciklama !!}</p>
            </section>

            <footer data-modal>
                <livewire:etkinlik-yorum-component :key="encrypt($etkinlik->etkinlikler_id)" :etkinlikid="$etkinlik->etkinlikler_id" />

                <!-- Yorum Girişi -->
                <form action="{{ route('etkinlikler.yorum.store', [encrypt($etkinlik->etkinlikler_id)]) }}" class="border-t"
                    method="POST" data-etkinlik-yorum-form>

                    <section class="py-4">
                        @if (auth()->user()->anaIsletme->tur->isletme_turleri_id == 1)
                            <div class="ml-auto flex items-center">
                                <x-switch class="kamu-yorumlari-switch">
                                    Kamu yorumları ({{ $etkinlik->yorum->where('yorum_tipi', 1)->count() }})
                                </x-switch>
                            </div>
                        @endif
                    </section>

                    <section class="flex items-center justify-between gap-2 py-2">
                        <!-- Yorum textarea -->
                        <x-textarea rows="1" name="yorum" class="custom-scroll max-h-24" :disabled="!auth()->check() || !$etkinlik->yorumDurumu">
                            @if (auth()->check())
                                @if (!$etkinlik->yorumDurumu)
                                    Yoruma kapalıdır.
                                @endif
                            @else
                                Yorum yapabilmek için giriş yapmalısınız.
                            @endif
                        </x-textarea>

                        <!-- Yorum yap butonu -->
                        <x-button class="shrink-0 etkinlik-yorum-submit-button" :disabled="!auth()->check() || !$etkinlik->yorumDurumu">
                            Yorum yap
                        </x-button>
                    </section>
                </form>
            </footer>
        </article>
        <aside class="col-span-1 md:border-l p-4 space-y-4">
            <h2>Tarafından düzenlendi</h2>
            <div class="flex items-center gap-2">
                <img src="{{ $etkinlik->isletme->logoUrl }}" class="rounded size-12"
                    alt="{{ $etkinlik->isletme->baslik }} logosu">

                <a href="#" class="all-unset">{{ $etkinlik->isletme->baslik }}</a>
            </div>

            <h2>Konum</h2>
            <div class="iframe">
                {!! $etkinlik->harita !!}
            </div>
        </aside>
    </div>


    <x-modal id="etkinlik-yorum-sil-confirm" title="" headerClass="!bg-transparent !text-gray-900"
        headerCloseButton="false" data-yorum-sil-confirm-modal>

        <div class="space-y-8 pt-4">
            <div class="text-center space-y-2">
                <i class="bi bi-exclamation-circle-fill text-6xl text-gs-red"></i>

                <p class="text-sm text-gray-700 w-52 mx-auto">İlgili yorum silinecektir. Yorumu silmek istediğinize emin
                    misiniz?</p>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <x-button class="justify-center close-modal canceled"
                    data-modal="etkinlik-yorum-sil-confirm">İptal</x-button>
                <x-button class="!bg-gs-red text-white !border-0 justify-center confirmed">Onayla</x-button>
            </div>
        </div>
    </x-modal>

    <div id="yorumYanitTemplate" class="hidden">
        <div class="flex justify-between items-center bg-gray-100 px-4 py-2" data-yorum-yanit-template>
            <p class="text-sm text-gray-500">
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
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('click', function(event) {
                event.target.closest(".share-btn") && (async () => {
                    if (navigator.share) try {
                        await navigator.share({
                            title: document.title,
                            url: window.location.href
                        }), console.log("Paylaşım başarılı!")
                    } catch (a) {
                        console.error("Paylaşım başarısız:", a)
                    } else alert("Tarayıcınız paylaşım desteği sunmuyor.")
                })();

                event.target.closest('.etkinlik-begen') && (async () => {
                    const BUTTON = event.target.closest('.etkinlik-begen');
                    const ETKINLIK_ID = BUTTON.dataset.id;

                    const URL =
                        "{{ route('etkinlikler.begenToggle', '___ETKINLIK_ID___') }}"
                        .replace('___ETKINLIK_ID___', ETKINLIK_ID);

                    const RESPONSE = await ApiService.fetchData(URL, {}, 'PATCH');

                    if (RESPONSE.data.success) {
                        BUTTON.querySelector('span').textContent = RESPONSE.data.begeni;
                        BUTTON.querySelector('i').classList.toggle('bi-heart-fill');
                        BUTTON.querySelector('i').classList.toggle('bi-heart');
                        // BUTTON.querySelector('i').classList.toggle('text-red-500');

                    } else {
                        ApiService.alert.error(RESPONSE.message);
                    }
                })();

                event.target.matches('.etkinlik-yorum-begen') && (async () => {
                    const BUTTON = event.target;
                    const YORUM_ID = BUTTON.dataset.yorumId;
                    const ETKINLIK_ID = BUTTON.dataset.etkinlikId;

                    const URL =
                        "{{ route('etkinlikler.yorum.begenToggle', ['___ETKINLIK_ID___', '___YORUM_ID___']) }}"
                        .replace(
                            '___ETKINLIK_ID___', ETKINLIK_ID).replace('___YORUM_ID___',
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

                event.target.matches('.etkinlik-yorum-submit-button') && (async () => {
                    const FORM = event.target.closest('form');
                    const TEXTAREA = FORM.querySelector('textarea[name=yorum]');

                    if (TEXTAREA.value.length === 0) {
                        ApiService.alert.error('Yorum alanı boş bırakılamaz.');
                        return;
                    }

                    const URL = FORM.action;
                    const DATA = new FormData(FORM);

                    const kamuYorumuSwitch = document.querySelector('.kamu-yorumlari-switch');
                    DATA.append('yorum_tipi', kamuYorumuSwitch?.checked ? 1 : 0);

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

                        showMoreText();


                    } else {
                        ApiService.alert.error(RESPONSE.message);
                    }
                })();

                event.target.closest('.etkinlik-yorum-yanit-goster') && (async () => {
                    const BUTTON = event.target.closest('.etkinlik-yorum-yanit-goster');
                    const YORUM_WRAPPER = BUTTON.closest('[data-yorum-wrapper]');
                    const YANIT_WRAPPER = YORUM_WRAPPER.querySelector(
                        '[data-yorum-yanit-wrapper]');

                    YANIT_WRAPPER.classList.toggle('hidden');
                })();

                const replyButton = event.target.closest('.etkinlik-yorum-yanitla-button');
                if (replyButton) {
                    const modal = replyButton.closest('[data-modal]');
                    const modalContent = modal;
                    const form = modal.querySelector('[data-etkinlik-yorum-form]');

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

                    // Klonlanmış elemanı forma ekleyip, modal yüksekliğini ayarlıyoruz.
                    const insertedReply = form.insertAdjacentElement('afterbegin', replyElement);

                    // Gizli inputu formun sonuna ekliyoruz.
                    form.appendChild(hiddenInput);

                    // Eklenen elementteki kapatma butonuna işlev kazandırıyoruz.
                    const closeBtn = insertedReply.querySelector('button');
                    if (closeBtn) {
                        closeBtn.addEventListener('click', () => {
                            insertedReply.remove();
                            hiddenInput.remove();
                            yorumWrapper.classList.remove('bg-gray-100');
                        });
                    }
                }

                event.target.closest('.etkinlik-yorum-sil') && (async () => {
                    const BUTTON = event.target.closest('.etkinlik-yorum-sil');
                    const YORUM_ID = BUTTON.dataset.yorumId;
                    const ETKINLIK_ID = BUTTON.dataset.etkinlikId;

                    const confirmResult = await modalConfirm();

                    if (!confirmResult)
                        return;

                    const URL =
                        "{{ route('etkinlikler.yorum.destroy', ['___ETKINLIK_ID___', '___YORUM_ID___']) }}"
                        .replace('___ETKINLIK_ID___', ETKINLIK_ID).replace('___YORUM_ID___',
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

                event.target.closest('.etkinlik-katil-modal') && (async () => {
                    const BUTTON = event.target.closest('.etkinlik-katil-modal');
                    const ETKINLIK_ID = BUTTON.dataset.id;

                    const URL =
                        "{{ route('etkinlikler.katil.show', '___ETKINLIK_ID___') }}".replace(
                            '___ETKINLIK_ID___', ETKINLIK_ID);

                    const RESPONSE = await ApiService.fetchData(URL, {}, 'GET');

                    if (RESPONSE.data.success) {
                        const MODAL = document.getElementById('etkinlik-katil-modal');

                        MODAL.querySelector('[data-slot]').innerHTML = RESPONSE.data.html;

                        modalShow(MODAL);

                        window.UniportalService.dropdown.refresh();
                    } else {
                        ApiService.alert.error(RESPONSE.message);
                    }
                })();

                event.target.closest('.etkinlik-katil-submit-button') && (async () => {
                    event.preventDefault();

                    const FORM = event.target.closest('form');
                    const CHECKBOX = FORM.querySelector('input[name=katilimSartlari]');

                    if (!CHECKBOX.checked) {
                        ApiService.alert.error('Katılım şartlarını kabul etmelisiniz.');
                        return;
                    }

                    const URL = FORM.action;
                    const DATA = new FormData(FORM);

                    const RESPONSE = await ApiService.fetchData(URL, DATA, 'POST');

                    if (RESPONSE.data.success) {
                        ApiService.alert.success(RESPONSE.data.message);

                        const modal = document.getElementById('etkinlik-katil-modal');

                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    } else {
                        ApiService.alert.error(RESPONSE.message);
                    }
                })();
            });
        });

        function modalConfirm() {
            return new Promise((resolve, reject) => {
                const MODAL = document.getElementById('etkinlik-yorum-sil-confirm');
                const CONFIRM_BUTTON = MODAL.querySelector('.confirmed');
                const CANCEL_BUTTON = MODAL.querySelector('.canceled');

                modalShow(MODAL);

                CONFIRM_BUTTON.addEventListener('click', () => {
                    modalClose(MODAL);
                    resolve(true);
                });
                CANCEL_BUTTON.addEventListener('click', () => {
                    resolve(false);
                });
            });
        }

        document.addEventListener('change', function(event) {
            event.target.closest('.kamu-yorumlari-switch') && (() => {
                Livewire.dispatch('toggleKamuYorumlari');
            })();
        });
    </script>
@endsection
