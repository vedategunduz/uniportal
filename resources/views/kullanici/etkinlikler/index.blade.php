@extends('layouts.auth')

@section('title', 'User dashboard')

@section('links')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <style>
        select.dt-input {
            width: 60px;
        }

        #resimcontainer img{
            max-width: 100%;
            max-height: 300px;
            object-fit: contain;
        }
    </style>
@endsection

@section('content')
    <h3 class="font-semibold mb-4">Etkinlikler</h3>
    <div class="mb-4">
        <button type="button" data-modal-target="etkinlikModal"
            class="open-modal py-2 px-3 rounded-md shadow-md text-white bg-blue-600 hover:bg-blue-700 transition flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-5 me-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>

            <span>Etkinlik Ekle</span>
        </button>
    </div>

    <section id="etkinlikModal"
        class="hidden fixed top-0 left-0 w-screen h-screen inset-0 z-10 overflow-auto max-h-screen py-4">
        <button type="button" title="modalı kapat"
            class="close-modal fixed top-0 left-0 w-full h-full bg-black/30 cursor-pointer z-20"
            data-modal-target="etkinlikModal"></button>

        <div class="mx-auto max-w-screen-xl z-30 relative">
            <div class="bg-white rounded-md" id="etkinlikModalContent"></div>
        </div>
    </section>

    <table id="myTable">
        <thead>
            <tr>
                <th>Başlık</th>
                <th>Kontenjan</th>
                <th>Etkinlik Başlama</th>
                <th>Etkinlik Bitiş</th>
                <th>Başvuru Başlama</th>
                <th>Başvuru Bitiş</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($etkinlikler as $etkinlik)
                <tr>
                    <td>{{ $etkinlik->baslik }}</td>
                    <td>{{ $etkinlik->kontenjan }}</td>
                    <td>{{ $etkinlik->etkinlikBaslamaTarihi }}</td>
                    <td>{{ $etkinlik->etkinlikBitisTarihi }}</td>
                    <td>{{ $etkinlik->etkinlikBasvuruTarihi }}</td>
                    <td>{{ $etkinlik->etkinlikBasvuruBitisTarihi }}</td>
                    <td><button class="etkinlikDuzenleButton" data-modal-target="etkinlikModal"
                            data-target="{{ encrypt($etkinlik->etkinlikler_id) }}" type="button"
                            class="px-3 py-1 border rounded-md">Düzenle</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')
    <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script>
        let table = new DataTable('#myTable', {
            responsive: true,
            language: {
                "decimal": ",",
                "emptyTable": "Tabloda veri yok",
                "info": " _START_ - _END_ arasında _TOTAL_ kayıt gösteriliyor",
                "infoEmpty": "0 kayıttan 0'ı gösteriliyor",
                "infoFiltered": " (Toplam _MAX_ kayıttan filtrelendi)",
                "infoPostFix": "",
                "thousands": ".",
                "lengthMenu": "Sayfada _MENU_ adet kayıt göster",
                "loadingRecords": "Yükleniyor...",
                "processing": "İşleniyor...",
                "search": "Ara:",
                "zeroRecords": "Eşleşen kayıt bulunamadı",
                "paginate": {
                    "first": "<<",
                    "last": ">>",
                    "next": ">",
                    "previous": "<"
                },
                "aria": {
                    "orderable": "Bu sütunu sırala",
                    "orderableReverse": "Bu sütunun ters sırayla sıralanmasını sağla"
                }
            }
        });


        function changeModal($url) {
            try {
                fetch($url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('etkinlikModalContent').innerHTML = data.html;

                        document.getElementById('etkinlikKapakResmi').addEventListener('change', function(event) {
                            const resimContainer = document.getElementById('resimcontainer');
                            resimContainer.innerHTML = ''; // Önceki resmi temizle

                            const dosya = event.target.files[0];
                            if (dosya && dosya.type.startsWith('image/')) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    const img = document.createElement('img');
                                    img.src = e.target.result;
                                    img.alt = 'Seçilen Kapak Resmi';
                                    resimContainer.appendChild(img);
                                }
                                reader.readAsDataURL(dosya);
                            } else {
                                resimContainer.innerHTML =
                                    '<p class="text-red-500">Lütfen geçerli bir resim dosyası seçin.</p>';
                            }
                        });
                        // KATILIM SINIRLAMA
                        let katilimSinirlamaCount = 0;
                        document.getElementById('katilimSinirlamaContainer')
                            .querySelectorAll('input[type="checkbox"]')
                            .forEach(function(checkbox) {
                                checkbox.addEventListener('change', function() {
                                    if (this.checked) {
                                        katilimSinirlamaCount++;
                                    } else {
                                        katilimSinirlamaCount--;
                                    }

                                    if (katilimSinirlamaCount > 0) {
                                        document.getElementById('katilimSinirlamaText').innerText =
                                            `(${katilimSinirlamaCount} adet seçim yapıldı)`;
                                    } else {
                                        document.getElementById('katilimSinirlamaText').innerText =
                                            '(Opsiyonel)';
                                    }
                                });
                            });
                        // DROPDOWN
                        document.querySelectorAll('.dropdown-btn').forEach(function(button) {
                            button.addEventListener('click', function() {
                                const DROPDOWN_CONTENT = this.nextElementSibling;
                                DROPDOWN_CONTENT.classList.toggle('hidden');
                            });
                        });
                        // FORM
                        const form = document.getElementById('etkinlikForm');
                        form.addEventListener('submit', async function(event) {
                            event.preventDefault();

                            const csrfToken = document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content');

                            const formData = new FormData(form);
                            const postUrl = form.getAttribute('action');

                            try {
                                const response = await fetch(postUrl, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken,
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'Accept': 'application/json'
                                    },
                                    body: formData
                                });

                                if (!response.ok) {
                                    throw new Error('Ağ yanıtı uygun değil: ' + response
                                        .statusText);
                                }

                                const responseData = await response.json();
                                console.log('Başarılı:', responseData);
                                if (responseData.success) {
                                    document.getElementById('etkinlikModal').classList.add(
                                        'hidden');
                                }
                            } catch (error) {
                                console.error('Hata:', error);
                            }
                        });
                        // SUMMERNOTE
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
                                                    let file = fileInput[0]
                                                        .files[0];
                                                    if (file) {
                                                        uploadFile(file,
                                                            context);
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
                                            let fileLink =
                                                `<a href="${response.url}" target="_blank">${file.name}</a>`;

                                            // Summernote'a HTML olarak eklemek için:
                                            context.invoke('editor.pasteHTML', fileLink +
                                                '<br>');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(error);
                                    }
                                });
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Hata:', error);
                    });
            } catch (error) {
                console.error('Hata:', error);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.open-modal').forEach(function(button) {
                button.addEventListener('click', function() {
                    changeModal(`{{ url('kullanici/etkinlikler/modal/ekle') }}`);
                    const modal = document.getElementById(button.dataset.modalTarget);
                    modal.classList.remove('hidden');
                });
            });

            document.getElementById('etkinlikModal').addEventListener('click', function(event) {
                if (event.target.matches('.close-modal')) {
                    const modalId = event.target.getAttribute('data-modal-target');
                    const modal = document.getElementById(modalId);
                    modal.classList.add('hidden');
                }
            });

            document.querySelectorAll('.etkinlikDuzenleButton').forEach(function(button) {
                button.addEventListener('click', function() {
                    changeModal(
                        `{{ url('kullanici/etkinlikler/modal/duzenle/${button.dataset.target}') }}`
                    );

                    const modalId = event.target.getAttribute('data-modal-target');
                    const modal = document.getElementById(modalId);
                    modal.classList.remove('hidden');
                });
            });
        });
    </script>
@endsection
