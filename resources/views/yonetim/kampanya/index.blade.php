@extends('layouts.auth')

@section('title', 'Kampanya Yönetimi')

@section('content')
    <div class="mb-4">
        <img src="{{ asset('image/create_event_default.jpg') }}" class="w-full h-60 object-cover rounded" loading="lazy"
            alt="">
    </div>

    <form action="" class="space-y-4">
        <select name="isletmeler_id" @class([
            'w-full border border-gray-300 rounded py-1.5',
            'hidden' => auth()->user()->isletmeler->count() == 1,
        ])>
            <option value="">İşletme seçiniz</option>
            @foreach (auth()->user()->isletmeler as $detay)
                <option value="{{ encrypt($detay->isletme->isletmeler_id) }}">{{ $detay->isletme->baslik }}</option>
            @endforeach
        </select>

        <x-relative-input type="text" name="baslik" label="Kampanya başlığı" required />

        <input type="hidden" name="etkinlik_turleri_id" value="{{ encrypt(14) }}">

        <div class="grid sm:grid-cols-2 gap-2">
            <x-datetime name="etkinlikBaslamaTarihi" label="Kampanya başlama tarihi" />

            <x-datetime name="etkinlikBitisTarihi" label="Kampanya bitiş tarihi" />
        </div>

        @include('yonetim.kampanya.partials.editor')

        <x-file-upload />

        <x-checkbox name="yorumDurumu">
            <span class="">Yorumlara kapat</span>
            <span class="text-gray-500 font-normal">Kampanyayı yoruma kapatmak için seçiniz.</span>
        </x-checkbox>

        <x-checkbox name="sosyalMedyadaPaylas">
            <span class="">Sosyal medyamızda paylaş</span>
            <span class="text-gray-500 font-normal">
                Kampanyanın sosyal medya hesabımızda paylaşılması için seçiniz.</span>
        </x-checkbox>

        <x-button type="submit" class="kampanya-submit-button">
            Kaydet
        </x-button>
    </form>
@endsection

@section('scripts')
    <script>
        document.addEventListener('click', function(event) {
            event.target.closest('.kampanya-submit-button') && (async () => {
                event.preventDefault();

                const FORM = event.target.closest('form');
                const DATA = new FormData(FORM);

                DATA.append('aciklama', window.textEditor.getHTML());

                const URL = "{{ route('yonetim.kampanyalar.store') }}";
                const RESPONSE = await ApiService.fetchData(URL, DATA, 'POST');

                if (RESPONSE.status === 201) {
                    ApiService.alert.success(RESPONSE.data.message);
                } else {
                    ApiService.alert.error(RESPONSE.message);
                }
            })();
        });
    </script>
@endsection
