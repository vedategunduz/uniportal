<header class="flex items-center justify-between bg-blue-700 text-white px-6 py-3 rounded-t">
    <div>
        <h2 class="font-medium text-lg text-white"> Davet gönder </h2>
    </div>
    <button class="close-modal" data-modal="modal">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-5 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
</header>

<div class="ozelBoyut"></div>

<section class="p-6">
    <div class="mb-2">
        <textarea id="mailler" name="mailler" rows="4"
            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
            placeholder="Kurum mail'i giriniz..."></textarea>
    </div>

    <p class="text-xs"><strong>*</strong> Davet edilmesini istediğiniz kullanıcıların mail adreslerini giriniz. Örn:
        (ornekmail@xxx.edu.tr, ornekmail2@xxx.edu.tr)</p>

    {{-- MODAL Standart butonlar --}}
    <footer class="grid grid-cols-2 gap-2 mt-4">
        <button data-modal="modal" type="button"
            class="close-modal bg-gray-50 text-gray-900 px-3 py-2 rounded hover:bg-gray-100 transition">Vazgeç</button>

        <button type="button" data-modal="alert-modal" @class([
            'davetButton open-modal text-white px-3 py-2 rounded transition focus:ring-4 bg-blue-700 hover:bg-blue-800 ring-blue-300',
        ])>Gönder</button>
    </footer>
</section>
