@extends('layouts.app')

@section('title', 'Anasayfa')

@section('banner')
    <div class="relative h-[calc(100vh-60px)]">
        <img src="https://placeholder.pagebee.io/api/random/1920/1080" class="w-full h-full object-cover">

        <div class="absolute w-full h-full top-0 left-0 mx-auto">
            <div class="max-w-screen-xl flex flex-col justify-center h-full mx-auto">
                <div class="flex">
                    <div class="bg-white/0 p-4 rounded shadow space-y-4">
                        <h4 class="text-2xl w-96">Kamu ile İş Dünyası Tek Platformda Buluşuyor!</h4>
                        <p class="w-96">
                            Kamu ve özel sektör arasındaki köprüyü kuruyoruz! Doğru firmalar, doğru projeler ve güçlü
                            işbirlikleri için tek adresiniz. Siz de {{ config('app.name') }} ailesine katılın!
                        </p>
                        <x-button>
                            Bize katılın
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="space-y-4">
        <livewire:etkinlik-component />
        <livewire:etkinlik-kampanya-component />
    </section>

    <x-modal id="etkinlik-modal" title="Detay" slotClass="h-full" class="w-full sm:w-4/5 overflow-y-auto"></x-modal>

    <x-modal id="sikayet-modal" title="Şikayet et" visibility="hidden">
        <x-textarea rows="3"></x-textarea>
    </x-modal>

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


    <div id="alerts" class="fixed right-4 bottom-4 z-30 space-y-2"></div>

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

@section('stats')
    <section class="bg-white/75 py-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 max-w-screen-xl w-full mx-auto text-center">
            <div class="flex flex-col items-center justify-center h-full">
                <span class="text-3xl font-bold text-gray-700 stats-counter" data-counter-target="1234">0</span>
                <span class="text-gray-600 text-sm">Etkinlik</span>
            </div>
            <div class="flex flex-col items-center justify-center h-full">
                <span class="text-3xl font-bold text-gray-700 stats-counter" data-counter-target="1234">0</span>
                <span class="text-gray-600 text-sm">Üye</span>
            </div>
            <div class="flex flex-col items-center justify-center h-full">
                <span class="text-3xl font-bold text-gray-700 stats-counter" data-counter-target="1234">0</span>
                <span class="text-gray-600 text-sm">İşletme</span>
            </div>
            <div class="flex flex-col items-center justify-center h-full">
                <span class="text-3xl font-bold text-gray-700 stats-counter" data-counter-target="1234">0</span>
                <span class="text-gray-600 text-sm">Kampanya</span>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener("livewire:update", () => {
            console.log('Livewire updated');
            window.UniportalService.dropdown.refresh();
        });

        document.addEventListener('click', function(event) {
            event.target.closest('.open-etkinlik-detay-modal') && (async () => {
                const id = event.target.closest('.open-etkinlik-detay-modal').dataset.id;
                const focus = event.target.closest('.open-etkinlik-detay-modal').dataset.focus;

                const URL = "{{ route('etkinlikler.show', '___ID___') }}".replace(
                    '___ID___', id);

                const RESPONSE = await ApiService.fetchData(URL, {}, 'GET');

                const MODAL = document.getElementById('etkinlik-modal');

                if (RESPONSE.data.success) {
                    MODAL.querySelector('[data-slot]').innerHTML = RESPONSE.data.html;

                    modalShow(MODAL);

                    window.UniportalService.dropdown.refresh();

                    focus && MODAL.querySelector('textarea[name=yorum]').focus();

                    showMoreText();
                } else {
                    ApiService.alert.error(RESPONSE.message);
                }
            })();

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
                console.log(BUTTON);
                const YORUM_ID = BUTTON.dataset.yorumId;
                const ETKINLIK_ID = BUTTON.dataset.etkinlikId;

                console.log(YORUM_ID, ETKINLIK_ID);

                const URL =
                    "{{ route('etkinlikler.yorum.begenToggle', ['___ETKINLIK_ID___', '___YORUM_ID___']) }}"
                    .replace(
                        '___ETKINLIK_ID___', ETKINLIK_ID).replace('___YORUM_ID___', YORUM_ID);

                const RESPONSE = await ApiService.fetchData(URL, {}, 'PATCH');

                if (RESPONSE.data.success) {
                    BUTTON.querySelector('i').classList.toggle('bi-heart-fill');
                    BUTTON.querySelector('i').classList.toggle('bi-heart');
                    BUTTON.querySelector('i').classList.toggle('text-rose-500');

                    const BEGENI_WRAPPER = BUTTON.closest('[data-yorum-wrapper]').querySelector(
                        '[data-yorum-begeni-wrapper]');
                    const BEGENI_COUNT = BEGENI_WRAPPER.querySelector('[data-yorum-begeni-count]');

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
                const YANIT_WRAPPER = YORUM_WRAPPER.querySelector('[data-yorum-yanit-wrapper]');

                YANIT_WRAPPER.classList.toggle('hidden');
            })();

            const replyButton = event.target.closest('.etkinlik-yorum-yanitla-button');
            if (replyButton) {
                const modal = replyButton.closest('[data-modal]');
                const modalContent = modal.querySelector('[data-modal-content]');
                const form = modal.querySelector('[data-etkinlik-yorum-form]');

                // Butonun bulunduğu yorum wrapper'ının konumunu alıp, modal içerik içinde doğru konuma scroll ediyoruz.
                yorumWrappers = modalContent.querySelectorAll('[data-yorum-wrapper]');
                yorumWrappers.forEach(wrapper => wrapper.firstElementChild.classList.remove('bg-gray-100'));

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
                const replyElement = template.querySelector('[data-yorum-yanit-template]').cloneNode(true);
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

            event.target.closest('.etkinlik-yorum-sil') && (async () => {
                const BUTTON = event.target.closest('.etkinlik-yorum-sil');
                const YORUM_ID = BUTTON.dataset.yorumId;
                const ETKINLIK_ID = BUTTON.dataset.etkinlikId;

                const confirmResult = await modalConfirm();

                if (!confirmResult)
                    return;

                const URL =
                    "{{ route('etkinlikler.yorum.destroy', ['___ETKINLIK_ID___', '___YORUM_ID___']) }}"
                    .replace('___ETKINLIK_ID___', ETKINLIK_ID).replace('___YORUM_ID___', YORUM_ID);

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

        document.addEventListener('input', function(event) {
            if (!event.target.matches('textarea'))
                return;

            const textarea = event.target;

            if (textarea.value.length === 0)
                return textarea.style.height = '38px';

            if (textarea.scrollHeight <= 40)
                return;

            textarea.style.height = textarea.scrollHeight + 'px';
        })
    </script>
@endsection
