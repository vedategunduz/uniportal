<header class="flex items-center justify-between bg-red-500 text-white px-6 py-3 rounded-t">
    <div>
        <h2 class="font-medium text-lg text-white">Birimi kaldır</h2>
    </div>
    <button class="close-modal" data-modal="modal">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="size-5 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
</header>

<form action="" method="POST" class="p-6 w-96">
    <input type="hidden" name="isletme_birimleri_id" value="{{ encrypt($birim->isletme_birimleri_id) }}">

    <div class="text-center mb-4 space-y-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="size-16 mx-auto">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
        </svg>
        <h4>Emin misiniz?</h4>
        <p class="mb-0 text-sm"><span class="font-bold">{{ $birim->baslik }}</span> birimi ve birime bağlı personellerin ilgili birime yerleştirmeleri kaldırılacak.</p>
    </div>

    <footer class="grid grid-cols-2 gap-2">
        <button data-modal="modal" type="button"
            class="close-modal bg-gray-50 text-gray-900 px-3 py-2 rounded hover:bg-gray-100 transition">Hayır</button>

        <button type="submit"
            class="bg-red-500 birimSilmeFormSubmit text-white px-3 py-2 rounded hover:bg-red-700 transition">Evet</button>
    </footer>
</form>
