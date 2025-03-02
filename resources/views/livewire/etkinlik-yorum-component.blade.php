<section>
    <h4 class="font-medium text-lg px-4 py-2 bg-gray-50 border-b text-gray-900">Yorumlar</h4>
    <div class="flex flex-col 1px-4 1py-2 gap-0">
        <x-etkinlik.yorumlar-component :yorumlar="$yorumlar->whereNull('yanitlanan_etkinlik_yorumlari_id')" />
    </div>
    @if ($yorumlar->count() < $totalYorum)
        <div class="text-center mb-2">
            <x-button class="" wire:click="loadMore">
                Daha fazla
            </x-button>
        </div>
    @endif
</section>
