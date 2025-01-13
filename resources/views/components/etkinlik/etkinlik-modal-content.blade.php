<header class="flex items-center justify-between bg-blue-700 text-white px-6 py-3 rounded-t-lg">
    <div>
        <h2 class="font-medium text-lg text-white">Yeni Etkinlik Oluştur</h2>
    </div>
    <button class="close-modal" data-modal="modal">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-5 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
</header>

<form action="">
    <div id="content" class="p-6"></div>

    <footer class="grid grid-cols-2 gap-2 p-6">
        <button data-modal="modal" type="button"
            class="close-modal bg-gray-50 text-gray-900 px-3 py-2 rounded hover:bg-gray-100 transition">Vazgeç</button>

        <button type="submit" class="bg-blue-700 text-white px-3 py-2 rounded transition">Oluştur</button>
    </footer>
</form>
