<section>
    <x-modal id="imageCropModal" class="sm:w-2/4" title="Kırp">
        <div class="relative h-96">
            <img id="image" class="max-w-full" alt="Yüklenecek görüntü">
        </div>
        <x-button id="cropButton" class="mt-4">
            Kırp
        </x-button>
    </x-modal>

    <form
        action="{{ $etkinlik ? route('yonetim.kampanyalar.update', ['etkinlik_id' => encrypt($etkinlik->etkinlikler_id)]) : route('yonetim.kampanyalar.store') }}"
        method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @csrf

        @if ($etkinlik)
            @method('PATCH')
        @endif

        @csrf
        <div class="flex flex-col gap-4 shadow p-4 rounded">
            <div class="mb-4 relative group">
                <img id="banner-image" src="{{ optional($etkinlik)->kapakResmiYolu ?? asset('image/resim-yok.png') }}"
                    class="max-h-96 w-full object-contain rounded" loading="lazy" alt="">

                <div class="absolute top-4 left-4 hidden group-hover:!block">
                    <label for="inputImage"
                        class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-gray-50 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:text-gray-500 disabled:hover:!bg-inherit transition ease-in-out duration-150 cursor-pointer">
                        Kapak resmi değiştir123
                    </label>
                </div>
            </div>

            <input type="file" id="inputImage" name="kapakResmiYolu" class="hidden" accept="image/*">

            {{-- <p class="text-sm/6 font-medium text-gray-900">Kampanya Detayları</p> --}}
            <select name="isletmeler_id" @class(['w-full border border-gray-300 rounded py-1.5'])>
                @if (auth()->user()->isletmeler->count() > 1)
                    <option value="">İşletme seçiniz</option>
                @endif
                @foreach (auth()->user()->isletmeler as $detay)
                    <option value="{{ encrypt($detay->isletme->isletmeler_id) }}"
                        {{ $etkinlik && $etkinlik->isletmeler_id == $detay->isletme->isletmeler_id ? 'selected' : '' }}>
                        {{ $detay->isletme->baslik }}
                    </option>
                @endforeach
            </select>

            <x-relative-input type="text" name="baslik" label="Kampanya başlığı"
                value="{{ optional($etkinlik)->baslik }}" required />

            <input type="hidden" name="etkinlik_turleri_id" value="{{ encrypt(14) }}">

            <div class="grid sm:grid-cols-2 gap-2">
                <x-datetime name="etkinlikBaslamaTarihi" label="Kampanya başlama tarihi"
                    value="{{ optional($etkinlik)->etkinlikBaslamaTarihi }}" />

                <x-datetime name="etkinlikBitisTarihi" label="Kampanya bitiş tarihi"
                    value="{{ optional($etkinlik)->etkinlikBitisTarihi }}" />
            </div>


            <x-relative-input type="text" name="harita" label="Google Harita (iframe kodu)"
                value="{{ optional($etkinlik)->harita }}" />

            <div class="iframe">
                {!! optional($etkinlik)->harita !!}
            </div>

            <select name="katilimTipi" class="w-full border border-gray-300 rounded py-1.5">
                <option value="">Katılım tipi seçiniz</option>
                <option value="genel" {{ optional($etkinlik)->katilimTipi === 'genel' ? 'selected' : '' }}>Genel
                </option>
                <option value="uniportal" {{ optional($etkinlik)->katilimTipi === 'uniportal' ? 'selected' : '' }}>
                    Uniportal</option>
            </select>

            {{-- <p class="text-sm/6 font-medium text-gray-900">Dosya ve Resimler</p> --}}

            <x-textarea rows="3" name="katilimSarti" placeholder="Katılım şartları">
                {{ optional($etkinlik)->katilimSarti }}
            </x-textarea>

        </div>

        <div class="flex flex-col gap-4 shadow p-4 rounded">
            {{-- <label for="harita" class="text-sm/6 font-medium text-gray-900">Google Harita (iframe kodu)</label>

            <x-textarea rows="1" name="harita" id="harita" placeholder=""></x-textarea> --}}
            <x-file-upload text="/Resim veya Dosya seç ya da buraya bırak" url="yonetim/etkinlikler/dosya-yukle" />

            <p class="text-lg font-medium text-gray-900 mb-0">Kampanya Açıklaması</p>
            @include('yonetim.kampanya.partials.editor')

            {{-- <p class="text-sm/4 font-medium text-gray-900">Katılım tipi</p> --}}
            {{-- <div class="flex flex-col"> --}}
            {{-- <x-radio name="katilimTipi" value="genel" checked>
                    <span>Genel</span>
                    <span class="text-gray-500 font-normal">Kampanyaya herkes katılabilir.</span>
                </x-radio>
                <x-radio name="katilimTipi" value="uniportal">
                    <span>Uniportal</span>
                    <span class="text-gray-500 font-normal">Sadece Uniportal üyeleri katılabilir.</span>
                </x-radio>
                <x-radio name="katilimTipi" value="özel">
                    <span>Özel</span>
                    <span class="text-gray-500 font-normal">Sadece davet edilenler katılabilir.</span>
                </x-radio> --}}

            {{-- </div> --}}

            <p class="text-lg font-medium text-gray-900 border-b border-t py-2">Kampanya İzinleri</p>

            <x-checkbox name="yorumDurumu" :checked="optional($etkinlik)->yorumDurumu">
                <span>Yorumlara kapat</span>
                <span class="text-gray-500 font-normal text-xs">Kampanyayı yoruma kapatmak için seçiniz.</span>
            </x-checkbox>


            <x-checkbox name="sosyalMedyadaPaylas" :checked="optional($etkinlik)->sosyalMedyadaPaylas">
                <span>Sosyal medyamızda paylaş</span>
                <span class="text-gray-500 font-normal text-xs">
                    Kampanyanın sosyal medya hesabımızda paylaşılması için seçiniz.</span>
            </x-checkbox>

            <x-checkbox name="mailDurumu" :checked="optional($etkinlik)->mailDurumu">
                <span>Mail bildirimleri almak istiyorum</span>
                <span class="text-gray-500 font-normal text-xs">
                    Katılım isteklerini mail ile almak için seçiniz.
                </span>
            </x-checkbox>

            <div class="text-right">
                <x-button type="submit"
                    class="kampanya-submit-button justify-center w-full !bg-blue-600 !border-none !text-white !tracking-wider">
                    {{ optional($etkinlik) ? 'Kampanyayı güncelle' : 'Kampanyayı yayınla' }}
                </x-button>
            </div>
        </div>

    </form>
</section>
