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
    </style>
@endsection

@section('content')
    <form action="{{ route('editor.store') }}" method="POST">
        @csrf
        <div class="use-the-bootstrap">
        </div>

        <div class="mb-3" class="use-the-bootstrap">
            <label for="icerik" class="form-label">İçerik</label>
            <textarea id="summernote" name="icerik"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Kaydet</button>
    </form>
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
