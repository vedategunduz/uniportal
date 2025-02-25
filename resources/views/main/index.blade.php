@extends('layouts.app')

@section('title', 'Anasayfa')

@section('content')
    <livewire:etkinlik-component />

    <div class="text-center py-2">
        <x-button id="tikla" class="">Daha fazla</x-button>
    </div>

    <x-modal id="etkinlik-modal" title="Detay" slotClass="h-full" class="w-full sm:w-4/5 overflow-y-auto">

    </x-modal>

@endsection

@section('scripts')
    <script>
        document.getElementById('tikla').addEventListener('click', function() {
            Livewire.dispatch('showMore');
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

                    focus && MODAL.querySelector('textarea[name=yorum]').focus();

                    document.querySelectorAll('.show-more-text').forEach((element) => {
                        element.addEventListener('click', function() {
                            element.classList.toggle('line-clamp-3');
                        });
                    });
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

            event.target.closest('.etkinlik-yorum-begen') && (async () => {
                const BUTTON = event.target.closest('.etkinlik-yorum-begen');
                const YORUM_ID = BUTTON.dataset.yorumId;
                const ETKINLIK_ID = BUTTON.dataset.etkinlikId;

                console.log(YORUM_ID, ETKINLIK_ID);

                const URL =
                    "{{ route('etkinlikler.yorum.begenToggle', ['___ETKINLIK_ID___', '___YORUM_ID___']) }}"
                    .replace(
                        '___ETKINLIK_ID___', ETKINLIK_ID).replace('___YORUM_ID___', YORUM_ID);

                const RESPONSE = await ApiService.fetchData(URL, {}, 'PATCH');

                // if (RESPONSE.data.success) {
                //     event.target.closest('.etkinlik-yorum-begen').innerHTML = RESPONSE.data.html;
                // } else {
                //     ApiService.alert.error(RESPONSE.message);
                // }
            })();
        });

        document.addEventListener('input', function(event) {
            if (!event.target.matches('textarea'))
                return;


            const textarea = event.target;

            if (textarea.scrollHeight <= 100)
                return;

            textarea.style.height = textarea.scrollHeight + 'px';
        })
    </script>
@endsection
