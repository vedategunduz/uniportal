<li>
    @if ($menu->altMenuler && $menu->altMenuler->count() > 0)
        <button type="button" @class([
            'flex items-center w-full py-1 px-3 rounded-lg transition hover:bg-gray-100 accordion-button',
        ])>
            <span class="p-1 rounded-lg me-2">
                {!! $menu->menuIcon !!}
            </span>
            <span>{{ $menu->menuAd }}</span>

            <svg class="size-2.5 ms-2.5 ml-auto" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" d="m1 1 4 4 4-4" />
            </svg>
        </button>
        <ul class="hidden bg-gray-50 indent-4">
            @foreach ($menu->altMenuler as $altMenu)
                @include('components.menu-item', ['menu' => $altMenu])
            @endforeach
        </ul>
    @else
        <a href="{{ $menu->menuLink }}" @class([
            'flex items-center py-1 px-3 rounded-lg transition',
            'bg-blue-700 text-white hover:text-white' => Request::is(ltrim($menu->menuLink, '/')),
            'hover:bg-gray-100' => !Request::is(ltrim($menu->menuLink, '/')),
        ])>
            <span class="p-1 rounded-lg me-2">
                {!! $menu->menuIcon !!}
            </span>
            <span>{{ $menu->menuAd }}</span>
        </a>
    @endif
</li>
