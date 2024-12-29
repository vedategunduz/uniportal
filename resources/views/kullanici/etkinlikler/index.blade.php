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

        <button data-modal-target="etkinlikModal"
            class="py-2 px-3 rounded-md shadow-md text-white bg-blue-600 hover:bg-blue-700 transition flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-5 me-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>

            <span>Etkinlik Ekle</span>
        </button>
    </div>
    <h3 class="mb-4">Başlık</h3>
    <p>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod illo quaerat cupiditate error vero doloremque
        laudantium dolore quam repellat hic, sit, veniam dolorum? Nam aut quaerat amet, voluptatum possimus suscipit?
    </p>

    <section id="etkinlikModal" aria-hidden="true" class="fixed top-0 left-0 w-full h-full inset-0 z-10">
        <button class="absolute top-0 left-0 w-full h-full bg-black/30 cursor-pointer z-20"
            data-modal-target="etkinlikModal"></button>

        <div class="mx-auto max-w-screen-sm z-30 relative">
            <div class="bg-white rounded-md overflow-auto max-h-screen">
                <header class="flex justify-between items-center p-4 border-b">
                    <h2 class="font-medium text-lg">Etkinlik Oluşturma</h2>

                    <button type="button" data-modal-target="etkinlikModal">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </header>

                <section class="px-4 py-8">
                    <div class="mb-3">
                        <x-label for="etkinlikAd" text="Etkinlik başlığı" />
                        <x-input id="etkinlikAd" type="text" name="etkinlikAd" />
                    </div>
                    <button
                        class="flex justify-between items-center w-full py-2 px-3 transition border rounded-md accordion-button">
                        <span>Etkinlik resimleri</span>

                        <svg class="size-2.5 ms-2.5 ml-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <div class="hidden">
                        <div class="">
                            <x-label for="etkinlikKapakResim" text="Kapak resmi" />
                            <x-label for="etkinlikResimler," text="Diğer resimler" />
                        </div>
                        <div class="grid grid-cols-3 gap-4 mt-4" id="etkinlikResimlerContainer"></div>
                        <input type="file" name="etkinlikResimler[]" id="etkinlikResimler" multiple class="hidden">
                    </div>

                    <div class="my-3">
                        <x-label for="etkinlikKategori" text="Etkinlik kategorisi" />
                        <select name="etkinlikKategori" id="etkinlikKategori"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Kategori seçiniz</option>
                            <option value="">Kategori 1</option>
                            <option value="">Kategori 2</option>
                            <option value="">Kategori 3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <x-label for="etkinlikIsletme" text="İşletme" />
                        <select name="etkinlikIsletme" id="etkinlikIsletme"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">İşletme seçiniz</option>
                            <option value="">İşletme 1</option>
                            <option value="">İşletme 2</option>
                            <option value="">İşletme 3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <x-label for="etkinlikIl" text="Düzenlenen il" />
                        <select name="etkinlikIl" id="etkinlikIl"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">İl seçiniz</option>
                            <option value="">İşletme 1</option>
                            <option value="">İşletme 2</option>
                            <option value="">İşletme 3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <x-label for="etkinlikKontenjan" text="Kontenjan" />
                        <input type="number" name="etkinlikKontenjan" id="etkinlikKontenjan" min="0"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                    <div class="mb-3 grid grid-cols-2 gap-4">
                        <div class="">
                            <x-label for="etkinlikBasvuru" text="Başvuru tarihi" />
                            <input type="datetime-local" name="etkinlikBasvuru" id="etkinlikBasvuru"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <div class="">
                            <x-label for="etkinlikBasvuruBitis" text="Başvuru bitiş tarihi" />
                            <input type="datetime-local" name="etkinlikBasvuruBitis" id="etkinlikBasvuruBitis"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                    </div>
                    <div class="mb-3 grid grid-cols-2 gap-4">
                        <div class="">
                            <x-label for="etkinlikBaslangic" text="Etkinlik başlangıç tarihi" />
                            <input type="datetime-local" name="etkinlikBaslangic" id="etkinlikBaslangic"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <div class="">
                            <x-label for="etkinlikBitis" text="Etkinlik bitiş tarihi" />
                            <input type="datetime-local" name="etkinlikBitis" id="etkinlikBitis"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                    </div>
                    <div class="mb-3">
                        <x-label for="etkinlikAciklama" text="Açıklama" />
                        <textarea id="etkinlikAciklama" name="aciklama"></textarea>
                    </div>
                    <div class="flex items-center justify-end gap-2 mt-8 border-t pt-4">
                        <button type="button" data-modal-target="etkinlikModal"
                            class="py-2 px-3 rounded-md border text-gray-900 hover:bg-gray-50 transition">Vazgeç</button>
                        <button type="submit"
                            class="py-2 px-3 rounded-md text-white bg-blue-600 hover:bg-blue-700 transition">Oluştur</button>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#etkinlikAciklama').summernote({
                height: 150,
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
