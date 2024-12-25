@extends('layouts.auth')

@section('title', 'User dashboard')

@section('links')

@endsection

@section('aside')
    <nav class="">
        <ul>
            <li><a href="{{ route('kullanici.cikis') }}" class="">Çıkış</a></li>
        </ul>
    </nav>
@endsection

@section('content')

    <!-- Include stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-beta.0/dist/quill.snow.css" rel="stylesheet" />

    <!-- Create the editor container -->
    <div id="editor">
        <p>Hello World!</p>
        <p>Some initial <strong>bold</strong> text</p>
        <p><br /></p>
    </div>

    <!-- Include the Quill library -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.0-beta.0/dist/quill.js"></script>

    <!-- Initialize Quill editor -->
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow'
        });
    </script>
    
    <form action="{{ route('etkinlik.ekle.store') }}" method="POST" class="max-w-sm mx-auto">
        <h1 class="text-4xl font-medium mb-6">Etkinlik</h1>

        @csrf

        <select name="kamular_id" id="kamular_id"
            class="bg-gray-50 border border-gray-300 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option selected>Kamu seç</option>
            @foreach ($kamular as $kamu)
                <option value="{{ encrypt($kamu->kamuBilgileri->kamular_id) }}">{{ $kamu->kamuBilgileri->baslik }}
                </option>
            @endforeach
        </select>

        <select name="etkinlik_turleri_id"
            class="bg-gray-50 border border-gray-300 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option selected>Etkinlik türü seç</option>
            @foreach ($etkinlikTurleri as $tur)
                <option value="{{ encrypt($tur->etkinlik_turleri_id) }}">{{ $tur->tur }}</option>
            @endforeach
        </select>

        <div class="mb-3">
            <x-label for="aciklama" text="Açıklama:" />
            <x-textarea id="aciklama" name="aciklama" />
        </div>

        <div class="flex gap-4">
            <x-form-control for="etkinlik_basvuru_tarihi" text="Başvuru tarihi" type="datetime-local"
                id="etkinlik_basvuru_tarihi" name="etkinlik_basvuru_tarihi" />

            <x-form-control for="etkinlik_basvuru_bitis_tarihi" text="Başvuru bitiş tarihi" type="datetime-local"
                id="etkinlik_basvuru_bitis_tarihi" name="etkinlik_basvuru_bitis_tarihi" />
        </div>

        <div class="flex gap-4">
            <x-form-control for="etkinlik_baslama_tarihi" text="Başlama tarihi" type="datetime-local"
                id="etkinlik_baslama_tarihi" name="etkinlik_baslama_tarihi" />

            <x-form-control for="etkinlik_bitis_tarihi" text="Bitiş tarihi" type="datetime-local" id="etkinlik_bitis_tarihi"
                name="etkinlik_bitis_tarihi" />
        </div>

        <x-button type="submit" text="Oluştur" />
    </form>
@endsection

@section('scripts')

@endsection
