<div
    class="flex gap-4 px-4 py-3 border-b first:border-t border-l-4 border-l-transparent hover:border-l-blue-400 cursor-pointer aside-message-accordion-button">
    <img src="{{ $kanal->resim }}" class="rounded-full w-10 h-10 pointer-events-none" alt="">

    <div class="flex flex-col pointer-events-none">
        <span>{{ $kanal->baslik }}</span>
        <span class="text-xs">
            Son Mesaj
        </span>
    </div>
</div>
