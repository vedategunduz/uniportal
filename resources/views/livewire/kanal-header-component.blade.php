<div class="flex gap-4 px-4 py-1.5">
    <div class="relative">
        <img src="{{ asset($kanal->resim) }}" class="rounded-full w-10 h-10" alt="">

        @if ($count > 0)
            <div class="count absolute bottom-0 right-0">
                <span
                    class="inline-flex items-center justify-center bg-rose-700 text-white rounded-full text-xs size-4">{{ $count }}</span>
            </div>
        @endif
    </div>

    <div class="flex items-center justify-between w-full">
        <div class="flex flex-col">
            <div class="flex items-center gap-1 text-sm">
                <span class="text-nowrap overflow-hidden whitespace-nowrap overflow-ellipsis w-60"
                    title="{{ $kanal->baslik }}">{{ $kanal->baslik }}
                </span>
            </div>
            <span class="text-xs text-nowrap overflow-hidden whitespace-nowrap overflow-ellipsis w-48">
                @if (!empty($sonMesaj))
                    @if ($sonMesaj['durum'] != 'silindi')
                        {!! $sonMesaj['mesaj'] !!}
                    @else
                        <span class="text-gray-500">Mesaj silindi</span>
                    @endif
                @endif
            </span>
        </div>
    </div>
</div>
