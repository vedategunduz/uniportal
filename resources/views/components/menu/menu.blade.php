<aside class="sticky z-10 w-full lg:w-80 collapsible-menu" style="top:56px">
    <nav class="flex flex-col p-4 text-sm" id="aside-nav">
        <div class="gradient-aside rounded p-2">
            @foreach ($menuler as $menu)
                @if ($menu->children->count() > 0)
                    <button type="button"
                        class="aside-accordion flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                        {!! $menu->menuIcon !!}

                        <span class="ml-4 text-nowrap pointer-events-none">{{ $menu->menuAd }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-4 ml-auto arrow duration-300 pointer-events-none">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <ul class="pl-11 max-h-0 overflow-hidden duration-300 accordion-content border-r-2 border-emerald-500">
                        @foreach ($menu->children as $submenu)
                            <li>
                                @if ($submenu->children->count() > 0)
                                    <button type="button"
                                        class="aside-accordion flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                                        <span class="text-nowrap pointer-events-none">{{ $submenu->menuAd }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="size-4 ml-auto arrow duration-300 pointer-events-none">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                    <ul class="pl-3 max-h-0 overflow-hidden duration-300 accordion-content">
                                        @foreach ($submenu->children as $subsubmenu)
                                            <li>
                                                <a href="{{ $subsubmenu->menuLink }}"
                                                    class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                                                    <span
                                                        class="text-nowrap pointer-events-none">{{ $subsubmenu->menuAd }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <a href="{{ $submenu->menuLink }}"
                                        class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                                        <span class="text-nowrap pointer-events-none">{{ $submenu->menuAd }}</span>
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <a href="{{ $menu->menuLink }}"
                        class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                        {!! $menu->menuIcon !!}
                        <span class="ml-4 text-nowrap menu-text">{{ $menu->menuAd }}</span>
                    </a>
                @endif
            @endforeach
        </div>
    </nav>
</aside>
{{--

        <button type="button"
            class="aside-accordion flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                class="bi bi-calendar2-event-fill size-4 pointer-events-none" viewBox="0 0 16 16">
                <path
                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5m9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5M11.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z" />
            </svg>
            <span class="ml-4 text-nowrap pointer-events-none">Kurum işlemleri</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-4 ml-auto arrow duration-300 pointer-events-none">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>
        </button>
        <ul class="pl-11 max-h-0 overflow-hidden duration-300 accordion-content">
            <li>
                <a href="" class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                    <span class="text-nowrap pointer-events-none">Etkinlikler</span>
                </a>
            </li>
            <li>
                <a href="" class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                    <span class="text-nowrap pointer-events-none">Ortak alım talepleri</span>
                </a>
            </li>
            <li>
                <a href="" class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                    <span class="text-nowrap pointer-events-none">Sarf istek fazla</span>
                </a>
            </li>
            <li>
                <a href="" class="flex items-center w-full px-3 h-8 rounded text-white hover:opacity-100">
                    <span class="text-nowrap pointer-events-none">Sponsor talepleri</span>
                </a>
            </li>
        </ul>

--}}
