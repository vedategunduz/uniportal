<section>
    <div class="flex items-center justify-between px-4 py-2 bg-gray-50/50 border-b">
        <h4 class="font-medium text-lg text-gray-900">
            @if ($kamuYorumu)
                Kamu Yorumları
            @else
                Yorumlar
            @endif
        </h4>

        <x-button class="!shadow-none !border-0 !p-2 hover:!bg-inherit" :disabled="true">
            <div class="flex items-center gap-2">
                <i class="bi bi-chat-left-text !text-blue-500 text-base"></i>
                <span>{{ $yorumSayisi }}</span>
            </div>
        </x-button>
    </div>
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
