@props([
    'href' => '#',
    'itemClass' => 'flex items-center px-2 py-1.5 text-sm rounded hover:bg-slate-50',
])

<a href="{{ $href }}" role="menuitem" tabindex="-1" {{ $attributes->merge(['class' => $itemClass]) }}>
    {{ $slot }}
</a>
