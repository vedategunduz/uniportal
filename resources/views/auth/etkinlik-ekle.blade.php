@extends('layouts.user.app')

@section('title', 'User dashboard')

@section('aside')
    <nav class="">
        <ul>
            <li><a href="{{ route('cikis_yap') }}" class="">Çıkış</a></li>
        </ul>
    </nav>
@endsection

@section('content')
    <form action="{{ route('etkinlik_ekle') }}" method="POST" class="space-y-3 w-96 mx-auto">
        <h1>Etkinlik</h1>
        @csrf
        <div class="">
            <select name="kamular_id" id="kamular_id">
                <option value="">---</option>
                @foreach ($kamular as $kamu)
                    <option value="{{ encrypt($kamu->kamular_id) }}">{{ $kamu->baslik }}</option>
                @endforeach
            </select>
        </div>
        <div class="">
            <select name="etkinlik_turleri_id">
                <option value="">---</option>
                @foreach ($etkinlik_turleri as $etkinlik_tur)
                    <option value="{{ encrypt($etkinlik_tur->etkinlik_turleri_id) }}">{{ $etkinlik_tur->tur }}</option>
                @endforeach
            </select>
        </div>
        <div class="">
            <x-label for="aciklama" text="Açıklama:" />
            <textarea name="aciklama" id="aciklama" cols="30" rows="10">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Neque suscipit quod cupiditate quaerat, totam ab, iure veritatis cumque illum molestiae nam magnam atque quam iste. Magnam provident quibusdam fuga atque?</textarea>
        </div>
        <div class="flex gap-4">
            <div class="">
                <x-label for="etkinlik_basvuru_tarihi" text="Başvuru tarihi" />
                <x-input type="datetime-local" id="etkinlik_basvuru_tarihi" name="etkinlik_basvuru_tarihi" />
            </div>
            <div class="">
                <x-label for="etkinlik_basvuru_bitis_tarihi" text="Başvuru bitiş tarihi" />
                <x-input type="datetime-local" id="etkinlik_basvuru_bitis_tarihi" name="etkinlik_basvuru_bitis_tarihi" />
            </div>
        </div>

        <div class="flex gap-4">
            <div class="">
                <x-label for="etkinlik_baslama_tarihi" text="Başlama tarihi" />
                <x-input type="datetime-local" id="etkinlik_baslama_tarihi" name="etkinlik_baslama_tarihi" />
            </div>
            <div class="">
                <x-label for="etkinlik_bitis_tarihi" text="Bitiş tarihi" />
                <x-input type="datetime-local" id="etkinlik_bitis_tarihi" name="etkinlik_bitis_tarihi" />
            </div>
        </div>

        <x-button type="submit" text="Ekle" />
    </form>
@endsection
