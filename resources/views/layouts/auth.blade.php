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

    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.0/css/dataTables.dataTables.min.css">


    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/glocal.css') }}">
</head>

<body>
    <div class="flex items-start">
        <nav class="flex flex-col w-full p-4 text-sm" id="aside-nav">
            <div class="gradient-aside rounded p-2">
                <a href="" class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-pie-chart-fill size-4"
                        viewBox="0 0 16 16">
                        <path
                            d="M15.985 8.5H8.207l-5.5 5.5a8 8 0 0 0 13.277-5.5zM2 13.292A8 8 0 0 1 7.5.015v7.778zM8.5.015V7.5h7.485A8 8 0 0 0 8.5.015" />
                    </svg>
                    <span class="ml-4 text-nowrap menu-text">Dashboard</span>
                </a>
                <button type="button"
                    class="aside-accordion flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        class="bi bi-calendar2-event-fill size-4 pointer-events-none" viewBox="0 0 16 16">
                        <path
                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5m9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5M11.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z" />
                    </svg>
                    <span class="ml-4 text-nowrap">Kurum işlemleri</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-4 ml-auto arrow duration-300 pointer-events-none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <ul class="pl-11 max-h-0 overflow-hidden duration-300 accordion-content">
                    <li>
                        <a href=""
                            class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                            <span class="text-nowrap pointer-events-none">Etkinlikler</span>
                        </a>
                    </li>
                    <li>
                        <a href=""
                            class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                            <span class="text-nowrap pointer-events-none">Ortak alım talepleri</span>
                        </a>
                    </li>
                    <li>
                        <a href=""
                            class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                            <span class="text-nowrap pointer-events-none">Sarf istek fazla</span>
                        </a>
                    </li>
                    <li>
                        <a href=""
                            class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                            <span class="text-nowrap pointer-events-none">Sponsor talepleri</span>
                        </a>
                    </li>
                    <li>
                        <button type="button"
                            class="aside-accordion flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                            <span class="text-nowrap">Kurum işlemleri</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="size-4 ml-auto arrow duration-300 pointer-events-none">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <ul class="pl-3 max-h-0 overflow-hidden duration-300 accordion-content">
                            <li>
                                <a href=""
                                    class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                                    <span class="text-nowrap pointer-events-none">Etkinlikler</span>
                                </a>
                            </li>
                            <li>
                                <a href=""
                                    class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                                    <span class="text-nowrap pointer-events-none">Ortak alım talepleri</span>
                                </a>
                            </li>
                            <li>
                                <a href=""
                                    class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                                    <span class="text-nowrap pointer-events-none">Sarf istek fazla</span>
                                </a>
                            </li>
                            <li>
                                <a href=""
                                    class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                                    <span class="text-nowrap pointer-events-none">Sponsor talepleri</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <button type="button"
                    class="aside-accordion flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        class="bi bi-calendar2-event-fill size-4 pointer-events-none" viewBox="0 0 16 16">
                        <path
                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5m9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5M11.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z" />
                    </svg>
                    <span class="ml-4 text-nowrap">Kurum işlemleri</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-4 ml-auto arrow duration-300 pointer-events-none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <ul class="pl-11 max-h-0 overflow-hidden duration-300 accordion-content">
                    <li>
                        <a href=""
                            class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                            <span class="text-nowrap pointer-events-none">Etkinlikler</span>
                        </a>
                    </li>
                    <li>
                        <a href=""
                            class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                            <span class="text-nowrap pointer-events-none">Ortak alım talepleri</span>
                        </a>
                    </li>
                    <li>
                        <a href=""
                            class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                            <span class="text-nowrap pointer-events-none">Sarf istek fazla</span>
                        </a>
                    </li>
                    <li>
                        <a href=""
                            class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                            <span class="text-nowrap pointer-events-none">Sarf istek fazla</span>
                        </a>
                    </li>
                    <li>
                        <a href=""
                            class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                            <span class="text-nowrap pointer-events-none">Sponsor talepleri</span>
                        </a>
                    </li>
                    <li>
                        <button type="button"
                            class="aside-accordion flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                            <span class="text-nowrap">Kurum işlemleri</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="size-4 ml-auto arrow duration-300 pointer-events-none">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <ul class="pl-3 max-h-0 overflow-hidden duration-300 accordion-content">
                            <li>
                                <a href=""
                                    class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                                    <span class="text-nowrap pointer-events-none">Etkinlikler</span>
                                </a>
                            </li>
                            <li>
                                <a href=""
                                    class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                                    <span class="text-nowrap pointer-events-none">Etkinlikler</span>
                                </a>
                            </li>
                            <li>
                                <a href=""
                                    class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                                    <span class="text-nowrap pointer-events-none">Ortak alım talepleri</span>
                                </a>
                            </li>
                            <li>
                                <a href=""
                                    class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                                    <span class="text-nowrap pointer-events-none">Sarf istek fazla</span>
                                </a>
                            </li>
                            <li>

                                <button type="button"
                                    class="aside-accordion flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                                    <span class="text-nowrap">Kurum işlemleri</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="size-4 ml-auto arrow duration-300 pointer-events-none">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                                <ul class="pl-3 max-h-0 overflow-hidden duration-300 accordion-content">
                                    <li>
                                        <a href=""
                                            class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                                            <span class="text-nowrap pointer-events-none">Etkinlikler</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href=""
                                            class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                                            <span class="text-nowrap pointer-events-none">Ortak alım talepleri</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href=""
                                            class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                                            <span class="text-nowrap pointer-events-none">Sarf istek fazla</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href=""
                                            class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                                            <span class="text-nowrap pointer-events-none">Sarf istek fazla</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href=""
                                            class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                                            <span class="text-nowrap pointer-events-none">Sarf istek fazla</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href=""
                                            class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                                            <span class="text-nowrap pointer-events-none">Sarf istek fazla</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href=""
                                            class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                                            <span class="text-nowrap pointer-events-none">Sponsor talepleri</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="flex">
        <aside class="w-72 h-screen shadow bg-white text-gray-900">
            <nav class="flex flex-col h-full p-4">
                <a href="{{ route('yonetim.index') }}" class="flex items-center mb-8">
                    <img src="https://flowbite.com/docs/images/logo.svg" class="size-8 me-3" alt="Flowbite Logo" />
                    <span class="text-2xl font-semibold whitespace-nowrap">uniportal</span>
                </a>

                <ul class="text-nowrap">
                    @foreach ($menuler as $menu)
                        @if (is_null($menu->bagli_menuler_id))
                            @include('components.menu-item', ['menu' => $menu])
                        @endif
                    @endforeach
                </ul>

                <div class="mt-auto">
                    <a href="{{ route('cikis') }}"
                        class="flex items-center py-2 px-3 rounded-lg hover:bg-gray-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-6 me-2">
                            <path fill-rule="evenodd"
                                d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm10.72 4.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1 0 1.06l-3 3a.75.75 0 1 1-1.06-1.06l1.72-1.72H9a.75.75 0 0 1 0-1.5h10.94l-1.72-1.72a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Çıkış Yap</span>
                    </a>
                </div>
            </nav>
        </aside>

        <main class="p-4 w-full">
            @yield('content')
        </main>
    </div>


    <div id="alerts" class="fixed right-4 bottom-4 z-30 space-y-2"></div>

    <script src="{{ asset('js/data-table.js') }}"></script>
    {{-- <script src="https://cdn.datatables.net/2.2.1/js/dataTables.tailwindcss.js"></script> --}}
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>

</html>
