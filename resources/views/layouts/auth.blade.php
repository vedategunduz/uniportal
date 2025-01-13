<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kullanici Paneli')</title>
    @yield('links')
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/main.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.0/css/dataTables.dataTables.min.css">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/glocal.css') }}">

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
</head>

<body>
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
                    <a href="{{ route('yonetim.cikis') }}"
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

        <main class="p-4 w-full" style="min-height: 300vh">
            @yield('content')
        </main>

        <div id="alerts" class="absolute right-4 bottom-4 z-30 space-y-2"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    <script src="{{ asset('js/data-table.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
    <script>
        window.App = {
            baseUrl: "{{ url('/') }}"
        };
    </script>
</body>

</html>
