<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kullanici Paneli')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <link rel="stylesheet" href="{{ asset('css/glocal.css') }}"> --}}
    @yield('links')
</head>

<body>

    <main class="">
        @yield('content')
    </main>

    {{-- JS ve diğer betikler buraya --}}
    @yield('scripts')
</body>

</html>
