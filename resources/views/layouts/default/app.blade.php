<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kullanici Paneli')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header>
        {{-- Header ve Nav içeriği buraya --}}
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        {{-- Footer içeriği buraya --}}
    </footer>

    {{-- JS ve diğer betikler buraya --}}
</body>

</html>
