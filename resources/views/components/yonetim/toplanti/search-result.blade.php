<section class="space-y-2 py-2 max-h-60 overflow-y-auto">
    @foreach ($kullanicilar as $kullanici)
        <x-yonetim.toplanti.kullanici :kullanici="$kullanici" />
    @endforeach

    @if ($kullanicilar->isEmpty())
        <div class="text-center text-gray-500">Kullanıcı bulunamadı.</div>
    @endif
</section>
