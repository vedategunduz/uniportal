<section>
    <p class="text-xl font-medium text-gray-900 mb-2">
        {{ $gidenler ? 'Gidenler' : 'Gidilenler' }}
        Katılımcı Listesi
    </p>
    <p class="border-b"></p>
    <div class="space-y-2 max-h-96 overflow-y-auto">
        @if ($gidenler)
            @foreach ($gidenler as $giden)
                <x-yonetim.toplanti.kullanici :kullanici="$giden->kullanici" :durum="$giden->durum" type="giden"/>
            @endforeach
        @else
            @foreach ($gidilenler as $giden)
                <x-yonetim.toplanti.kullanici :kullanici="$giden->kullanici" :durum="$giden->durum" type="gidilen"/>
            @endforeach
        @endif
    </div>
</section>
