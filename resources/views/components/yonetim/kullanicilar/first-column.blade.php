<div class="flex">
    <img src="{{ $personel->profilFotoUrl }}" class="size-16 rounded" alt="">

    <div class="flex flex-col ms-2">
        <a href="personel-detay/{{ encrypt($personel->kullanicilar_id) }}" class="font-medium text-lg hover:text-blue-700">{{ $personel->ad }}
            {{ $personel->soyad }}</a>
        <a href="mailto:{{ $personel->email }}" class="text-sm text-gray-700 hover:text-blue-700">{{ $personel->email }}</a>
        <a href="tel:{{ $personel->telefon }}" class="text-sm text-gray-500 hover:text-emerald-500">{{ $personel->telefon }}</a>
    </div>
</div>
