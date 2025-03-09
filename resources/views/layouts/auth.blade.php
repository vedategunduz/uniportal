<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kullanici Paneli')</title>
    @yield('links')
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap.css">


    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>

    {{-- <link rel="stylesheet" href="{{ asset('css/customDataTable.css') }}"> --}}
    {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> --}}

    {{-- Bootstrap icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/glocal.css') }}">
</head>

<body>
    <x-menu.head />

    <div class="items-start lg:flex">
        <x-menu />

        <main class="w-full lg:w-[calc(100vw-320px)] bg-white">
            @yield('content')
        </main>
    </div>

    <div id="modal" class="custom-modal hidden">
        <section class="modal-outside close-modal" data-modal="modal"></section>

        <section id="modal-content" class="modal-content max-w-screen-md rounded max-h-screen hidden-scroll"></section>
    </div>

    <div id="alert-modal" class="alert-custom-modal hidden">
        <section class="modal-outside close-modal" data-modal="alert-modal"></section>

        <section id="alert-modal-content" class="modal-content max-w-screen-md rounded max-h-screen hidden-scroll">
        </section>
    </div>

    <div id="alerts" class="fixed right-4 bottom-4 z-30 space-y-2"></div>

    <div class="aside-modal" id="aside-modal">
        <div class="aside-modal-outside close-aside-modal" data-modal="aside-modal"></div>

        <div class="aside-modal-content overflow-auto hidden-scroll w-full md:w-1/2 lg:w-1/3">
            <header class="flex flex-col sticky top-0 z-20 border-b">
                <div class="flex items-center justify-between bg-blue-700 text-white px-6 py-2">
                    <div>
                        <h2 class="font-medium text-lg"> Mesajlar </h2>
                    </div>
                    <button class="close-aside-modal" data-modal="aside-modal">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 pointer-events-none">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="px-6 py-4 bg-white">
                    <div class="flex items-stretch">
                        <div class="relative w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search size-4 absolute top-1/2 -translate-y-1/2 left-3"
                                viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                            </svg>
                            <input type="text" id="search-channel"
                                class="bg-gray-50 indent-7 border border-r-0 rounded-r-none border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-2"
                                placeholder="Kanal ara" />
                        </div>
                        <x-button
                            class="open-modal searchNotSifirla text-nowrap rounded-l-none !bg-gray-50 text-gray-900 z-10"
                            data-modal="modal-yeni-kanal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-chat-dots-fill" viewBox="0 0 16 16">
                                <path
                                    d="M16 8c0 3.866-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7M5 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0m4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                            </svg>
                        </x-button>
                    </div>
                </div>
            </header>

            <section id="aside-modal-content-body" class="flex flex-col">
                <div class="flex flex-col">
                    <livewire:kanal-component />
                </div>
            </section>
        </div>
    </div>

    <x-modal id="modal-yeni-kanal" title="Yeni Kanal" class="w-full sm:w-3/5 md:max-w-md lg:max-w-sm kanal-modal">
        <form action="" class="space-y-2">
            <section id="mesaj-kanal-katilimcilar"
                class="flex flex-nowrap items-center gap-2 w-full overflow-x-auto pb-2 custom-scroll"></section>

            <x-relative-input label="Kanal adı" type="text" name="baslik" class="py-2" placeholder=" " />

            <div class="relative">
                <x-relative-input label="Kullanıcı ara" type="text" name="mesaj-kanal-katilimci-search"
                    class="py-2" placeholder=" " />

                <section id="mesaj-kanal-katilimci-search-result"
                    class="bg-white px-4 py-2 shadow-sm rounded w-full hidden flex-col absolute top-full left-0 z-20 space-y-2 overflow-y-auto max-h-48 custom-scroll">
                </section>
            </div>

            <div class="">
                <x-switch name="sadeceYonetici" class="peer">
                    Sadece yöneticiler mesaj gönderebilir.
                </x-switch>
            </div>

            <x-button type="submit" class="!w-full !justify-center !bg-emerald-500 !text-white"
                id="kanal-olustur-submit-button">
                Kanal Oluştur
            </x-button>
        </form>
    </x-modal>

    {{-- <script src="{{ asset('js/data-table.js') }}"></script> --}}
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        function dropdownTrigger(triggerEl) {
            const targetEl = document.getElementById(triggerEl.getAttribute(
                'data-dropdown-toggle'));
            new Dropdown(targetEl, triggerEl);
        }

        document.addEventListener('DOMContentLoaded', function() {

            window.Echo.channel(`mesaj-kanallari`)
                .listen('KanalOlusturuldu', (event) => {
                    subscribeToKanal(event.kanal.mesaj_kanallari_id);
                })
                .listen('KanalGuncellendi', (event) => {
                    subscribeToKanal(event.kanal.mesaj_kanallari_id);
                });

            function subscribeToKanal(kanalId) {
                window.Echo.channel(`mesaj-kanal.${kanalId}`)
                    .listen('MesajOlusturuldu', (event) => {
                        const ACCORDION_HEADERS = document.querySelector(
                            '.aside-message-accordion-button.active');

                        if (!ACCORDION_HEADERS) return;


                        console.log(ACCORDION_HEADERS);

                        const kanalId = ACCORDION_HEADERS.dataset.channelId;

                        const ACCORDION_BODY = ACCORDION_HEADERS.parentElement.nextElementSibling;
                        ACCORDION_BODY.style.maxHeight = ACCORDION_BODY.scrollHeight + 'px';

                        const MESAJ_CONTAINER = ACCORDION_BODY.querySelector('.mesaj-container');

                        setTimeout(() => {
                            MESAJ_CONTAINER.scrollTo(0, MESAJ_CONTAINER.scrollHeight);
                        }, 2000);

                        (async () => {
                            const URL = "{{ route('yonetim.mesaj.okundu', ['kanalId' => '___ID___']) }}"
                                .replace('___ID___', kanalId);
                            const RESPONSE = await ApiService.fetchData(URL, {}, "DELETE");
                            if (RESPONSE.status === 200) {
                                // COUNT.remove();
                            } else {
                                ApiService.alert.error("Bir hata oluştu");
                            }
                        })();
                    })
                    .listen('MesajSilindi', (event) => {})
                    .listen('MesajGuncellendi', (event) => {})
                    .listen('MesajOkundu', (event) => {
                        Livewire.dispatch('refreshMessageCount');
                    });
            }

            @foreach ($kanallar as $kanal)
                subscribeToKanal({{ $kanal->mesaj_kanallari_id }});
            @endforeach

            let MESAJ_KANAL_KATILIMCI_SEARCH_NOT = [];
            let MESAJ_KANAL_KATILIMCI_SEARCH = document.querySelector('[name=mesaj-kanal-katilimci-search]');
            let MESAJ_KANAL_KATILIMCI_SEARCH_RESULT = document.getElementById(
                'mesaj-kanal-katilimci-search-result');
            let debounceTimeout;

            document.addEventListener('click', function(event) {
                if (event.target.closest('.searchNotSifirla')) {
                    MESAJ_KANAL_KATILIMCI_SEARCH_NOT = [];
                }

                if (event.target.closest('.aside-message-accordion-button')) {
                    const COUNT = event.target.closest('.aside-message-accordion-button').querySelector(
                        '.count');

                    if (!COUNT)
                        return;

                    (async () => {
                        const kanalId = event.target.closest('.aside-message-accordion-button')
                            .dataset.channelId;
                        const URL =
                            "{{ route('yonetim.mesaj.okundu', ['kanalId' => '___ID___']) }}"
                            .replace('___ID___', kanalId);

                        const RESPONSE = await ApiService.fetchData(URL, {}, "DELETE");

                        if (RESPONSE.status === 200) {
                            COUNT.remove();
                        } else {
                            ApiService.alert.error("Mesajlar okunurken bir hata oluştu.");
                        }
                    })();
                }

                if (event.target.closest('.mesaj-sil')) {
                    const wrapper = event.target.closest('.mesaj-wrapper');

                    if (!wrapper)
                        return;

                    (async () => {
                        const mesajId = event.target.dataset.id;
                        const URL =
                            "{{ route('yonetim.mesaj.destroy', ['mesajId' => '___ID___']) }}"
                            .replace('___ID___', mesajId);

                        const RESPONSE = await ApiService.fetchData(URL, {}, "DELETE");

                        if (RESPONSE.status === 200) {
                            wrapper.querySelector('.mesaj-body').innerHTML =
                                `<div class="text-right flex items-center justify-end gap-4"><small>Mesaj siliniyor</small><div class="dot-flashing"></div></div>`;
                        } else {
                            ApiService.alert.error("Mesaj silinirken bir hata oluştu.");
                        }
                    })();
                }

                if (event.target.closest('.mesaj-alintila')) {
                    const channel = event.target.closest('.channel');
                    const form = channel.querySelector('.mesaj-create-form');
                    const input = form.querySelector('input[alintiId]');

                    input.value = event.target.dataset.id;

                    form.querySelector('textarea').focus();

                    const alintiGosterim = form.querySelector('.alinti-gosterim');
                    const alintiGosterimMesaj = form.querySelector('.alinti-gosterim-mesaj');

                    alintiGosterim.classList.remove('hidden');

                    alintiGosterimMesaj.innerHTML = event.target.closest('.mesaj-wrapper').querySelector(
                        '.alintilanabilir').innerHTML;


                    channel.closest('section').style.maxHeight = channel.closest('section').scrollHeight +
                        'px';

                    alintiGosterimMesaj.querySelector('.mesaj-form-child')?.remove();
                }

                if (event.target.closest('.alinti-iptal')) {
                    const wrapper = event.target.closest('.alinti-gosterim');
                    wrapper.classList.add('hidden');

                    document.querySelector('input[alintiId]').value = '';
                }

                if (event.target.closest('.mesaj-alinti-kaldir')) {
                    console.log('alinti kaldır butonu tıklandı');
                    const wrapper = event.target.closest('.mesaj-wrapper');

                    if (!wrapper)
                        return;

                    const mesajId = event.target.dataset.id;
                    const URL =
                        "{{ route('yonetim.mesaj.alinti-kaldir', ['mesajId' => '___ID___']) }}"
                        .replace('___ID___', mesajId);

                    (async () => {
                        const RESPONSE = await ApiService.fetchData(URL, {}, "PATCH");

                        if (RESPONSE.status === 200) {
                            wrapper.querySelector('.mesaj-body').innerHTML =
                                `<div class="text-right flex items-center justify-end gap-4"><small>Alıntı kaldırılıyor</small><div class="dot-flashing"></div></div>`;
                        } else {
                            ApiService.alert.error("Alıntı kaldırılırken bir hata oluştu.");
                        }
                    })();
                }

                const active_form = document.querySelector('.active-form');

                if (active_form) {
                    if (event.target.closest('.mesaj-wrapper') != active_form.closest('.mesaj-wrapper')) {
                        active_form.classList.add('hidden');
                        active_form.classList.remove('active-form');
                        active_form.previousElementSibling.classList.remove('hidden');
                    }
                }

                if (event.target.closest('.mesaj-duzenle')) {
                    const form = document.getElementById(event.target.dataset.form);
                    const mesaj = form.previousElementSibling;

                    form.classList.toggle('active-form');
                    form.querySelector('div').classList.toggle('hidden');
                    mesaj.classList.toggle('hidden');
                }

                if (event.target.closest('.mesaj-duzenle-submit-button')) {
                    event.preventDefault();

                    (async () => {
                        event.target.disabled = true;

                        try {
                            const form = event.target.closest('form');

                            const formData = new FormData(form);

                            const mesaj = formData.get('mesaj');

                            if (!mesaj) {
                                ApiService.alert.error('Mesaj boş olamaz.');
                                return;
                            }

                            const URL = form.getAttribute('action');

                            const RESPONSE = await ApiService.fetchData(URL, formData, 'PATCH');

                            if (RESPONSE.status === 200) {
                                // const wrapper = container.closest('section');
                                // wrapper.style.maxHeight = wrapper.scrollHeight + 'px';

                                form.querySelector('div').classList.add('hidden');
                                form.classList.add('active-form');
                                form.previousElementSibling.classList.remove('hidden');
                                form.previousElementSibling.innerHTML =
                                    `<div class="text-right flex items-center justify-end gap-4"><small>Mesaj güncelleniyor</small><div class="dot-flashing"></div></div>`;
                            } else {
                                ApiService.alert.error('Mesaj güncellenirken bir hata oluştu.');
                            }
                        } finally {
                            event.target.disabled = false;
                        }
                    })();
                }

                if (event.target.closest('.emoji-ekle')) {
                    const element = event.target.closest('.emoji-ekle');

                    const mesajId = event.target.dataset.mesajId;
                    const emojiId = event.target.dataset.emojiId;

                    (async () => {
                        const
                            URL =
                            "{{ route('yonetim.mesaj.emoji', ['mesajId' => '___ID___', 'emojiId' => '___ID2___']) }}"
                            .replace('___ID___', mesajId)
                            .replace('___ID2___', emojiId);

                        const RESPONSE = await ApiService.fetchData(URL, {}, 'POST');

                        if (RESPONSE.status === 201) {
                            if (element.querySelector('.emoji-count'))
                                element.querySelector('.emoji-count').textContent = RESPONSE.data
                                .count;
                        } else {
                            ApiService.alert.error('Emoji eklenirken bir hata oluştu.');
                        }
                    })();
                }

                if (event.target.closest('.mesaj-submit-button')) {
                    event.preventDefault();

                    (async () => {
                        event.target.disabled = true;
                        event.target.classList.add('ozelanimasyon')

                        try {
                            const form = event.target.closest('form');
                            const formData = new FormData(form);
                            const mesaj = formData.get('mesaj');

                            if (!mesaj) {
                                ApiService.alert.error('Mesaj boş olamaz.');
                                return;
                            }

                            const RESPONSE = await ApiService.fetchData(
                                "{{ route('yonetim.mesaj.store') }}",
                                formData, 'POST');

                            if (RESPONSE.status === 201) {
                                const alintiGosterim = form.querySelector('.alinti-gosterim');
                                alintiGosterim.classList.add('hidden');

                                document.querySelector('input[alintiId]').value = '';

                                const container = document.getElementById(event.target.dataset
                                    .container);

                                container.innerHTML += RESPONSE.data.html;

                                const wrapper = container.closest('section');
                                wrapper.style.maxHeight = wrapper.scrollHeight + 'px';

                                container.scrollTo(0, container.scrollHeight);

                                form.reset();
                            } else {
                                form.reset();
                                ApiService.alert.error(RESPONSE.data.message);
                            }
                        } finally {
                            event.target.disabled = false;
                            event.target.classList.remove('ozelanimasyon')
                        }
                    })();
                }

                if (event.target.matches('.mesaj-kanal-katilimci-ekle')) {
                    const EMAIL = event.target.dataset.email;
                    const MESAJ_KANAL_KATILIMCI_CONTAINER = event.target.closest('.kanal-modal')
                        .querySelector(
                            '#mesaj-kanal-katilimcilar');
                    // document.getElementById('mesaj-kanal-katilimcilar');
                    const PARENT = event.target.parentElement;

                    (async () => {
                        const URL = "{{ route('yonetim.mesaj.kanal.katilimci.card.ekle') }}";
                        const formData = new FormData();

                        formData.append('email', EMAIL);

                        const RESPONSE = await ApiService.fetchData(URL, formData, 'POST');

                        if (RESPONSE.status === 200) {
                            PARENT.remove();

                            MESAJ_KANAL_KATILIMCI_SEARCH_NOT.push(EMAIL);
                            MESAJ_KANAL_KATILIMCI_CONTAINER.innerHTML += RESPONSE.data.html;
                        } else {
                            ApiService.alert.error('Katılımcı eklenirken bir hata oluştu.');
                        }
                    })();
                }

                if (event.target.matches('.mesaj-kanal-katilimci-iptal')) {
                    const PARENT = event.target.parentElement;
                    const EMAIL = event.target.dataset.email;

                    MESAJ_KANAL_KATILIMCI_SEARCH_NOT.splice(MESAJ_KANAL_KATILIMCI_SEARCH_NOT.indexOf(
                        EMAIL), 1);

                    PARENT.remove();
                }

                if (!event.target.closest('#mesaj-kanal-katilimci-search-result')) {
                    MESAJ_KANAL_KATILIMCI_SEARCH_RESULT.classList.add('hidden');
                    MESAJ_KANAL_KATILIMCI_SEARCH_RESULT.classList.remove('flex');
                }

                if (event.target.closest('.kanal-duzenle')) {
                    event.target.disabled = true;
                    const KANAL_ID = event.target.dataset.channelId;
                    const URL = "{{ route('yonetim.mesaj.kanal.edit', ['kanalId' => '___ID___']) }}"
                        .replace('___ID___', KANAL_ID);

                    (async () => {
                        const RESPONSE = await ApiService.fetchData(URL, {}, 'GET');

                        if (RESPONSE.status === 200) {
                            event.target.disabled = false;

                            document.body.insertAdjacentHTML('beforeend', RESPONSE.data.html);
                            document.body.classList.add('overflow-hidden');

                            const EKLENEN_ICERIK = document.body.lastElementChild;

                            const DUZENLE_MESAJ_KANAL_KATILIMCI_SEARCH = EKLENEN_ICERIK
                                .querySelector('[name=mesaj-kanal-katilimci-search]');

                            if (!DUZENLE_MESAJ_KANAL_KATILIMCI_SEARCH)
                                return;

                            // const SEARCH_NOT_LIST = RESPONSE.data.searchNot;
                            MESAJ_KANAL_KATILIMCI_SEARCH_NOT = RESPONSE.data.searchNot;

                            DUZENLE_MESAJ_KANAL_KATILIMCI_SEARCH_RESULT =
                                DUZENLE_MESAJ_KANAL_KATILIMCI_SEARCH.parentElement
                                .nextElementSibling;

                            DUZENLE_MESAJ_KANAL_KATILIMCI_SEARCH.addEventListener('input', function(
                                event) {
                                const SEARCH = event.target.value.toLowerCase();

                                if (SEARCH.length < 3) {
                                    DUZENLE_MESAJ_KANAL_KATILIMCI_SEARCH_RESULT.classList
                                        .add(
                                            'hidden');
                                    DUZENLE_MESAJ_KANAL_KATILIMCI_SEARCH_RESULT.classList
                                        .remove(
                                            'flex');
                                    return;
                                }

                                MESAJ_KANAL_KATILIMCI_SEARCH_FETCH(this,
                                    MESAJ_KANAL_KATILIMCI_SEARCH_NOT,
                                    DUZENLE_MESAJ_KANAL_KATILIMCI_SEARCH_RESULT, 0);
                            });

                            DUZENLE_MESAJ_KANAL_KATILIMCI_SEARCH.addEventListener('focus', function(
                                event) {
                                const SEARCH = event.target.value.toLowerCase();

                                if (SEARCH.length < 3) {
                                    DUZENLE_MESAJ_KANAL_KATILIMCI_SEARCH_RESULT.classList
                                        .add(
                                            'hidden');
                                    DUZENLE_MESAJ_KANAL_KATILIMCI_SEARCH_RESULT.classList
                                        .remove(
                                            'flex');
                                    return;
                                }

                                MESAJ_KANAL_KATILIMCI_SEARCH_FETCH(this,
                                    MESAJ_KANAL_KATILIMCI_SEARCH_NOT,
                                    DUZENLE_MESAJ_KANAL_KATILIMCI_SEARCH_RESULT, 0);
                            });

                            EKLENEN_ICERIK.addEventListener('click', function(e) {
                                if (!e.target.closest(
                                        '#mesaj-kanal-katilimci-search-result')) {
                                    DUZENLE_MESAJ_KANAL_KATILIMCI_SEARCH_RESULT.classList
                                        .add(
                                            'hidden');
                                    DUZENLE_MESAJ_KANAL_KATILIMCI_SEARCH_RESULT.classList
                                        .remove(
                                            'flex');
                                }
                            });

                        } else {
                            ApiService.alert.error('Kanal düzenlenirken bir hata oluştu.');
                        }
                    })();
                }

                if (event.target.closest('.kanal-duzenle-submit-button')) {
                    event.preventDefault();
                    (async () => {
                        event.target.disabled = true;

                        try {
                            const form = event.target.closest('form');
                            const formData = new FormData(form);

                            const RESPONSE = await ApiService.fetchData(form.getAttribute('action'),
                                formData, 'PATCH');

                            if (RESPONSE.status === 200) {
                                ApiService.alert.success('Kanal düzenlendi.');
                                document.getElementById(event.target.dataset.modal).remove();
                                document.body.classList.remove('overflow-hidden');
                            } else {
                                ApiService.alert.error('Kanal düzenlenirken bir hata oluştu.');
                            }
                        } finally {
                            event.target.disabled = false;
                        }
                    })();
                }

                if (event.target.closest('.mesaj-kanal-katilimci-sil')) {
                    (async () => {
                        const KANAL_ID = event.target.dataset.channelId;
                        const KATILIMCI_ID = event.target.dataset.id;

                        const URL =
                            "{{ route('yonetim.mesaj.kanal.katilimci.destroy', ['kanalId' => '___ID___', 'katilimciId' => '___ID2___']) }}"
                            .replace(
                                '___ID___', KANAL_ID).replace('___ID2___', KATILIMCI_ID);

                        const RESPONSE = await ApiService.fetchData(URL, {}, 'DELETE');

                        if (RESPONSE.status === 200) {
                            if (RESPONSE.data.self) {
                                if (!RESPONSE.data.success) {
                                    ApiService.alert.error(RESPONSE.data.message);
                                } else {
                                    ApiService.alert.success(RESPONSE.data.message);
                                    event.target.closest('.custom-modal').remove();
                                    document.body.classList.remove('overflow-hidden');
                                }
                            } else {
                                ApiService.alert.warning(RESPONSE.data.message);
                                MESAJ_KANAL_KATILIMCI_SEARCH_NOT = RESPONSE.data.searchNot;
                                event.target.closest('.mesaj-katilimci').remove();
                            }
                        } else {
                            ApiService.alert.error(RESPONSE.message);
                        }
                    })();
                }

                if (event.target.closest('.kanal-sil')) {
                    (async () => {
                        const KANAL_ID = event.target.dataset.channelId;
                        const URL =
                            "{{ route('yonetim.mesaj.kanal.destroy', ['kanalId' => '___ID___']) }}"
                            .replace('___ID___', KANAL_ID);

                        const RESPONSE = await ApiService.fetchData(URL, {}, 'DELETE');

                        if (RESPONSE.status === 200) {
                            ApiService.alert.success('Kanal silindi.');
                            event.target.closest('.custom-modal').remove();
                            document.body.classList.remove('overflow-hidden');
                            window.location.reload();
                        } else {
                            ApiService.alert.error('Katılımcı silinirken bir hata oluştu.');
                        }
                    })();
                }

                event.target.closest('.mesaj-dosya-yukleme-button') && (async () => {
                    const button = event.target.closest('.mesaj-dosya-yukleme-button');
                    const input = button.nextElementSibling;

                    input.click();
                })();
            })

            document.addEventListener('change', function(event) {
                event.target.closest('[data-mesaj-dosya-yukleme-input]') && (async () => {
                    const input = event.target;
                    const textarea = input.closest('[data-mesaj-dosya-yukleme-wrapper]')
                        .querySelector(
                            'textarea');

                    const formData = new FormData();

                    formData.append('file', input.files[0]);

                    const RESPONSE = await ApiService.fetchData(
                        "{{ route('yonetim.mesaj.dosya') }}",
                        formData, 'POST');

                    if (RESPONSE.status === 201) {
                        console.log(RESPONSE.data);
                    } else {
                        ApiService.alert.error(RESPONSE.message);
                    }
                })();

                if (event.target.closest('.yoneticilik-degistir')) {
                    (async () => {
                        const KANAL_ID = event.target.dataset.channelId;
                        const KATILIMCI_ID = event.target.dataset.id;

                        const URL =
                            "{{ route('yonetim.mesaj.kanal.katilimci.yoneticilik', ['kanalId' => '___ID___', 'katilimciId' => '___ID2___']) }}"
                            .replace(
                                '___ID___', KANAL_ID).replace('___ID2___', KATILIMCI_ID);

                        const RESPONSE = await ApiService.fetchData(URL, {}, 'PATCH');

                        if (RESPONSE.status === 200) {
                            ApiService.alert.success('Yöneticilik değiştirildi.');
                        } else {
                            ApiService.alert.error('Yöneticilik değiştirilirken bir hata oluştu.');
                        }
                    })();
                }
            });

            MESAJ_KANAL_KATILIMCI_SEARCH.addEventListener('input', function(event) {
                const SEARCH = event.target.value.toLowerCase();

                if (SEARCH.length < 3) {
                    MESAJ_KANAL_KATILIMCI_SEARCH_RESULT.classList.add('hidden');
                    MESAJ_KANAL_KATILIMCI_SEARCH_RESULT.classList.remove('flex');
                    return;
                }

                MESAJ_KANAL_KATILIMCI_SEARCH_FETCH(this, MESAJ_KANAL_KATILIMCI_SEARCH_NOT,
                    MESAJ_KANAL_KATILIMCI_SEARCH_RESULT, 0);
            });

            MESAJ_KANAL_KATILIMCI_SEARCH.addEventListener('focus', function(event) {
                const SEARCH = event.target.value.toLowerCase();

                if (SEARCH.length < 3) {
                    MESAJ_KANAL_KATILIMCI_SEARCH_RESULT.classList.add('hidden');
                    MESAJ_KANAL_KATILIMCI_SEARCH_RESULT.classList.remove('flex');
                    return;
                }

                MESAJ_KANAL_KATILIMCI_SEARCH_FETCH(this, MESAJ_KANAL_KATILIMCI_SEARCH_NOT,
                    MESAJ_KANAL_KATILIMCI_SEARCH_RESULT, 0);
            });

            function MESAJ_KANAL_KATILIMCI_SEARCH_FETCH(searchInput, searchNotList, searchResult, debounceTimeout) {
                clearTimeout(debounceTimeout);

                debounceTimeout = setTimeout(async () => {
                    const SEARCH = searchInput.value.toLowerCase();
                    const URL = "{{ route('yonetim.mesaj.kanal.katilimci.list') }}";
                    const formData = new FormData();

                    formData.append('search', SEARCH);
                    formData.append('searchNot', searchNotList);

                    const RESPONSE = await ApiService.fetchData(URL, formData, 'POST');

                    if (RESPONSE.status === 200) {
                        if (!searchResult)
                            return;

                        searchResult.classList.remove('hidden');
                        searchResult.classList.add('flex');
                        searchResult.innerHTML = RESPONSE.data.html;
                    }
                }, 300);
            }

            document.addEventListener('input', function(event) {
                if (event.target.matches('#search-channel')) {
                    const VALUE = event.target.value.toLowerCase();

                    const CHANNELS = document.querySelectorAll('[data-channel-name]');

                    CHANNELS.forEach((channel) => {
                        const CHANNEL_NAME = channel.dataset.channelName.toLowerCase();

                        if (CHANNEL_NAME.includes(VALUE)) {
                            channel.classList.remove('hidden');
                        } else {
                            channel.classList.add('hidden');
                        }
                    });
                }

                // if (!event.target.matches('textarea'))
                //     return;

                // const textarea = event.target;

                // textarea.style.height = 'auto';
                // textarea.style.height = textarea.scrollHeight + 'px';


                // textarea.closest('section').style.maxHeight = textarea.closest('section').scrollHeight +
                //     'px';
            })

            document.getElementById('kanal-olustur-submit-button').addEventListener('click', function(e) {
                e.preventDefault();

                (async () => {
                    const form = document.querySelector('#modal-yeni-kanal form');
                    const formData = new FormData(form);

                    const RESPONSE = await ApiService.fetchData(
                        "{{ route('yonetim.mesaj.kanal.store') }}",
                        formData, 'POST');

                    if (RESPONSE.status === 201) {
                        ApiService.alert.success('Kanal oluşturuldu.');

                        document.getElementById('mesaj-kanal-katilimcilar').innerHTML = '';
                        MESAJ_KANAL_KATILIMCI_SEARCH_NOT = [];
                        form.reset();

                        document.getElementById('modal-yeni-kanal').classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');

                        subscribeToKanal(RESPONSE.data.data);
                    } else {
                        ApiService.alert.error('Kanal oluşturulurken bir hata oluştu.');
                    }
                })();
            })

        });
    </script>
    @yield('scripts')
</body>

</html>
