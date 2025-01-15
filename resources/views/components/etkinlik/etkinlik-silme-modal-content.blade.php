<header class="flex items-center justify-between bg-rose-500 text-white px-6 py-3 rounded-t">
    <div>
        <h2 class="font-medium text-lg text-white"> Etkinlik Kaldır </h2>
    </div>
    <button class="close-modal" data-modal="modal">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-5 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
</header>

<form action="" class="p-6 w-96">
    <input type="hidden" name="etkinlikler_id" value="{{ encrypt($etkinlik->etkinlikler_id) }}">

    <div class="text-center mb-4 space-y-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="size-16 mx-auto">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
        </svg>
        <h4>Emin misiniz?</h4>
        <p class="mb-0 text-sm"><span class="font-medium">{{ $etkinlik->baslik }}</span> etkinliği kaldırılacak.</p>
    </div>

    {{-- MODAL Standart butonlar --}}
    <footer class="grid grid-cols-2 gap-2">
        <button data-modal="modal" type="button"
            class="close-modal bg-gray-50 text-gray-900 px-3 py-2 rounded hover:bg-gray-100 transition">Vazgeç</button>

        <button type="submit" data-event-type="delete" @class([
            'etkinlik-submit text-white px-3 py-2 rounded transition focus:ring-4 bg-rose-500 hover:bg-rose-800 ring-rose-300',
        ])>Kaldır</button>
    </footer>
</form>
