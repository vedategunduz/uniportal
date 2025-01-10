@foreach ($birimPersonelleri as $rowPersonel)
@foreach ($birimPersonelleri as $rowPersonel)
@foreach ($birimPersonelleri as $rowPersonel)
    @php
        $sifreli_kullanici_birim_unvan_iliskileri_id = encrypt($rowPersonel->kullanici_birim_unvan_iliskileri_id);
    @endphp
    <img data-person-id="{{ $sifreli_kullanici_birim_unvan_iliskileri_id }}"
        src="{{ $rowPersonel->kullanici->profilFotoUrl }}" class="rounded-full size-12 shadow" alt=""
        data-popover-target="popover-default_{{ $sifreli_kullanici_birim_unvan_iliskileri_id }}">

    <div data-popover id="popover-default_{{ $sifreli_kullanici_birim_unvan_iliskileri_id }}" role="tooltip"
        class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
        <div class="p-3">
            {{-- <div class="text-sm font-semibold leading-none text-gray-900 dark:text-white mb-3"></div> --}}
            <div class="flex items-center justify-between mb-2">
                <a href="#">
                    <img class="size-14 rounded-full" src="{{ $rowPersonel->kullanici->profilFotoUrl }}"
                        alt="Jese Leos">
                </a>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" value="" class="sr-only peer">
                    <div
                        class="relative w-7 h-4 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-blue-600">
                    </div>
                    <span class="ms-3 text-sm font-medium text-gray-900 select-none">Yetkili</span>
                </label>
            </div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">
                <a href="#">{{ $rowPersonel->kullanici->ad }} {{ $rowPersonel->kullanici->soyad }}</a>
            </p>
            <p class="mb-3 text-sm font-normal">
                <a href="#" class="hover:underline">{{ $rowPersonel->kullanici->email }}</a>
            </p>
            <p class="text-sm text-blue-600">
                {{ $rowPersonel->unvan->baslik }}
            </p>
            <div class="border-t my-2"></div>
            <div>
                <button type="button"
                    onclick="birimdenCikart('{{ encrypt($rowPersonel->kullanici_birim_unvan_iliskileri_id) }}', '{{ encrypt($rowPersonel->isletme_birimleri_id) }}')"
                    data-id="{{ encrypt($rowPersonel->kullanici_birim_unvan_iliskileri_id) }}"
                    data-birimid="{{ encrypt($rowPersonel->isletme_birimleri_id) }}"
                    class="text-white birimdenCikart bg-rose-700 hover:bg-rose-800 focus:ring-2 focus:ring-rose-300 font-medium rounded-lg text-xs px-2 py-1">Birimden
                    çıkart</button>
                <button type="button" data-modal="birimDegistir"
                    data-id="{{ encrypt($rowPersonel->kullanici_birim_unvan_iliskileri_id) }}"
                    data-birimid="{{ encrypt($rowPersonel->isletme_birimleri_id) }}"
                    class="birimDegistir open-modal text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-2 focus:ring-yellow-400 font-medium rounded-lg text-xs px-2 py-1">Birim
                    değiştir</button>
            </div>
        </div>
        <div data-popper-arrow></div>
    </div>
@endforeach
@endforeach
@endforeach
