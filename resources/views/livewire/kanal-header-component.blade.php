<div class="flex gap-4 px-4 py-1.5">
    <img src="{{ asset($kanal->resim) }}" class="rounded-full w-10 h-10" alt="">

    <div class="flex items-center justify-between w-full">
        <div class="flex flex-col">
            <span class="flex items-center gap-1 text-sm">
                {{ $kanal->baslik }}
                @if ($count > 0)
                    <span
                        class="flex items-center justify-center bg-rose-500 text-white rounded-full px-1.5 py-1 text-xs count">{{ $count }}</span>
                @endif
            </span>
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
        <a href="javascript:void(0)" class="text-gray-100 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-gear-fill size-5" viewBox="0 0 16 16">
                <path
                    d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
            </svg>
        </a>
    </div>
</div>
