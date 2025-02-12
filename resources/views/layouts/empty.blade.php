<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('css/glocal.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-gray-900 antialiased">

    <main class="">
        {{ $slot }}
    </main>

    <div id="alerts" class="fixed right-4 bottom-4 z-30 space-y-2"></div>

    {{-- JS ve diğer betikler buraya --}}
    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>
