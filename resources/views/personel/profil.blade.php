@extends('layouts.auth')

@section('title', 'User dashboard')

@section('content')
    <div class="max-w-screen-xl mx-auto grid grid-cols-2 border rounded">
        <div class="border-r p-4">
            <section class="grid grid-cols-2">
                <div class="space-y-4 flex flex-col items-center text-center">
                    <img src="{{ asset($kullanici->profilFotoUrl) }}" class="size-48 rounded-full object-cover mx-auto"
                        alt="">
                    <header>
                        <h4>{{ $kullanici->ad . ' ' . $kullanici->soyad }}</h4>
                        <p>{{ $birimDetaylari[0]->unvan->baslik }}</p>
                    </header>
                    <div class="">
                        @if ($kullanici->aramaIzni || in_array(Auth::user()->roller_id, [1, 2]))
                            <a href="mailto:{{ $kullanici->email }}"> {{ $kullanici->email }}</a>
                            <br>
                            <a href="tel:{{ $kullanici->telefon }}"> {{ $kullanici->telefon }}</a>
                        @endif
                    </div>
                    <footer class="flex gap-2">
                        <button type="button"
                            class="flex items-center bg-blue-500 text-white p-1.5 px-4 text-sm rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-chat-left-fill size-4"
                                viewBox="0 0 16 16">
                                <path
                                    d="M2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                            </svg>
                            <span class="ms-2 font-medium">
                                Mesaj
                            </span>
                        </button>
                        <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
                            class="flex items-center justify-between py-2 px-3 text-gray-900 rounded-lg hover:bg-gray-50">
                            Daha fazla
                        </button>
                        <!-- Dropdown menu -->
                        <div id="dropdownNavbar"
                            class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                                <li>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Daha fazla 1</a>
                                </li>
                                <li>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Daha fazla 2</a>
                                </li>
                            </ul>
                            <div class="py-1">
                                <a href="{{ route('cikis') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Çıkış</a>
                            </div>
                        </div>
                    </footer>
                </div>
                <div class="relative pt-28">
                    <div class="flex items-center justify-between gap-4 absolute top-0 right-0 w-full">
                        <a href="#"
                            class="text-blue-700 font-medium text-wrap text-center hover:text-blue-700">{{ $isletme->baslik }}</a>
                        <img src="{{ asset($isletme->logoUrl) }}" class="size-24 rounded-full" alt="">
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($birimDetaylari as $rowBirimDetaylari)
                            <span class="border py-1 px-1.5 rounded text-sm">{{ $rowBirimDetaylari->birim->baslik }}</span>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>

        <section class="mt-4 p-4">

            <h5 class="border-b mb-2">Kullanıcı izinleri</h5>

            <div class="mb-2">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" value="" disabled class="sr-only peer"
                        @if ($kullanici->aramaIzni) checked @endif>
                    <span class="me-3 text-sm font-medium text-gray-900">İletişim izni</span>
                    <div
                        class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2.5px] after:start-[4px] after:bg-white after:border-gray-200 after:border after:rounded-full after:h-3.5 after:w-3.5 after:transition-all peer-checked:bg-blue-300">
                    </div>
                </label>
                <p class="text-sm text-gray-500">
                    @if ($kullanici->aramaIzni)
                        Kullanıcıya e-posta ve telefon üzerinden ulaşılabilir.
                    @else
                        Kullanıcıya e-posta ve telefon üzerinden ulaşılamaz.
                    @endif
                </p>
            </div>
            <div class="mb-4">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" value="" class="sr-only peer" disabled
                        @if ($kullanici->veriGosterimIzni) checked @endif>
                    <span class="me-3 text-sm font-medium text-gray-900">Profil gösterim izni</span>
                    <div
                        class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2.5px] after:start-[4px] after:bg-white after:border-gray-200 after:border after:rounded-full after:h-3.5 after:w-3.5 after:transition-all peer-checked:bg-blue-300">
                    </div>
                </label>
                <p class="text-sm text-gray-500">
                    @if ($kullanici->veriGosterimIzni)
                        Kullanıcının profil bilgileri diğer kullanıcılar tarafından görüntülenebilir.
                    @else
                        Kullanıcının profil bilgileri diğer kullanıcılar tarafından görüntülenemez.
                    @endif
                </p>
            </div>

            <div class="relative overflow-x-auto border-t mt-4">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr>
                            <th scope="col" class="py-2">
                                Giriş tarihi
                            </th>
                            <th scope="col" class="py-2">
                                IP
                            </th>
                            <th scope="col" class="py-2">
                                Durum
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sonGirisler as $rowSonGirisler)
                            <tr>
                                <td class="py-2">{{ $rowSonGirisler->login_at }}</td>
                                <td class="py-2">{{ $rowSonGirisler->ip_address }}</td>
                                <td class="py-2">
                                    <span @class([
                                        'border py-1 px-2.5 rounded',
                                        'text-emerald-500 bg-emerald-100 border-emerald-300' =>
                                            $rowSonGirisler->successful,
                                        'text-rose-500 bg-rose-100 border-rose-300' => !$rowSonGirisler->successful,
                                    ])>
                                        @if ($rowSonGirisler->successful)
                                            Başarılı
                                        @else
                                            Başarısız
                                        @endif
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
