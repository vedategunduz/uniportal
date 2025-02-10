<div @class([
    'flex w-10/12',
    'flex-row-reverse ml-auto' => $mesaj->kullanicilar_id === auth()->id(),
])>
    <div @class(['p-4 rounded bg-emerald-50'])>
        <p class="text-sm">{{ $mesaj->mesaj }}</p>
        <p class="text-sm">
        <div class="text-right flex items-center justify-end gap-4">
            <small>Gönderiliyor</small>
            <div class="dot-flashing"></div>
        </div>
        </p>
    </div>
</div>
