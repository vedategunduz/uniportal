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
                    <th>Ziyaret Edilen Kurum</th>
                    <th>Ziyaret Başlık</th>
                    <th>Tarih</th>
                    <th>Ziyaret Eden Kişiler</th>
                    <th>Ziyaret Edilen Kişiler</th>
                    <th data-dt-order="disable">#</th>
                    <th data-dt-order="disable">#</th>
                </tr>
            </thead>
            <tbody id="table-body"></tbody>
        </table>
    </div>

    <x-modal id="etkinlik-modal" title="" class="w-full sm:w-4/5 overflow-y-auto">
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
                        initCropper();
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
                        initCropper();
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
            });
        });
    </script>
@endsection
