<section>
    <div class="flex items-center justify-between px-4 py-2 bg-gray-50/50 border-b">
        <p class="font-medium text-lg text-gray-900 mb-0">Yorumlar</p>
    </div>
    <div class="flex flex-col 1px-4 1py-2 gap-0">
        {{-- {{ $yorumlar }} --}}
        <x-paylasim.yorumlar-component :yorumlar="$yorumlar" />
    </div>
    @if ($yorumlar->count() < $total)
        <div class="text-center mb-2">
            <x-button class="" wire:click="loadMore">
                Daha fazla
            </x-button>
        </div>
    @endif
</section>
