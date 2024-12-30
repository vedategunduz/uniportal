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
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">

    <div class="grid">
        <table id="myTable">
            <thead>
                <tr>
                    <th>Başlık</th>
                    <th>Başvuru Tarihi</th>
                    <th>Başvuru Bitiş Tarihi</th>
                </tr>
            </thead>
            <tbody id="eklenecek">
                @for ($i = 0; $i < 10; $i++)
                    @foreach ($etkinlikler as $etkinlik)
                        <tr>
                            <td>{{ $etkinlik->baslik }}</td>
                            <td>{{ $etkinlik->etkinlikBasvuruTarihi }}</td>
                            <td><img src="{{ asset('storage/' . $etkinlik->kapakResmiYolu) }}" class="size-12"
                                    alt=""></td>
                        </tr>
                    @endforeach
                @endfor
            </tbody>
        </table>

        <button id="tikla">dwqwq</button>
    </div>
    <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script>
        let table = new DataTable('#myTable');
        document.getElementById('tikla').addEventListener('click', function() {
            table.row.add([
                '1',
                '2',
                '3'
            ]).draw();
        });
    </script>

    <section id="etkinlikModal"
        class="hidden fixed top-0 left-0 w-screen h-screen inset-0 z-10 overflow-auto max-h-screen py-4">
        <button type="button" title="modalı kapat"
            class="fixed top-0 left-0 w-full h-full bg-black/30 cursor-pointer z-20"
            data-modal-target="etkinlikModal"></button>

        <div class="mx-auto max-w-screen-xl z-30 relative">
            <div class="bg-white rounded-md">
                <header class="flex justify-between rounded-t-md items-center p-4 border-b bg-blue-700 text-white">
                    <h2 class="font-medium text-lg">Yeni Etkinlikler Oluştur</h2>

                    <button type="button" data-modal-target="etkinlikModal">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </header>

                 <div id="kabuk"></div>
                {{-- <section class="px-4 py-8">
                    <form method="POST" id="etkinlikForm" class="grid md:grid-cols-2 gap-4">
                        <section>
                            <div class="mb-3">
                                <select name="etkinlikIsletme" id="etkinlikIsletme"
                                    class="bg-gray-50 border font-medium border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    @if ($isletmeler->count() > 1)
                                        <option selected>İşletme seçin</option>
                                    @endif
                                    @foreach ($isletmeler as $isletme)
                                        <option value="{{ encrypt($isletme->isletmeBilgileri->isletmeler_id) }}">
                                            {{ $isletme->isletmeBilgileri->baslik }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 font-medium">
                                <x-input id="etkinlikBaslik" type="text" name="etkinlikBaslik"
                                    placeholder="Etkinlik Adı" />
                            </div>
                            <div class="my-3">
                                <select name="etkinlikTur" id="etkinlikTur"
                                    class="bg-gray-50 border font-medium border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option>Etkinlik Kategorisi</option>
                                    @foreach ($etkinlikTurleri as $etkinlikTur)
                                        <option value="{{ encrypt($etkinlikTur->etkinlik_turleri_id) }}">
                                            {{ $etkinlikTur->baslik }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 grid md:grid-cols-3 gap-4">
                                <div class="md:col-span-1">
                                    <button disabled="disabled"
                                        class="bg-blue-700 border font-medium border-blue-300 text-white text-xs md:text-sm rounded-lg w-full focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                                        Etkinlik Başlangıç/Bitiş
                                    </button>
                                </div>
                                <div class="">
                                    <input type="datetime-local" name="etkinlikBaslangic" id="etkinlikBaslangic"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                </div>
                                <div class="">
                                    <input type="datetime-local" name="etkinlikBitis" id="etkinlikBitis"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                </div>
                            </div>
                            <div class="mb-3 grid md:grid-cols-3 gap-4">
                                <div class="md:col-span-1">
                                    <button disabled="disabled"
                                        class="bg-blue-700 border font-medium border-blue-300 text-white text-xs md:text-sm rounded-lg w-full focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                                        Başvuru Başlangıç/Bitiş
                                    </button>
                                </div>
                                <div class="">
                                    <input type="datetime-local" name="etkinlikBasvuru" id="etkinlikBasvuru"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                </div>
                                <div class="">
                                    <input type="datetime-local" name="etkinlikBasvuruBitis" id="etkinlikBasvuruBitis"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                </div>
                            </div>
                            <div class="mb-3">
                                <x-label for="etkinlikAciklama" text="Açıklama" />
                                <textarea id="etkinlikAciklama" name="etkinlikAciklama"></textarea>
                            </div>
                        </section>

                        <section class="">
                            <div class="mb-3">
                                <label for="etkinlikKapakResmi"
                                    class="h-36 border-2 border-dashed flex items-center justify-center cursor-pointer hover:bg-gray-50 transition">
                                    <span class="font-medium text-gray-500">Kapak resmi</span>
                                </label>
                                <input type="file" name="etkinlikKapakResmi" class="sr-only" id="etkinlikKapakResmi"
                                    accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label for="etkinlikDigerResimler"
                                    class="h-48 border-2 border-dashed flex items-center justify-center cursor-pointer hover:bg-gray-50 transition">
                                    <span class="font-medium text-gray-500">Diğer resimler</span>
                                </label>
                                <input type="file" name="etkinlikDigerResimler[]" class="sr-only"
                                    id="etkinlikDigerResimler" accept="image/*">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-3">
                                    <input type="number" name="etkinlikKontenjan" id="etkinlikKontenjan" min="0"
                                        placeholder="Kontenjan giriniz"
                                        class="bg-gray-50 font-medium border border-gray-300 text-gray-900 text-sm rounded-lg w-full focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                                </div>
                                <div class="mb-3">
                                    <select name="etkinlikIl" id="etkinlikIl"
                                        class="bg-gray-50 border font-medium border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="">Etkinlik Düzenlendiği İl</option>
                                        @foreach ($iller as $il)
                                            <option value="{{ encrypt($il->iller_id) }}">{{ $il->baslik }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <button type="button" id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
                                class="flex items-center font-medium justify-between border text-sm py-2 px-3 text-gray-900 rounded-md hover:bg-gray-50 transition w-full">
                                <span>Katılım Sınırlaması <span class="text-gray-600 text-xs">(Opsiyonel)</span></span>
                                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="dropdownNavbar"
                                class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow py-2">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-2 p-4  h-48 overflow-auto">
                                    @foreach ($iller as $il)
                                        @php
                                            $sifreli_il_id = 'checbox_' . encrypt($il->iller_id);
                                        @endphp
                                        <div class="flex items-center">
                                            <input id="{{ $sifreli_il_id }}" type="checkbox"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="{{ $sifreli_il_id }}"
                                                class="ms-2 text-sm font-medium text-gray-900 select-none">{{ $il->baslik }}</label>
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="my-3">
                                    <label class="cursor-pointer flex justify-between items-center gap-4">
                                        <span class="text-sm font-medium text-gray-900">Yorum yapmayı
                                            kapat</span>
                                        <input type="checkbox" name="etkinlikYorumDurumu" class="sr-only peer" checked>
                                        <div
                                            class=" -ml-96  relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                        </div>
                                    </label>
                                    <p class="text-xs text-gray-500">Etkinliği yoruma kapatır.</p>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="">
                                    <label class="cursor-pointer flex justify-between items-center gap-4">
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Sosyal medyada
                                            paylaş</span>
                                        <input type="checkbox" name="etkinlikSosyalMedyadaPaylas" class="sr-only peer"
                                            checked>
                                        <div
                                            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                        </div>
                                    </label>
                                    <p class="text-xs text-gray-500">Etkinlik
                                        instagram sayfanızda yayınlanır.</p>
                                </div>
                            </div>


                            <div class="flex items-center justify-end gap-2 mt-8 border-t pt-4">
                                <button type="button" data-modal-target="etkinlikModal"
                                    class="py-2 px-3 rounded-md border text-gray-900 hover:bg-gray-50 transition">Vazgeç</button>
                                <button type="submit"
                                    class="py-2 px-3 rounded-md text-white bg-blue-600 hover:bg-blue-700 transition">Etkinlik
                                    Oluştur</button>
                            </div>
                        </section>
                    </form>
                </section> --}}
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
