@extends('layouts.auth')

@section('title', 'User dashboard')

@section('content')
    <div class="p-2 bg-blue-700 text-white mb-8 flex space-x-2 items-center justify-between rounded">
        <h4>Kullanıcı yönetimi</h4>
        <div class="flex item-center">
            <select name="isletmeler_id" id="isletmeChange"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-72 px-2.5 py-1">
                @foreach ($isletmeler as $rowIsletme)
                    <option value="{{ encrypt($rowIsletme->isletmeler_id) }}">{{ $rowIsletme->baslik }}</option>
                @endforeach
            </select>
            <button type="button"
                class="bg-emerald-500 text-sm pl-2 py-1.5 pr-4 rounded flex items-center text-white ms-2 open-modal birimDuzenle"
                data-modal="birimDetay" data-id="{{ encrypt(0) }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="pointer-events-none">
                    Davet gönder
                </span>
                <a href=""></a>
            </button>
        </div>
    </div>

    <table id="kullanicilar" class="display nowrap stripe">
        <thead>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th data-dt-order="disable"></th>
                <th data-dt-order="disable"></th>
            </tr>
        </thead>
        <tbody id="table-body"></tbody>
    </table>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const isletmeSelectElement = document.getElementById('isletmeChange');
            const dataTableName = '#kullanicilar';

            // Sayfa yüklendiğinde mevcut değeri al ve tabloyu oluştur
            let isletmeler_id = isletmeSelectElement.value;
            getDataTableDatas(dataTableName, `api/kullanicilar/show/${isletmeler_id}`);

            // Değer değiştiğinde tabloyu güncelle
            isletmeSelectElement.addEventListener('change', () => {
                // Yeni değeri al
                isletmeler_id = isletmeSelectElement.value;

                // Önceki DataTable'ı yok et ve yenisini oluştur
                $(dataTableName).DataTable().destroy();
                getDataTableDatas(dataTableName, `api/kullanicilar/show/${isletmeler_id}`);
            });
        });
    </script>
@endsection
