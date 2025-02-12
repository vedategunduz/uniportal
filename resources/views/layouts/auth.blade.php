<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kullanici Paneli')</title>
    @yield('links')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Summernote ve Datatable için --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <link rel="stylesheet" href="{{ asset('css/customDataTable.css') }}">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/glocal.css') }}">
</head>

<body>
    <x-menu.head />

    <div class="items-start lg:flex">
        <x-menu />

        <main class="p-4 w-full">
            @yield('content')
        </main>
    </div>

    <div id="modal" class="custom-modal hidden">
        <section class="modal-outside close-modal" data-modal="modal"></section>

        <section id="modal-content" class="modal-content max-w-screen-md rounded max-h-screen hidden-scroll">
        </section>
    </div>

    <div id="alert-modal" class="alert-custom-modal hidden">
        <section class="modal-outside close-modal" data-modal="alert-modal"></section>

        <section id="alert-modal-content" class="modal-content max-w-screen-md rounded max-h-screen hidden-scroll">
        </section>
    </div>

    <div id="alerts" class="fixed right-4 bottom-4 z-30 space-y-2"></div>

    <div class="aside-modal active" id="aside-modal">
        <div class="aside-modal-outside close-aside-modal" data-modal="aside-modal"></div>
        <div class="aside-modal-content overflow-auto hidden-scroll w-full md:w-1/2 lg:w-1/3">
            <header class="flex items-center justify-between bg-blue-700 text-white px-6 py-2">
                <div>
                    <h2 class="font-medium text-lg"> Mesajlar </h2>
                </div>
                <button class="close-aside-modal" data-modal="aside-modal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5 pointer-events-none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </header>
            <section id="aside-modal-content-body" class="flex flex-col">
                <header class="p-4">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search size-4 absolute top-1/2 -translate-y-1/2 left-3" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg>
                        <input type="text" id="first_name"
                            class="bg-gray-50 indent-7 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-2"
                            placeholder="Mesajlarda ara" />
                    </div>
                </header>

                <div class="flex flex-col">
                    @foreach ($kanallar as $kanal)
                        <header
                            class="border-b first:border-t border-l-4 border-l-transparent hover:border-l-blue-400 cursor-pointer aside-message-accordion-button"
                            data-channel-id="{{ $kanal->mesaj_kanallari_id }}">
                            <livewire:kanal-header-component kanalId="{{ $kanal->mesaj_kanallari_id }}" />
                        </header>
                        <section class="max-h-0 transition-all overflow-hidden">
                            <livewire:mesajlar-component kanalId="{{ $kanal->mesaj_kanallari_id }}" />
                        </section>
                    @endforeach
                </div>
            </section>
        </div>

    </div>

    <script src="{{ asset('js/data-table.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        function dropdownTrigger(triggerEl) {
            const targetEl = document.getElementById(triggerEl.getAttribute(
                'data-dropdown-toggle'));
            new Dropdown(targetEl, triggerEl);
        }

        document.addEventListener('DOMContentLoaded', function() {

            @foreach ($kanallar as $kanal)
                window.Echo.private(`mesaj-kanal.{{ $kanal->mesaj_kanallari_id }}`)
                    .listen('MesajOlusturuldu', (event) => {
                        const ACCORDION_HEADERS = document.querySelector(
                            '.aside-message-accordion-button.active');

                        if (!ACCORDION_HEADERS)
                            return;

                        const ACCORDION_BODY = ACCORDION_HEADERS.nextElementSibling;

                        ACCORDION_BODY.style.maxHeight = ACCORDION_BODY.scrollHeight + 'px';

                        const MESAJ_CONTAINER = ACCORDION_BODY.querySelector('.mesaj-container');

                        setTimeout(() => {
                            MESAJ_CONTAINER.scrollTo(0, MESAJ_CONTAINER.scrollHeight);
                        }, 2000);

                        (async () => {
                            const kanalId = ACCORDION_HEADERS.dataset.channelId;
                            const URL =
                                "{{ route('yonetim.mesaj.okundu', ['kanalId' => '___ID___']) }}"
                                .replace('___ID___', kanalId);

                            const RESPONSE = await ApiService.fetchData(URL, {}, "DELETE");

                            if (RESPONSE.status === 200) {
                                // COUNT.remove();
                            } else {
                                ApiService.alert.error("Bir hata oluştu");
                            }
                        })();
                    })
                    .listen('MesajSilindi', (event) => {

                    })
                    .listen('MesajGuncellendi', (event) => {

                    });
            @endforeach

            document.addEventListener('click', function(event) {
                if (event.target.matches('.aside-message-accordion-button')) {
                    const COUNT = event.target.querySelector('.count');

                    if (!COUNT)
                        return;

                    (async () => {
                        const kanalId = event.target.dataset.channelId;
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
                            console.log(wrapper);
                            console.log(wrapper.querySelector('.mesaj-body'));
                            wrapper.querySelector('.mesaj-body').innerHTML =
                                `<div class="text-right flex items-center justify-end gap-4"><small>Mesaj siliniyor</small><div class="dot-flashing"></div></div>`;
                        } else {
                            ApiService.alert.error("Mesajlar okunurken bir hata oluştu.");
                        }
                    })();
                }

                if (event.target.closest('.mesaj-duzenle')) {
                    const form = document.getElementById(event.target.dataset.form);
                    const mesaj = form.previousElementSibling;

                    form.classList.toggle('hidden');
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

                                form.classList.add('hidden');
                                form.nextElementSibling.classList.remove('hidden');
                                form.nextElementSibling.innerHTML = `<div class="text-right flex items-center justify-end gap-4"><small>Mesaj güncelleniyor</small><div class="dot-flashing"></div></div>`;
                            } else {
                                ApiService.alert.error('Mesaj güncellenirken bir hata oluştu.');
                            }
                        } finally {
                            event.target.disabled = false;
                        }
                    })();
                }
            })

            const submitButtons = document.querySelectorAll('.mesaj-submit-button');

            submitButtons.forEach((submitButton) => {
                submitButton.addEventListener('click', async (e) => {
                    e.preventDefault();

                    e.target.disabled = true;
                    e.target.classList.add('ozelanimasyon')

                    try {
                        const form = e.target.closest('form');
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
                            const container = document.getElementById(submitButton.dataset
                                .container);

                            container.innerHTML += RESPONSE.data.html;

                            const wrapper = container.closest('section');
                            wrapper.style.maxHeight = wrapper.scrollHeight + 'px';

                            container.scrollTo(0, container.scrollHeight);

                            form.reset();
                        } else {
                            ApiService.alert.error('Mesaj gönderilirken bir hata oluştu.');
                        }
                    } finally {
                        e.target.disabled = false;
                        e.target.classList.remove('ozelanimasyon')
                    }
                });
            });

        });
    </script>
    @yield('scripts')
</body>

</html>
