<div class="flex flex-col gap-2">
    @foreach ($birimBilgileri as $rowBirimBilgileri)
        <div class="flex items-center text-xs gap-2">
            <span>{{ $rowBirimBilgileri->birim->baslik }}</span>
            <span
                class="block rounded p-1 px-2 capitalize bg-blue-900 text-white">{{ $rowBirimBilgileri->unvan->baslik }}</span>

            <button type="button" data-modal="modal" data-id=""
                data-event-type="" class="open-modal bg-rose-500 text-white p-1.5 rounded"
                title="birimden silme onay kutusunu aç">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-3 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endforeach
</div>
