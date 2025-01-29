<div class="flex flex-col gap-2">
    @foreach ($birimBilgileri as $rowBirimBilgileri)
        <div class="flex items-stretch text-sm">
            <span class="bg-emerald-500 text-white flex items-center px-4 text-wrap w-72">{{ $rowBirimBilgileri->birim->baslik }}</span>
            <span
                class="flex items-center p-1 px-2 capitalize bg-blue-900 text-white text-wrap w-48">{{ $rowBirimBilgileri->unvan->baslik }}</span>

            <button type="button" data-modal="modal" data-id="{{ encrypt($kullanicilar_id) }}" data-birim-id="{{ encrypt($rowBirimBilgileri->isletme_birimleri_id) }}"
                data-event-type="deleteModalForBirimdenCikart" class="open-modal bg-rose-500 text-white p-1.5"
                title="birimden silme onay kutusunu aç">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endforeach
</div>
