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
            <a href="{{ route('main.index') }}" class="flex items-center space-x-3 text-2xl font-semibold">
                <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo"
                    loading="lazy" />
                <span>{{ config('app.name') }}</span>
            </a>
        </div>
        <div class="flex items-center gap-2">
            <livewire:open-message-panel-button-component />

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
