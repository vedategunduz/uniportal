<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kullanici Paneli')</title>
    @yield('links')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/glocal.css') }}">
</head>

<body class="text-gray-900 bg-gray-50">

    <nav class="max-w-screen-xl mx-auto flex justify-between items-center p-4">
        <a href="{{ route('main.index') }}" class="text-3xl font-bold text-blue-700">uniportal</a>

        <ul class="flex space-x-4">
            <li><a href="#">İşletmeler</a></li>
        </ul>

        @if (auth()->check())
            <a href="{{ route('kullanici.cikis') }}"
                class="bg-gray-900 text-gray-50 p-2 px-3 rounded font-medium">Çıkış</a>
        @else
            <a href="{{ route('kullanici.giris.form') }}"
                class="bg-gray-900 text-gray-50 p-2 px-3 rounded font-medium">Oturum aç</a>
        @endif
    </nav>

    <main class="max-w-screen-xl mx-auto p-4">
        @yield('content')
    </main>

    <footer>
        {{-- Footer içeriği buraya --}}
    </footer>

    {{-- JS ve diğer betikler buraya --}}
    @yield('scripts')
</body>

</html>
