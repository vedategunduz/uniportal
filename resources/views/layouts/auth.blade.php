<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kullanici Paneli')</title>
    @yield('links')
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/main.js'])
    <link rel="stylesheet" href="{{ asset('css/glocal.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="flex">
        <aside class="w-72 h-screen shadow bg-white text-gray-900">
            <nav class="flex flex-col h-full p-4">

                <a href="{{ route('kullanici.index') }}" class="flex items-center mb-8">
                    <img src="https://flowbite.com/docs/images/logo.svg" class="size-8 me-3" alt="Flowbite Logo" />
                    <span class="text-2xl font-semibold whitespace-nowrap">uniportal</span>
                </a>

                <ul class="space-y-2">
                    @foreach ($menuler as $menu)
                        @if ($menu->bagli_menuler_id == null)
                            <li>
                                @if ($menu->altMenuler->count() > 0)
                                    <button type="button" @class([
                                        'flex items-center w-full py-1 px-3 rounded-lg transition hover:bg-gray-100 accordion-button',
                                    ])>
                                        <span class="p-1 rounded-lg me-2">
                                            {!! $menu->menuIcon !!}
                                        </span>
                                        <span>{{ $menu->menuAd }}</span>

                                        <svg class="size-2.5 ms-2.5 ml-auto" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 4 4 4-4" />
                                        </svg>
                                    </button>
                                    <ul class="hidden">
                                        @foreach ($menu->altMenuler as $altMenu)
                                            <li>
                                                <a href="{{ $altMenu->menuLink }}"
                                                    class="block indent-10 py-1 px-3 rounded-lg transition hover:bg-gray-100">{{ $altMenu->menuAd }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <a href="{{ $menu->menuLink }}" @class([
                                        'flex items-center py-1 px-3 rounded-lg transition',
                                        'bg-blue-700 text-white hover:text-white' => Request::is(
                                            ltrim($menu->menuLink, '/')),
                                        'hover:bg-gray-100' => !Request::is(ltrim($menu->menuLink, '/')),
                                    ])>
                                        <span class="p-1 rounded-lg me-2">
                                            {!! $menu->menuIcon !!}
                                        </span>
                                        <span>{{ $menu->menuAd }}</span>
                                    </a>
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ul>

                <div class="mt-auto">
                    <a href="{{ route('kullanici.cikis') }}"
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

    @yield('scripts')
    <script>
        window.App = {
            baseUrl: "{{ url('/') }}"
        };
    </script>
</body>

</html>
