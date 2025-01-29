<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kullanici Paneli')</title>
    <link rel="stylesheet" href="{{ asset('css/glocal.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('links')
</head>

<body>

    <main class="">
        @yield('content')
    </main>

    {{-- JS ve diğer betikler buraya --}}
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')

</body>

</html>
