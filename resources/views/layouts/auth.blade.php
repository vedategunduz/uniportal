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
        <div class="aside-modal-content overflow-auto hidden-scroll">
            <header class="flex items-center justify-between bg-blue-400 text-white px-6 py-2">
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
                            class="bg-gray-50 indent-7 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Mesajlarda ara" />
                    </div>
                </header>

                <div class="flex flex-col">
                    @for ($i = 0; $i < 3; $i++)
                        <div
                            class="flex gap-4 px-4 py-3 border-b first:border-t border-l-4 border-l-transparent hover:border-l-blue-400 cursor-pointer aside-message-accordion-button">
                            <div class="pointer-events-none">
                                <img src="https://prium.github.io/phoenix/v1.20.1/assets/img/team/40x40/57.webp"
                                    class="rounded-full w-10 h-10" alt="">
                            </div>

                            <div class="flex flex-col pointer-events-none">
                                <span>Jhon Doe</span>
                                <span class="text-xs">En son mesajın 20 karakte...</span>
                            </div>
                        </div>
                        <section class="max-h-0 transition-all overflow-hidden">

                        </section>
                    @endfor
                </div>
            </section>
        </div>
    </div>

    <script src="{{ asset('js/data-table.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>

</html>
