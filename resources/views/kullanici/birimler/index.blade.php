@php
    use App\Models\KullaniciBirimUnvan;
    use App\Models\IsletmeBirim;
@endphp

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
    <table class="jquery-dt" id="birimler" name="birimler" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <th class="w-96">Birim adı</th>
                <th data-dt-order="disable">Personel listesi</th>
                <th class="w-4" data-dt-order="disable"></th>
                <th class="w-4 " data-dt-order="disable"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($isletmeBirimleri as $rowBirim)
                <tr data-row-id="{{ $rowBirim->isletme_birimleri_id }}">
                    <td>{{ $rowBirim->baslik }}</td>
                    <td>
                        @php
                            $birimPersonelleri = (new IsletmeBirim())->isletmeBirimPersonelBul(
                                $rowBirim->isletme_birimleri_id,
                            );
                        @endphp
                        <div class="flex sm:24 lg:w-96 flex-wrap">
                            @foreach ($birimPersonelleri as $rowPersonel)
                                @php
                                    $sifreli_kullanici_birim_unvan_iliskileri_id = encrypt($rowPersonel->kullanici_birim_unvan_iliskileri_id);
                                @endphp
                                <img data-person-id="{{ $sifreli_kullanici_birim_unvan_iliskileri_id }}" src="{{ $rowPersonel->kullanici->profilFotoUrl }}" class="rounded-full size-10 shadow"
                                    alt=""
                                    data-popover-target="popover-default_{{ $sifreli_kullanici_birim_unvan_iliskileri_id }}">

                                <div data-popover
                                    id="popover-default_{{ $sifreli_kullanici_birim_unvan_iliskileri_id }}"
                                    role="tooltip"
                                    class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                                    <div class="p-3">
                                        <div class="text-sm font-semibold leading-none text-gray-900 dark:text-white mb-3">
                                            {{ $rowBirim->baslik }}
                                        </div>
                                        <div class="flex items-center justify-between mb-2">
                                            <a href="#">
                                                <img class="size-14 rounded-full"
                                                    src="{{ $rowPersonel->kullanici->profilFotoUrl }}" alt="Jese Leos">
                                            </a>
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="checkbox" value="" class="sr-only peer">
                                                <div
                                                    class="relative w-7 h-4 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-blue-600">
                                                </div>
                                                <span
                                                    class="ms-3 text-sm font-medium text-gray-900 select-none">Yetkili</span>
                                            </label>
                                        </div>
                                        <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">
                                            <a
                                                href="#">{{ $rowPersonel->kullanici->ad . ' ' . $rowPersonel->kullanici->soyad }}</a>
                                        </p>
                                        <p class="mb-3 text-sm font-normal">
                                            <a href="#"
                                                class="hover:underline">{{ $rowPersonel->kullanici->email }}</a>
                                        </p>
                                        <p class="text-sm text-blue-600">
                                            {{ $rowPersonel->unvan->baslik }}
                                        </p>
                                        <div class="border-t my-2"></div>
                                        <div>
                                            <button type="button"
                                                onclick="birimdenCikart('{{ encrypt($rowPersonel->kullanici_birim_unvan_iliskileri_id) }}')"
                                                data-id="{{ encrypt($rowPersonel->kullanici_birim_unvan_iliskileri_id) }}"
                                                class="text-white bg-rose-700 hover:bg-rose-800 focus:ring-2 focus:ring-rose-300 font-medium rounded-lg text-xs px-2 py-1">Birimden
                                                çıkart</button>
                                            <button type="button" data-modal="birimDegistir"
                                                data-id="{{ encrypt($rowPersonel->kullanici_birim_unvan_iliskileri_id) }}"
                                                class="birimDegistir open-modal text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-2 focus:ring-yellow-400 font-medium rounded-lg text-xs px-2 py-1">Birim
                                                değiştir</button>

                                        </div>
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>
                            @endforeach
                        </div>

                    </td>
                    <td>
                        <button type="button" data-sebze="patates" class="alertGoster bg-yellow-400 p-2 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3" fill="white" viewBox="0 0 512 512">
                                <path
                                    d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z" />
                            </svg>
                        </button>
                    </td>
                    <td>
                        <button type="button" onclick="birimSil({{ $rowBirim->isletme_birimleri_id }})"
                            class="bg-rose-500 text-white p-2 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <section class="modal hidden items-center justify-center" id="birimDetay">
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
        let table = new DataTable('#birimler');

        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        async function fetchData(url, id) {
            const BASE_URL = window.App.baseUrl;

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

        async function birimSil(id) {
            const RESPONSE = await fetchData('birimler/sil/', id);
            const RESPONSE_DATA = await RESPONSE.json();

            if (RESPONSE_DATA.success) {
                table.row($(`tr[data-row-id='${id}']`))
                    .remove()
                    .draw();
            } else {
                alert('Bir hata oluştu' + RESPONSE_DATA.message);
            }
        }

        async function birimdenCikart(id) {
            const RESPONSE = await fetchData('kullanici/birimler/kullanici/', id);
            const RESPONSE_DATA = await RESPONSE.json();

            if (RESPONSE_DATA.success) {
                document.querySelector(`img[data-person-id='${id}']`).remove();
            } else {
                alert('Bir hata oluştu' + RESPONSE_DATA.message);
            }
        }

        table.on('draw.dt', function() {
            document.querySelectorAll('[data-popover-target]').forEach(triggerEl => {
                const targetEl = document.getElementById(triggerEl.getAttribute('data-popover-target'));
                new Popover(targetEl, triggerEl);
            });
        });
    </script>
@endsection
