<div class="flex flex-row -space-x-2">
    @foreach ($kullanicilar as $kullanici)
        <img src="{{ $kullanici->bilgi->profilFotoUrl }}" @class([
            'size-10 rounded-full !border-2',
            '!border-emerald-500' => $kullanici->durum == "onaylandi",
            '!border-rose-500' => $kullanici->durum == "reddedildi",
        ])  alt="{{ $kullanici->bilgi->ad . ' ' . $kullanici->bilgi->soyad }} fotoğrafı" title="{{ $kullanici->bilgi->ad . ' ' . $kullanici->bilgi->soyad }}">
    @endforeach
</div>
