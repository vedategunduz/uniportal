@extends('layouts.auth')

@section('title', 'Kampanya Yönetimi')
@section('links')

@endsection

@section('content')
    <div class="flex justify-between items-center bg-blue-700 text-gray-50 mb-8 p-2 rounded">
        <h4>Kampanya Yönetimi</h4>
        <div class="flex items-center gap-4">
            <select name="isletmeler_id" @class(['w-full border border-gray-300 text-gray-700 rounded py-1.5'])>
                @if (auth()->user()->isletmeler->count() > 1)
                    <option value="">İşletme seçiniz</option>
                @endif
                @foreach (auth()->user()->isletmeler as $detay)
                    <option value="{{ encrypt($detay->isletme->isletmeler_id) }}">{{ $detay->isletme->baslik }}</option>
                @endforeach
            </select>

            <a href="{{ route('yonetim.kampanyalar.create') }}"
                class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded font-semibold text-xs !text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:text-gray-500 disabled:hover:!bg-inherit transition ease-in-out duration-150">Ekle</a>
        </div>
    </div>

    <h4>Kampanya Index</h4>

    <p>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est asperiores debitis id doloremque, nemo quos
        consequuntur ipsa unde dolore ducimus temporibus nobis voluptates iusto ab ad ipsum maiores. Est, culpa.
    </p>
@endsection

@section('scripts')
@endsection
