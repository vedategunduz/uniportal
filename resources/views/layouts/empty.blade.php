<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kullanici Paneli')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/glocal.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('links')
</head>

<body>

    <main class="">
        @yield('content')
    </main>
    <div id="alerts" class="fixed right-4 bottom-4 z-30 space-y-2"></div>

    {{-- JS ve diğer betikler buraya --}}
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')

</body>

</html>
