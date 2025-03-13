@props(['kullanici', 'durum' => null, 'type' => null, 'etkinlik' => null])

<div class="flex items-center justify-between bg-white px-2 border-gray-200" data-kullanici-wrapper>
    @if (empty($durum))
        <input type="hidden" name="{{ $type == 'giden' ? 'gidenler_id[]' : 'gidilenler_id[]' }}"
            value="{{ encrypt($kullanici->kullanici_id) }}">
    @endif

    <div class="flex items-center">
        <div class="relative"
            title="Davet {{ $durum }}">
            @if ($durum)
                <div @class([
                    'rounded-full size-4 absolute top-0 right-0 border-2 border-white',
                    'bg-green-400' => $durum == 'Onaylandı',
                    'bg-rose-500' => $durum == 'Reddedildi',
                    'bg-gray-300' => $durum == 'Beklemede',
                ])>
                </div>
            @endif

            <img class="size-12 rounded-full" src="{{ $kullanici->profilFotoUrl }}" loading="lazy"
                alt="{{ $kullanici->ad . ' ' . $kullanici->soyad }} Profil Fotoğrafı">
        </div>

        <div class="ml-4">
            <div class="text-sm font-bold text-gray-900 leading-tight tracking-wide">
                {{ $kullanici->anaUnvan->baslik }} <span class="text-xs">({{ $kullanici->anaIsletme->kisaltma }})</span>
            </div>
            <div class="text-sm font-medium text-gray-900 leading-snug">
                {{ $kullanici->ad . ' ' . $kullanici->soyad }}
            </div>
            @if (!empty($type))
                @if ($type == 'giden')
                    <div class="flex items-center flex-wrap gap-2">
                        <a href="tel:{{ $kullanici->telefon ?? ' ' }}" class="text-sm text-blue-500 leading-normal">
                            {{ $kullanici->telefon ?? ' ' }}
                        </a>
                        <div class="text-sm text-gray-500 leading-normal">
                            Dahili ({{ $kullanici->dahiliTelefon ?? '4450' }})
                        </div>
                    </div>
                @endif
            @endif
            <a href="mailto:{{ $kullanici->email }}" class="text-sm !text-blue-500 leading-normal">
                {{ $kullanici->email }}
            </a>
        </div>
    </div>


    <div class="flex items-center">
        @if (empty($durum))
            <x-button type="button"
                class=" !bg-indigo-600 hover:!bg-indigo-700 focus:ring-indigo-500 text-white rounded-full !px-2.5 !py-1.5 !text-xs">
                Ekle
            </x-button>
        @else
            <x-button type="button"
                data-id="{{ encrypt($kullanici->kullanicilar_id) }}"
                class="toplanti-kullanici-cikart !bg-rose-600 hover:!bg-rose-700 focus:ring-rose-500 text-white rounded-full !px-2.5 !py-1.5 !text-xs">
                Çıkart
            </x-button>
        @endif
    </div>
</div>
