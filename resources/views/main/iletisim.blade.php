@extends('layouts.app')

@section('title', 'Hakkında')

@section('banner')
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3011.450861272685!2d27.581520076735455!3d40.993503971352496!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14b4f4fdb97d93a9%3A0x7f4ceb44179aabd!2sTekirda%C4%9F%20Nam%C4%B1k%20Kemal%20%C3%9Cniversitesi!5e0!3m2!1str!2str!4v1740747195985!5m2!1str!2str"
        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"></iframe>
@endsection

@section('content')

    <form action="{{ route('main.iletisim.store') }}" method="POST" enctype="multipart/form-data"
        class="max-w-screen-sm mx-auto mt-8 bg-white shadow-md p-6 rounded space-y-4">
        <h1 class="text-2xl font-semibold">İletişim</h1>

        @csrf
        <x-relative-input type="text" name="konu" label="Konu" required />

        <div class="grid grid-cols-2 gap-2">
            <x-relative-input type="text" name="ad" label="Ad"
                value="{{ auth()->check() ? auth()->user()->ad : '' }}" />
            <x-relative-input type="text" name="soyad" label="Soyad"
                value="{{ auth()->check() ? auth()->user()->soyad : '' }}" />
        </div>

        <x-relative-input type="email" name="email" label="E-Posta"
            value="{{ auth()->check() ? auth()->user()->email : '' }}" />

        <x-textarea name="mesaj" class="bg-white resize-none" rows="4" placeholder="Mesajınız" />

        @auth
            <!-- Dosya ekleme alanı -->
            <div class="file-drop-area">
                <input type="file" name="dosyalar[]" id="dosyalar" class="hidden" multiple>
                <label for="dosyalar" id="drop-area"
                    class="border border-dashed rounded border-gray-300 w-full py-6 justify-center flex items-center">
                    <span class="uppercase text-gray-500 font-medium text-xs">/ Dosya ekle veya dosyaları buraya bırak</span>
                </label>
            </div>

            <!-- Seçilen dosyaların gösterileceği alan -->
            <div id="file-list-container" class="mt-4"></div>
        @endauth

        <x-button type="submit">
            Gönder
        </x-button>
    </form>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    window.ApiService.alert.error("{{ $error }}");
                @endforeach
            @elseif (session('success'))
                window.ApiService.alert.success("{{ session('success') }}");
            @endif
        });
    </script>
    <script>
        const fileInput = document.getElementById('dosyalar');
        const dropArea = document.getElementById('drop-area');
        const fileListContainer = document.getElementById('file-list-container');

        // Seçilen dosyaları saklamak için dizi
        let selectedFiles = [];

        // File input'un değerini güncellemek için DataTransfer kullanıyoruz
        function updateFileInput() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => {
                dataTransfer.items.add(file);
            });
            fileInput.files = dataTransfer.files;
        }

        // Dosya listesini belirtilen yapıda oluşturup gösterir
        function updateFileList() {
            fileListContainer.innerHTML = ''; // Önceki listeyi temizle

            selectedFiles.forEach((file, index) => {
                // Ana kapsayıcı div
                const fileDiv = document.createElement('div');
                fileDiv.className = 'flex items-center py-2 gap-2 text-gray-500';

                // Dosya simgesi (paperclip)
                const icon = document.createElement('i');
                icon.className = 'bi bi-paperclip';
                fileDiv.appendChild(icon);

                // Dosya adını gösteren span
                const fileNameSpan = document.createElement('span');
                fileNameSpan.textContent = file.name;
                fileDiv.appendChild(fileNameSpan);

                // Kaldırma butonu (x)
                const removeButton = document.createElement('x-button');
                removeButton.className = 'ml-auto !shadow-none !bg-transparent !border-none !p-1';
                removeButton.innerHTML = '<i class="bi bi-x text-base cursor-pointer"></i>';
                removeButton.addEventListener('click', () => {
                    // İlgili dosyayı diziden kaldır
                    selectedFiles.splice(index, 1);
                    updateFileList();
                    updateFileInput();
                });
                fileDiv.appendChild(removeButton);

                fileListContainer.appendChild(fileDiv);
            });
        }

        // Dosya seçildiğinde (input aracılığıyla)
        fileInput.addEventListener('change', (e) => {
            // Yeni seçilen dosyaları alıp diziye ekle (tekrar seçilen dosyaları kontrol edebilirsiniz)
            const files = Array.from(e.target.files);
            selectedFiles = selectedFiles.concat(files);
            updateFileList();
            updateFileInput();
        });

        // Sürükle bırak işlemleri için varsayılan davranışı engelle
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        // Drop işlemi gerçekleştiğinde dosyaları dizimize ekle
        dropArea.addEventListener('drop', (e) => {
            const files = Array.from(e.dataTransfer.files);
            selectedFiles = selectedFiles.concat(files);
            updateFileList();
            updateFileInput();
        });
    </script>
@endsection
