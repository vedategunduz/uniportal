<div class="flex gap-4 px-4 py-3 pointer-events-none">
    <img src="{{ $kanal->resim }}" class="rounded-full w-10 h-10" alt="">

    <div class="flex flex-col">
        <span class="flex items-center gap-1">
            {{ $kanal->baslik }}
            @if ($count > 0)
                <span class="flex items-center justify-center bg-rose-500 text-white rounded-full px-1.5 py-1 text-xs count">{{ $count }}</span>
            @endif
        </span>
        <span class="text-xs text-nowrap overflow-hidden whitespace-nowrap overflow-ellipsis w-48">
            @if (!empty($sonMesaj))
                {!! $sonMesaj['mesaj'] !!}
            @endif
        </span>
    </div>
</div>
