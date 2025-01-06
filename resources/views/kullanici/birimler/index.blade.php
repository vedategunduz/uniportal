@php
    use App\Models\KullaniciBirimUnvan;

@endphp

@extends('layouts.auth')

@section('title', 'User dashboard')

@section('content')
    <table id="myTable">
        <thead>
            <tr>
                <th class="w-96">Birim adı</th>
                <th>Personel listesi</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($isletmeBirimleri as $rowBirim)
                <tr>
                    <td>{{ $rowBirim->baslik }}</td>
                    <td>
                        @php
                            $birimPersonelleri = KullaniciBirimUnvan::with('kullanici', 'unvan')
                                ->where('isletme_birimleri_id', $rowBirim->isletme_birimleri_id)
                                ->get()
                                ->sortBy(function ($item) {
                                    return $item->unvan->unvanSira;
                                });
                        @endphp
                        <div class="flex -space-x-2">
                            @foreach ($birimPersonelleri as $rowPersonel)
                                <img src="{{ $rowPersonel->kullanici->profilFotoUrl }}" class="rounded-full size-8 shadow"
                                    alt=""
                                    data-popover-target="popover-default_{{ $rowPersonel->kullanici_birim_unvan_iliskileri_id }}">

                                <div data-popover
                                    id="popover-default_{{ $rowPersonel->kullanici_birim_unvan_iliskileri_id }}"
                                    role="tooltip"
                                    class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                                    <div class="p-3">
                                        <div class="text-sm font-semibold leading-none text-gray-900 dark:text-white mb-3">
                                            {{ $rowBirim->baslik }}
                                        </div>
                                        <div class="flex items-center justify-between mb-2">
                                            <a href="#">
                                                <img class="w-10 h-10 rounded-full"
                                                    src="{{ $rowPersonel->kullanici->profilFotoUrl }}" alt="Jese Leos">
                                            </a>
                                            <div>
                                                <button type="button"
                                                    class="text-white bg-rose-700 hover:bg-rose-800 focus:ring-4 focus:ring-rose-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-rose-600 dark:hover:bg-rose-700 focus:outline-none dark:focus:ring-rose-800">Birimden
                                                    çıkart</button>
                                            </div>
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
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>
                            @endforeach
                        </div>

                    </td>
                    <td>Düzelt</td>
                    <td>Sil</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
