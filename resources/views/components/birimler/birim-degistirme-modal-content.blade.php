<header class="flex items-center justify-between bg-yellow-400 text-white px-6 py-3 rounded-t">
    <div>
        <h2 class="font-medium text-lg text-white">Birimi Değiştir</h2>
    </div>
    <button class="close-modal" data-modal="modal">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="size-5 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
</header>

<div class="ozelBoyut"></div>

<form action="" method="POST" class="p-6">
    <section>
        <input type="hidden" name="kullanici_birim_unvan_iliskileri_id" value="  {{ $kullanici_birim_unvan_iliskileri_id }}">

        <p class="mb-4">
            <span class="font-bold">{{ $kullaniciBilgileri->ad }} {{ $kullaniciBilgileri->soyad }}</span>
            adlı kullanıcının birimini değiştirmek üzeresiniz.
        </p>

        <select name="isletme_birimleri_id" id="isletme_birimleri_id"
            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block p-2.5">
            <option value="">Birim seçiniz</option>
            @foreach ($isletmeBirimleri as $rowBirim)
                <option value="{{ encrypt($rowBirim->isletme_birimleri_id) }}">{{ $rowBirim->baslik }}
                </option>
            @endforeach
        </select>
    </section>

    <footer class="mt-6 text-right">
        <button type="submit"
            class="birimDegistirFormSubmit bg-amber-500 text-white px-3 py-2 rounded hover:bg-amber-700 transition">Birimi
            değiştir</button>
    </footer>
</form>
