<header class="sticky top-0 z-10 bg-white">
    <nav class="py-2 px-4 flex items-center justify-between shadow">
        <div class="flex">
            <button type="button" class="text-gray-600 focus:outline-none p-1 me-4 lg:hidden burger-menu"
                aria-label="Toggle menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-list size-5" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                </svg>
            </button>
            <a href="{{ route('main.index') }}" class="flex items-center space-x-3">
                <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
                <span class="text-2xl font-semibold whitespace-nowrap">uniportal</span>
            </a>
        </div>
        <div class="flex items-center gap-2">
            <livewire:open-message-panel-button-component />

            <div class="">
                <x-button id="" data-dropdown-toggle="bildirimNavbar" class="!shadow-none !border-0">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-bell-fill size-5" viewBox="0 0 16 16">
                            <path
                                d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901" />
                        </svg>
                        <span
                            class="absolute -top-1 -right-0.5 scale-90 size-4 inline-flex items-center justify-center text-white bg-blue-700 rounded-full">
                            {{ $bildirimler['birimeYerlesmemisPersonelSayisi'] }}
                        </span>
                    </div>
                </x-button>
                <!-- Dropdown menu -->
                <div id="bildirimNavbar"
                    class="z-20 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                    <div class="">

                    </div>
                    {{-- <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                        <li>
                            <a href="{{ route('yonetim.index') }}" class="block px-4 py-2 hover:bg-gray-100">Panel</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100">Profil</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100">Ayarlar</a>
                        </li>
                    </ul> --}}
                    <div class="py-1">
                        <a href="{{ route('auth.cikis') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Çıkış</a>
                    </div>
                </div>
            </div>

            <div class="">
                <button id="" data-dropdown-toggle="dropdownNavbar"
                    class="flex items-center justify-between text-gray-900 rounded-lg hover:bg-gray-50">
                    <img src="{{ asset(Auth::user()->profilFotoUrl) }}" class="size-12 rounded-full" alt="">
                </button>
                <!-- Dropdown menu -->
                <div id="dropdownNavbar"
                    class="z-20 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                        <li>
                            <a href="{{ route('yonetim.index') }}" class="block px-4 py-2 hover:bg-gray-100">Panel</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100">Profil</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100">Ayarlar</a>
                        </li>
                    </ul>
                    <div class="py-1">
                        <a href="{{ route('auth.cikis') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Çıkış</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
