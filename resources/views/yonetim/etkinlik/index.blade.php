@extends('layouts.auth')

@section('title', 'Etkinlik Yönetimi')

@section('content')
    <header class="flex justify-between items-center mb-4">
        <h4>Etkinlik Yönetimi</h4>
        <button type="button" class="bg-emerald-500 text-sm pl-2 py-1.5 pr-4 rounded flex items-center text-white open-modal"
            data-modal="modal" data-id="{{ encrypt(0) }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="size-5 pointer-events-none">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span class="pointer-events-none">
                Ekle
            </span>
        </button>
    </header>


    <div id="modal" class="custom-modal hidden">
        <section class="modal-outside close-modal" data-modal="modal"></section>

        <section id="modal-content" class="modal-content max-w-screen-lg rounded max-h-screen overflow-auto hidden-scroll"></section>
    </div>
@endsection

@section('scripts')
    <script>
        window.addEventListener('click', function(event) {
            if (event.target.matches('.open-modal')) {
                const modal = document.getElementById(event.target.dataset.modal);
                const modalContent = modal.querySelector('#modal-content');

                (async () => {
                    const RESPONSE_DATA = await fetchData(`api/modal/etkinlik/${event.target.dataset.id}`);

                    if (RESPONSE_DATA.success) {
                        modalContent.innerHTML = RESPONSE_DATA.html;

                        $(document).ready(function() {
                            $('#summernote').summernote({
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
                                        var button = ui.button({
                                            contents: '<i class="note-icon-plus"/> Dosya Yükle',
                                            tooltip: 'Doküman Yükle (pdf, docx vs)',
                                            click: function() {
                                                let fileInput = $(
                                                    '<input/>').attr({
                                                    type: 'file',
                                                    accept: '.pdf,.doc,.docx'
                                                });
                                                fileInput.click();

                                                fileInput.on('change',
                                                    function() {
                                                        let file =
                                                            fileInput[0]
                                                            .files[0];
                                                        if (file) {
                                                            uploadFile(
                                                                file,
                                                                context
                                                            );
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
                                    url: '',
                                    type: 'POST',
                                    data: data,
                                    contentType: false,
                                    processData: false,
                                    success: function(response) {
                                        if (response.url) {
                                            let fileLink =
                                                `<a href="${response.url}" target="_blank">${file.name}</a>`;
                                            context.invoke('editor.pasteHTML',
                                                fileLink + '<br>');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(error);
                                    }
                                });
                            }
                        });
                    } else
                        errorAlert('İçerik eklenemedi.');
                })();
            }
        });
    </script>
@endsection
