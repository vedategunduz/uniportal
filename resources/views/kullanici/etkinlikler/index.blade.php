@extends('layouts.auth')

@section('title', 'User dashboard')

@section('links')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
@endsection

@section('content')
    <h3 class="font-semibold mb-4">Etkinlikler</h3>
    <div class="flex justify-between items-center mb-4">
        <input type="text" name="q" id="q"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5"
            placeholder="Ara...">

        <button type="button" data-modal-target="etkinlikModal"
            class="py-2 px-3 rounded-md shadow-md text-white bg-blue-600 hover:bg-blue-700 transition flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-5 me-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>

            <span>Etkinlik Ekle</span>
        </button>
    </div>
    <section id="etkinlikModal"
        class="hidden fixed top-0 left-0 w-screen h-screen inset-0 z-10 overflow-auto max-h-screen py-4">
        <button type="button" title="modalı kapat" class="fixed top-0 left-0 w-full h-full bg-black/30 cursor-pointer z-20"
            data-modal-target="etkinlikModal"></button>

        <div class="mx-auto max-w-screen-xl z-30 relative">
            <div class="bg-white rounded-md">
                <x-etkinlik-modal />
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('js/etkinlik-form.js') }}"></script>
    <script src="{{ asset('js/data-table.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#etkinlikAciklama').summernote({
                height: 200,
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
                    ['mybutton', ['uploadDoc']]
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
