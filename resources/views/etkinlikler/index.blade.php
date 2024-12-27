@extends('layouts.auth')

@section('title', 'User dashboard')

@section('links')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    <style>
        a:hover {
            text-decoration: none;
            color: inherit
        }
        .modal-backdrop{
            z-index: 49!important;
        }
    </style>
@endsection

@section('content')
    <button data-modal-target="default-modal" data-modal-toggle="default-modal"
        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        type="button">
        Etkinlik ekle
    </button>

    <!-- Main modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Etkinlik Ekle
                    </h3>
                    <button type="button"
                        class= "text-gray-600 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form action="{{ route('etkinlik.ekle.store') }}" method="POST" class="">
                        @csrf
                        <select name="kamular_id" id="kamular_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            @if ($kamular->count() > 1)
                                <option selected>Kamu seç</option>
                            @endif

                            @foreach ($kamular as $kamu)
                                <option value="{{ encrypt($kamu->kamuBilgileri->kamular_id) }}">
                                    {{ $kamu->kamuBilgileri->baslik }}
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

                        <div class="mb-3 grid grid-cols-4 gap-4">
                            <label for="kapak_resmi" class="border-2 font-normal cursor-pointer hover:bg-gray-50 transition border-dashed flex justify-center items-center rounded-lg h-48 col-span-1">
                                <span>Kapak resmi</span>
                            </label>
                            <input type="file" name="" id="kapak_resmi" class="hidden">
                            <label for="diger_resimler" class="border-2 font-normal cursor-pointer hover:bg-gray-50 transition border-dashed flex justify-center items-center rounded-lg h-48 col-span-3">
                                <span>Diğer resimler</span>
                            </label>
                            <input type="file" name="" id="diger_resimler" class="hidden">
                        </div>

                        <div class="mb-3">
                            <x-label for="summernote" text="İçerik:"/>
                            <textarea id="summernote" name="icerik"></textarea>
                        </div>

                        <div class="flex gap-4">
                            <x-form-control for="etkinlik_basvuru_tarihi" text="Başvuru tarihi" type="datetime-local"
                                id="etkinlik_basvuru_tarihi" name="etkinlik_basvuru_tarihi" />

                            <x-form-control for="etkinlik_basvuru_bitis_tarihi" text="Başvuru bitiş tarihi"
                                type="datetime-local" id="etkinlik_basvuru_bitis_tarihi"
                                name="etkinlik_basvuru_bitis_tarihi" />
                        </div>

                        <div class="flex gap-4">
                            <x-form-control for="etkinlik_baslama_tarihi" text="Başlama tarihi" type="datetime-local"
                                id="etkinlik_baslama_tarihi" name="etkinlik_baslama_tarihi" />

                            <x-form-control for="etkinlik_bitis_tarihi" text="Bitiş tarihi" type="datetime-local"
                                id="etkinlik_bitis_tarihi" name="etkinlik_bitis_tarihi" />
                        </div>
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="default-modal" type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I
                        accept</button>
                    <button data-modal-hide="default-modal" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300,
                lang: 'tr-TR',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview']],
                    ['mybutton', ['uploadDoc']] // "uploadDoc" adında bir custom buton
                ],
                buttons: {
                    uploadDoc: function(context) {
                        var ui = $.summernote.ui;
                        // Butona tıklayınca bir file input ile dosya seçtireceğiz
                        var button = ui.button({
                            contents: '<i class="note-icon-plus"/> Dosya Yükle',
                            tooltip: 'Doküman Yükle (pdf, docx vs)',
                            click: function() {
                                let fileInput = $('<input/>').attr({
                                    type: 'file',
                                    accept: '.pdf,.doc,.docx', // istediğiniz dosya türleri
                                });
                                fileInput.click();

                                fileInput.on('change', function() {
                                    let file = fileInput[0].files[0];
                                    if (file) {
                                        uploadFile(file, context);
                                    }
                                });
                            }
                        });
                        return button.render();
                    }
                }
            });

            function uploadFile(file, context) {
                let data = new FormData();
                data.append('file', file);
                data.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: '{{ route('editor.file.yukle') }}',
                    type: 'POST',
                    data: data,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.url) {
                            // PDF veya DOCX gibi dosyaları Summernote içine <a> tagi olarak ekleyebiliriz.
                            // Örneğin:
                            let fileLink = `<a href="${response.url}" target="_blank">${file.name}</a>`;

                            // Summernote'a HTML olarak eklemek için:
                            context.invoke('editor.pasteHTML', fileLink + '<br>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });
    </script>
@endsection
