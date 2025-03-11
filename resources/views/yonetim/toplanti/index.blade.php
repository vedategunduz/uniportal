@extends('layouts.auth')

@section('title', 'User dashboard')

@section('links')
    <style>
        .dt-length select.input-sm {
            line-height: 15px !important;
            color: #000;
        }

        div.dt-container div.dt-layout-row {
            margin: 0 0 1rem !important;
        }

        table#kampanyalar th,
        table#kampanyalar td {
            white-space: nowrap;
        }

        div.dt-container div.dt-search input {
            border: 1px solid #ccc;
            border-radius: 0.375rem;
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            color: #4a5568;
            background-color: #fff;
            background-clip: padding-box;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        div.dt-container div.dt-layout-row div.dt-layout-cell {
            padding: 0 !important;
        }
    </style>
@endsection

@section('content')
    <div class="flex flex-wrap items-center px-4">
        <h1 class="me-4">Ziyaret Yönetimi</h1>

        <select name="isletmeler_id" @class([
            'border border-gray-300 text-gray-700 rounded py-1.5 ml-auto w-full lg:w-auto',
            'hidden' => auth()->user()->isletmeler->count() == 1,
        ])>
            @foreach (auth()->user()->isletmeler as $detay)
                <option value="{{ encrypt($detay->isletme->isletmeler_id) }}">{{ $detay->isletme->baslik }}</option>
            @endforeach
        </select>

        <x-button class="ziyaret-ekle-modal !bg-green-400 text-white border-none gap-2 w-full lg:w-auto justify-center">
            <i class="bi bi-plus-lg"></i>
            <span>Ziyaret Ekle</span>
        </x-button>

        <p class="border-b w-full mt-0"></p>
    </div>

    <div class="overflow-x-auto px-4 w-full">
        <table id="ziyaretler" class="table table-striped table-bordered table-hover max-w-full">
            <thead>
                <tr>
                    <th class="text-nowrap">Ziyaret Edilen Kurum</th>
                    <th class="text-nowrap">Ziyaret Başlık</th>
                    <th class="text-nowrap">Tarih</th>
                    <th class="text-nowrap">Ziyaret Eden Kişiler</th>
                    <th class="text-nowrap">Ziyaret Edilen Kişiler</th>
                    <th class="text-nowrap">Sohbetler</th>
                    <th data-dt-order="disable">#</th>
                    <th data-dt-order="disable">#</th>
                </tr>
            </thead>
            <tbody id="table-body"></tbody>
        </table>
    </div>

    <x-modal id="etkinlik-modal" title="Ziyaret işlemleri" class="w-full sm:w-4/5 overflow-y-auto">
        <div class="h-96 flex items-center justify-center">
            <div class="size-12 border-4 border-t-transparent border-gray-300 rounded-full wheel"></div>
        </div>
    </x-modal>

    <x-modal id="katilimci-listesi-modal" title="" headerClass="bg-transparent !text-gray-900"
        class="w-full max-w-md overflow-y-auto">
        <div class="h-96 flex items-center justify-center">
            <div class="size-12 border-4 border-t-transparent border-gray-300 rounded-full wheel"></div>
        </div>
    </x-modal>

    <x-modal id="confirm-modal" title="" headerClass="!bg-transparent !text-gray-900" headerCloseButton="false">
        <div class="space-y-8 pt-4">
            <div class="text-center space-y-2">
                <i class="bi bi-exclamation-circle-fill text-6xl text-gs-red"></i>

                <p class="text-sm text-gray-700 w-52 mx-auto">
                    İlgili ziyaret silenecektir. Etkinliği silmek istediğinize emin misiniz?
                </p>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <x-button class="justify-center close-modal canceled" data-modal="confirm-modal">İptal</x-button>
                <x-button class="!bg-gs-red text-white !border-0 justify-center confirmed">Onayla</x-button>
            </div>
        </div>
    </x-modal>
@endsection

@section('scripts')
    <script>
        function confirmModal() {
            return new Promise((resolve, reject) => {
                const MODAL = document.getElementById('confirm-modal');
                MODAL.querySelector('.confirmed').addEventListener('click', () => {
                    resolve(true);
                    UniportalService.modal.hide('confirm-modal');
                });
                MODAL.querySelector('.canceled').addEventListener('click', () => resolve(false));
                UniportalService.modal.show('confirm-modal');
            });
        }

        const MODAL = document.getElementById('etkinlik-modal');

        document.addEventListener('DOMContentLoaded', async () => {
            const isletme_select = document.querySelector('select[name="isletmeler_id"]');
            const URL =
                `{{ route('yonetim.toplantilar.ziyaretler.dataTable', ['isletme_id' => '___ID___']) }}`;

            if (isletme_select.value) {
                datatable_verileri_getir('ziyaretler', URL.replace('___ID___', isletme_select
                    .value));
            }

            isletme_select.addEventListener('change', function() {
                if (this.value) {
                    datatable_verileri_getir('ziyaretler', URL.replace('___ID___',
                        isletme_select
                        .value));
                }
            });

            document.addEventListener('click', function(event) {
                event.target.closest('.ziyaret-duzenle-modal') && (async () => {
                    const ID = event.target.closest('.ziyaret-duzenle-modal').dataset.id;
                    const URL =
                        `{{ route('yonetim.toplantilar.ziyaretler.edit', ['etkinlik_id' => '___ID___']) }}`
                        .replace('___ID___', ID);

                    const RESPONSE = await ApiService.fetchData(URL, {}, 'GET');

                    if (RESPONSE.data.success) {
                        initSummernote('aciklama', 300);
                        UniportalService.modal.show('etkinlik-modal');
                        MODAL.querySelector('[data-slot]').innerHTML = RESPONSE.data.html;

                    } else
                        ApiService.alert.error('Bir hata oluştu. Lütfen tekrar deneyiniz.');
                })();

                event.target.closest('.ziyaret-ekle-modal') && (async () => {
                    const URL = `{{ route('yonetim.toplantilar.ziyaretler.create') }}`;
                    const RESPONSE = await ApiService.fetchData(URL, {}, 'GET');

                    if (RESPONSE.data.success) {
                        UniportalService.modal.show('etkinlik-modal');
                        MODAL.querySelector('[data-slot]').innerHTML = RESPONSE.data.html;
                        initSummernote('aciklama', 300);

                    } else
                        ApiService.alert.error('Bir hata oluştu. Lütfen tekrar deneyiniz.');
                })();

                event.target.closest('.ziyaret-submit-button') && (async () => {
                    event.preventDefault();
                    const FORM = event.target.closest('.ziyaret-submit-button').closest(
                        'form');
                    const URL = FORM.action;
                    const DATA = new FormData(FORM);

                    const RESPONSE = await ApiService.fetchData(URL, DATA, 'POST');

                    if (RESPONSE.data.success) {
                        ApiService.alert.success(RESPONSE.data.message);
                        UniportalService.modal.hide('etkinlik-modal');
                        $('#ziyaretler').DataTable().ajax.reload(null, false);
                    } else
                        ApiService.alert.error(RESPONSE.data.message);
                })();

                event.target.closest('.ziyaret-sil') && (async () => {
                    if (!await confirmModal()) return;
                    const ID = event.target.closest('.ziyaret-sil').dataset.id;
                    const URL =
                        `{{ route('yonetim.toplantilar.ziyaretler.destroy', ['etkinlik_id' => '___ID___']) }}`
                        .replace('___ID___', ID);

                    const RESPONSE = await ApiService.fetchData(URL, {}, 'DELETE');

                    if (RESPONSE.data.success) {
                        ApiService.alert.success(RESPONSE.data.message);
                        $('#ziyaretler').DataTable().ajax.reload(null, false);
                    } else
                        ApiService.alert.error(RESPONSE.data.message);
                })();

                event.target.closest('.close-modal') && function() {
                    if (event.target.closest('.close-modal').closest('#imageCropModal'))
                        return

                    MODAL.querySelector('[data-slot]').innerHTML =
                        `<div class="h-96 flex items-center justify-center"><div class="size-12 border-4 border-t-transparent border-gray-300 rounded-full wheel"></div></div>`;
                }();

                event.target.closest('.ziyaret-sohbet-baslat') && (() => {
                    const button = event.target.closest('.ziyaret-sohbet-baslat');
                    const ID = button.dataset.id;
                    const name = button.dataset.name;

                    document.querySelector('.open-aside-modal').click();
                    document.querySelector('.searchNotSifirla ').click();
                    document.querySelector('#modal-yeni-kanal').querySelector(
                            'input[name="baslik"]').value =
                        name;
                    document.getElementById('search-channel').value = name;

                    document.querySelector('#modal-yeni-kanal').querySelector(
                            'input[name="etkinlikler_id"]')
                        .value = ID;
                    searchChannel(name);
                })();

                event.target.closest('.ziyaret-kanallar') && (() => {
                    const button = event.target.closest('.ziyaret-kanallar');
                    const name = button.dataset.name;

                    document.querySelector('.open-aside-modal').click();
                    document.querySelector('#modal-yeni-kanal').querySelector(
                            'input[name="baslik"]').value =
                        name;
                    document.getElementById('search-channel').value = name;
                    searchChannel(name);
                })();

                event.target.closest('.katilimci-listesi') && (async () => {
                    const ID = event.target.closest('.katilimci-listesi').dataset.id;
                    const TYPE = event.target.closest('.katilimci-listesi').dataset.type;
                    const URL =
                        `{{ route('yonetim.toplantilar.ziyaretler.katilimciListesi', ['etkinlik_id' => '___ID___', 'type' => '___TYPE___']) }}`
                        .replace('___ID___', ID).replace('___TYPE___', TYPE);

                    const RESPONSE = await ApiService.fetchData(URL, {}, 'GET');

                    if (RESPONSE.data.success) {
                        document.getElementById('katilimci-listesi-modal').querySelector(
                            '[data-slot]').innerHTML = RESPONSE.data.html;
                    } else
                        ApiService.alert.error('Bir hata oluştu. Lütfen tekrar deneyiniz.');
                })();

                if (!event.target.closest('#kendiKurumPersonelListesi')) {
                    document.getElementById('kendiKurumPersonelListesi')?.classList.add('!hidden');
                }
                if (!event.target.closest('#ziyaretEdilenKurumPersonelListesi')) {
                    document.getElementById('ziyaretEdilenKurumPersonelListesi')?.classList.add(
                        '!hidden');
                }

                event.target.closest('[name=kendi_kurum_personeli_ara]') && (() => {
                    if (document.querySelector('[name=kendi_kurum_personeli_ara]').value
                        .length < 3) {
                        return;
                    }

                    document.getElementById('kendiKurumPersonelListesi').classList
                        .remove('!hidden');
                })();

                event.target.closest('[name=ziyaret_edilen_kurum_personeli_ara]') && (() => {
                    if (document.querySelector('[name=ziyaret_edilen_kurum_personeli_ara]')
                        .value
                        .length < 3) {
                        return;
                    }

                    document.getElementById('ziyaretEdilenKurumPersonelListesi').classList
                        .remove('!hidden');
                })();
            });

            document.addEventListener('input', function(event) {
                event.target.closest('[name=kendi_kurum_personeli_ara]') && (async () => {
                    const giden_isletme_id = document.querySelector(
                        'select[name=giden_isletme_id]').value;
                    const q = document.querySelector('[name=kendi_kurum_personeli_ara]')
                        .value;

                    const resultContainer = document.getElementById(
                        'kendiKurumPersonelListesi');

                    await search(giden_isletme_id, q, [], resultContainer);
                })();

                event.target.closest('[name=ziyaret_edilen_kurum_personeli_ara]') && (async () => {
                    const giden_isletme_id = document.querySelector(
                        'select[name=gidilen_isletme_id]').value;
                    const q = document.querySelector(
                            '[name=ziyaret_edilen_kurum_personeli_ara]')
                        .value;

                    const resultContainer = document.getElementById(
                        'ziyaretEdilenKurumPersonelListesi');

                    await search(giden_isletme_id, q, [], resultContainer);
                })();
            });

            async function search(isletme_id, q, qNot = [], resultContainer) {
                if (q.length < 3) {
                    resultContainer.classList.add('!hidden');
                    resultContainer.innerHTML = '';
                    return;
                }

                const url =
                    `{{ route('yonetim.toplantilar.ziyaretler.search', ['isletme_id' => '___ID___', 'q' => '___q___']) }}`
                    .replace('___ID___', isletme_id)
                    .replace('___q___', q);

                const RESPONSE = await ApiService.fetchData(url, {}, 'GET');

                if (RESPONSE.data.success) {
                    resultContainer.classList.remove('!hidden');
                    resultContainer.innerHTML = RESPONSE.data.html;
                } else
                    ApiService.alert.error('Bir hata oluştu. Lütfen tekrar deneyiniz.');
            }
        });
    </script>
@endsection
