@foreach ($personeller as $personel)
    @php
        $personelId = encrypt($personel->kullanicilar_id);
    @endphp
    <div class="flex items-center gap-2">
        <input type="checkbox" name="kullanicilar_id[]" id="checkbox_{{ $personelId }}" value="{{ $personelId }}"
            data-email="{{ $personel->email }}"
            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
        <label for="checkbox_{{ $personelId }}">{{ $personel->ad . ' ' . $personel->soyad }}</label>
    </div>
@endforeach
