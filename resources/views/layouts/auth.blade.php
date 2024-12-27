<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kullanici Paneli')</title>
    @yield('links')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/glocal.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <nav class="fixed top-0 z-40 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-24 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400  dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                    <a href="{{ route('index') }}" class="flex ms-2 md:me-24">
                        <span
                            class="self-center text-blue-600 text-xl font-semibold sm:text-2xl whitespace-nowrap ">uniportal</span>
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                        <div>
                            <button type="button"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Menüyü aç</span>
                                <img class="w-8 h-8 rounded-full"
                                    src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                                    alt="user photo">
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                            id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900 dark:text-white" role="none">
                                    {{ Auth::user()->ad }}
                                </p>
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                    {{ Auth::user()->email }}
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Profil</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Ayarlar</a>
                                </li>
                                <li>
                                    <a href="{{ route('kullanici.cikis') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Çıkış</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-30 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
            <ul class="space-y-2 font-medium capitalize">
                <li>
                    <a href="#"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-50 capitalize">
                        <span>Gösterge Paneli</span>
                    </a>
                </li>
                @foreach ($menuler as $menu)
                    @if ($menu->altMenuler->count())
                        @php
                            $dropdown_id = 'dropdown_' . encrypt($menu->menuler_id);
                        @endphp
                        <li>
                            <button id="dropdown_button_{{ encrypt($menu->menuler_id) }}"
                                data-dropdown-toggle="{{ $dropdown_id }}"
                                class="flex justify-between items-center w-full p-2 text-gray-900 rounded-lg hover:bg-gray-50"
                                type="button">

                                <span>{{ $menu->menu_adi }}</span>

                                <svg class="w-2.5 h-2.5 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                        </li>
                        <div id="{{ $dropdown_id }}"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-md w-44">
                            <ul class="py-2 text-sm text-gray-900" aria-labelledby="dropdownDefaultButton">
                                @foreach ($menu->altMenuler as $altMenu)
                                    <li>
                                        <a href="{{ $altMenu->menu_link }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-900">
                                            <span>{{ $altMenu->menu_adi }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <li>
                            <a href="{{ $menu->menu_link }}"
                                class="flex items-center w-full p-2 text-gray-900 rounded-lg hover:bg-gray-50">
                                <span>{{ $menu->menu_adi }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-50">
                        <span class="flex-1 whitespace-nowrap">Bildirimler</span>
                        <span
                            class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg">3</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <div class="p-4 sm:ml-64">
        <div class="p-4 mt-14">
            @yield('content')
        </div>
    </div>

    @yield('scripts')
</body>

</html>
