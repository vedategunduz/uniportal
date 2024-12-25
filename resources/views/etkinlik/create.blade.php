@extends('layouts.auth')

@section('title', 'User dashboard')

@section('links')
    <link href="/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />
@endsection

@section('aside')
    <nav class="">
        <ul>
            <li><a href="{{ route('kullanici.cikis') }}" class="">Çıkış</a></li>
        </ul>
    </nav>
@endsection

@section('content')

    <div id="toolbar-container">
        <span class="ql-formats">
            <select class="ql-font"></select>
            <select class="ql-size"></select>
        </span>
        <span class="ql-formats">
            <button class="ql-bold"></button>
            <button class="ql-italic"></button>
            <button class="ql-underline"></button>
            <button class="ql-strike"></button>
        </span>
        <span class="ql-formats">
            <select class="ql-color"></select>
            <select class="ql-background"></select>
        </span>
        <span class="ql-formats">
            <button class="ql-script" value="sub"></button>
            <button class="ql-script" value="super"></button>
        </span>
        <span class="ql-formats">
            <button class="ql-header" value="1"></button>
            <button class="ql-header" value="2"></button>
            <button class="ql-blockquote"></button>
            <button class="ql-code-block"></button>
        </span>
        <span class="ql-formats">
            <button class="ql-list" value="ordered"></button>
            <button class="ql-list" value="bullet"></button>
            <button class="ql-indent" value="-1"></button>
            <button class="ql-indent" value="+1"></button>
        </span>
        <span class="ql-formats">
            <button class="ql-direction" value="rtl"></button>
            <select class="ql-align"></select>
        </span>
        <span class="ql-formats">
            <button class="ql-link"></button>
            <button class="ql-image"></button>
            <button class="ql-video"></button>
            <button class="ql-formula"></button>
        </span>
        <span class="ql-formats">
            <button class="ql-clean"></button>
        </span>
    </div>
    <div id="editor">
    </div>

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
    <!-- Initialize Quill editor -->
<script>
    const quill = new Quill('#editor', {
      modules: {
        syntax: true,
        toolbar: '#toolbar-container',
      },
      placeholder: 'Compose an epic...',
      theme: 'snow',
    });
  </script>
@endsection
