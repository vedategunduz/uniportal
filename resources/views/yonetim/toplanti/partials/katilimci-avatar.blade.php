@php
    $count = 0;
    $limit = 4;
@endphp
<section class="flex justify-center -space-x-4 cursor-pointer katilimci-listesi open-modal"
    data-id="{{ encrypt($etkinlik_id) }}" data-modal="katilimci-listesi-modal" data-type="{{ $type }}">
    @foreach ($kullanicilar->take($limit) as $kullanici)
        @php $count++; @endphp
        <div @class([
            'rounded-full border-2 border-gray-50 pointer-events-none',
            'border-green-400' => $kullanici->durum == 'Onaylandı',
            'border-rose-500' => $kullanici->durum == 'Reddedildi',
            'border-gray-300' => $kullanici->durum == 'Beklemede',
        ])>
            <img src="{{ $kullanici->kullanici->profilFotoUrl }}" class="size-8 rounded-full" alt="">
        </div>
    @endforeach
    @if ($kullanicilar->count() > $limit)
        <button type="button"
            class="pointer-events-none size-9 rounded-full flex items-center justify-center bg-blue-950 text-xs text-white border-2">
            <i class="bi bi-plus"></i>
            {{ $kullanicilar->count() - $count }}
        </button>
    @endif
</section>
