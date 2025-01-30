<header class="flex items-center justify-between bg-blue-700 text-white px-6 py-3 rounded-t">
    <div>
        <h2 class="font-medium text-lg text-white">Personeller</h2>
    </div>
    <button class="close-modal" data-modal="modal">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-5 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
</header>

<div class="ozelBoyut"></div>

<form action="" method="POST" class="p-6">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <select name="isletme_birimleri_id" id=""
            class="bg-gray-50 border sm:col-span-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
            <option value="">Birim Seçin</option>
            @foreach ($isletmeBirimleri as $rowIsletmeBirim)
                <option value="{{ encrypt($rowIsletmeBirim->isletme_birimleri_id) }}">
                    {{ $rowIsletmeBirim->baslik }}</option>
            @endforeach
        </select>
        <button type="submit"
            class="birimePersonelAtaSubmit bg-emerald-500 text-white rounded-lg px-4 py-2.5 hover:bg-emerald-600 transition duration">Birime
            ata</button>
    </div>

    <div id="birimeYerlesmemisPersonelContainer"></div>
</form>
