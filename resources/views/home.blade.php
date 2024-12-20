@extends('layouts.app')

@section('title', 'Anasayfa')

@section('content')

    <style>
        .note-modal-footer {
            height: 60px !important;
        }

        .close {
            display: none;
        }

        #test {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
        }

    </style>

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Summernote CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.min.css" rel="stylesheet"> --}}
    <link href="{{ asset('summernote/summernote-lite.min.css') }}" rel="stylesheet">
    <!-- Bootstrap (Opsiyonel) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <textarea id="summernote"></textarea>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Bootstrap (Opsiyonel) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Summernote JS -->
    <script src="{{ asset('summernote/summernote-lite.min.js') }}"></script>

    <script>
        
    </script>

    <script>

        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Metni buraya yazın...',
                tabsize: 2,
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'myFile']], // 'myFile' özel buton
                    ['view', ['fullscreen', 'codeview']]
                ],
                buttons: {
                    myFile: function(context) {
                        var ui = $.summernote.ui;
                        // Özel dosya yükleme butonu
                        var button = ui.button({
                            contents: '<i class="note-icon-paperclip"></i> Dosya',
                            tooltip: 'Dosya Yükle',
                            click: function() {
                                var input = document.createElement('input');
                                input.type = 'file';
                                input.accept =
                                    'application/pdf'; // Sadece PDF kabul ediliyor
                                input.onchange = function() {
                                    var file = input.files[0];

                                    // MIME türünü kontrol et
                                    if (file.type !== 'application/pdf') {
                                        document.body.innerHTML += `
                        <button id="test" onClick="tiklabana()">
                                        <div class="flex items-center bg-blue-500 text-white text-sm font-bold w-96 h-24 myAlert" role="alert">
                                            <p>pdf değil bu</p>
                                        </div>
                                        </button>
                                        `
                                        return; // İşlemi durdur
                                    }

                                    var formData = new FormData();
                                    formData.append('file', file);

                                    /*
                                                                        Laravel'e dosya gönderme kodu
                                                                        $.ajax({
                                                                            url: '/upload-file', // Laravel'deki rota
                                                                            method: 'POST',
                                                                            data: formData,
                                                                            processData: false,
                                                                            contentType: false,
                                                                            success: function(response) {
                                                                                Başarıyla yüklendiğinde dosyayı ekle
                                                                                context.invoke(
                                                                                    'editor.insertText',
                                                                                    response.file_url);
                                                                            },
                                                                            error: function() {
                                                                                alert(
                                                                                    'Dosya yükleme başarısız.');
                                                                            }
                                                                        });
                                    */
                                };
                                input.click();
                            }
                        });
                        return button.render();
                    }
                }
            });
        });
    </script>



@endsection
