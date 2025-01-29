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

    <div id="alerts" class="fixed right-4 bottom-4 z-30 space-y-2"></div>

    <script src="{{ asset('js/data-table.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>

</html>
