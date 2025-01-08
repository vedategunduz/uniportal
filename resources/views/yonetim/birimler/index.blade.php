@extends('layouts.auth')

@section('title', 'User dashboard')

@section('links')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.0/css/dataTables.dataTables.css" />
    <style>
        select.dt-input {
            width: 60px;
        }

        .datatable-search {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
@endsection

@section('content')
    <div class="p-2 bg-blue-700 text-white mb-8 flex space-x-2 items-center justify-between">
        <h4 class="">Birim işlemleri</h4>
        <div class="flex item-center">
            <button class="bg-red-500 text-sm pl-2 py-1.5 pr-4 rounded flex items-center text-white">
                Birime yerleşmemiş kullanıcılar(30)
            </button>
            <button type="button" class="bg-emerald-500 text-sm pl-2 py-1.5 pr-4 rounded flex items-center text-white ms-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>
                    Ekle
                </span>
            </button>
        </div>
    </div>

    <table id="birimler" class="display nowrap  stripe" style="width:100%">
        <thead>
            <tr>
                <th class="w-96">Birim adı</th>
                <th data-dt-order="disable">Personel listesi</th>
                <th class="w-4" data-dt-order="disable"></th>
                <th class="w-4 " data-dt-order="disable"></th>
            </tr>
        </thead>
        <tbody id="tableBody">

        </tbody>
    </table>

    <section class="modal items-center justify-center" id="birimDetay">
        <div class="modal-outside close-modal" data-modal="birimDetay"></div>

        <div class="modal-content max-w-screen-sm min-h-24 p-6 rounded-lg">
            <header class="mb-6 flex justify-between">
                <div class="">
                    <h2 class="text-xl font-semibold text-gray-950">Birim detayları</h2>
                </div>
                <div class="">
                    <button class="close-modal" data-modal="birimDetay">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 pointer-events-none">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </header>

            <section id="modalContent">
                <x-birim-detay-modal />
            </section>
        </div>
    </section>

    <section class="modal items-center justify-center hidden" id="birimDegistir">
        <div class="modal-outside close-modal" data-modal="birimDegistir"></div>

        <div class="modal-content max-w-sm min-h-24 p-6 rounded-lg">
            <header class="mb-6 flex justify-between">
                <div class="">
                    <h2 class="text-xl font-semibold text-gray-950">Birim değiştir</h2>
                    <p class="text-sm text-gray-500">
                        Kullanıcının birimini değiştirmek için yeni bir birim seçin.
                    </p>
                </div>
                <div class="">
                    <button class="close-modal" data-modal="birimDegistir">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 pointer-events-none">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </header>

            <form action="" method="POST" id="birimDegistirForm">
                <section>
                    <input type="text" name="kullanici_birim_unvan_iliskileri_id" value=""
                        placeholder="kullanici unvan iliskisi" hidden>
                    <label for="isletme_birimleri_id">Birimler</label>
                    <select name="isletme_birimleri_id" id="isletme_birimleri_id"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                        @foreach ($isletmeBirimleri as $rowBirim)
                            <option value="{{ encrypt($rowBirim->isletme_birimleri_id) }}">{{ $rowBirim->baslik }}
                            </option>
                        @endforeach
                    </select>
                </section>

                <footer class="mt-8 text-right">
                    <button type="submit"
                        class="bg-gray-900 text-white px-3 py-2 rounded hover:bg-gray-950 transition">Birimi
                        değiştir</button>
                </footer>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // let table = new DataTable('#birimler');

        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const BASE_URL = "{{ url('/') }}";

        // let table = new DataTable('#birimler');


        async function fetchData(url, id = "") {

            return await fetch(`${BASE_URL}/${url}${id}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
            });
        }

        $('#birimler').DataTable({
            lengthMenu: [20, 40, 100, {
                'label': 'Hepsi',
                'value': -1
            }],
            ajax: {
                url: '/birimler/getir',
                type: 'POST',
                body: {
                    _token: CSRF_TOKEN
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                dataSrc: 'data',
            },
        });

        document.getElementById('birimDegistirForm')?.addEventListener('submit', async function(event) {
            event.preventDefault();
            const formElement = event.target;
            const formData = new FormData(formElement);

            // FormData'yı düz bir nesneye dönüştürme
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            const RESPONSE = await fetch('birimler/personelBirimDegistir', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify(data)
            });

            const RESPONSE_DATA = await RESPONSE.json();

            if (RESPONSE_DATA.success) {
                $('#birimler').DataTable().ajax.reload(null, false);
                document.querySelector('.close-modal[data-modal="birimDegistir"]').click();
            } else {
                alert('Bir hata oluştu' + RESPONSE_DATA.message);
            }
        });


        async function birimSil(id) {
            const RESPONSE = await fetchData('birimler/sil/', id);
            const RESPONSE_DATA = await RESPONSE.json();

            if (RESPONSE_DATA.success) {
                $('#birimler').DataTable().ajax.reload(null, false);
            } else {
                alert('Bir hata oluştu' + RESPONSE_DATA.message);
            }
        }

        async function birimdenCikart(id) {
            const RESPONSE = await fetchData('yonetim/birimler/kullanici/', id);
            const RESPONSE_DATA = await RESPONSE.json();

            if (RESPONSE_DATA.success) {
                $('#birimler').DataTable().ajax.reload(null, false);
            } else {
                alert('Bir hata oluştu' + RESPONSE_DATA.message);
            }
        }

        $('#birimler').on('draw.dt', function() {
            document.querySelectorAll('[data-popover-target]').forEach(triggerEl => {
                const targetEl = document.getElementById(triggerEl.getAttribute(
                    'data-popover-target'));
                new Popover(targetEl, triggerEl);
            });

        });
    </script>
@endsection
