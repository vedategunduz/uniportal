@props(['kullanicilar'])

@foreach ($kullanicilar as $kullanici)
    <x-yonetim.toplanti.kullanici :kullanici="$kullanici" />
@endforeach
