@props(['kullanicilar'])

@foreach ($kullanicilar as $kullanici)
    <div class="flex items-center justify-between bg-white px-2 border-gray-200">
        <div class="flex items-center">
            <div class="flex-shrink-0 size-12">
                <img class="size-12 rounded-full" src="{{ $kullanici->profilFotoUrl }}" alt="">
            </div>
            <div class="ml-4">
                <div class="text-sm font-bold text-gray-900">{{ $kullanici->anaUnvan->baslik }}</div>
                <div class="text-sm font-medium text-gray-900">{{ $kullanici->ad . ' ' . $kullanici->soyad }}</div>
                <div class="text-sm text-gray-500">{{ $kullanici->email }}</div>
            </div>
        </div>

        <div class="flex items-center">
            <x-button type="button"
                class=" !bg-indigo-600 hover:!bg-indigo-700 focus:ring-indigo-500 text-white rounded-full !px-2.5 !py-1.5 !text-xs">
                Ekle
            </x-button>
        </div>
    </div>
@endforeach
