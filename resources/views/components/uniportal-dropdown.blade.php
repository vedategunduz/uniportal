@props([
    'id' => 'dropdown-' . uniqid(),
    'triggerText' => 'Dropdown Button',
    'dropdownClass' => 'w-44',
    'alignment' => 'left',
    'closeOnItemClick' => true,
])

<div class="relative inline-block" data-uniportal-dropdown>
    <x-button data-uniportal-dropdown-trigger="{{ $id }}"
        data-uniportal-dropdown-alignment="{{ $alignment }}" aria-haspopup="true" aria-expanded="false"
        {{ $attributes->merge(['class' => '']) }}>
        {{ $trigger ?? $triggerText }}
    </x-button>

    <div id="{{ $id }}" class="hidden bg-white shadow-md p-2 absolute z-20 rounded {{ $dropdownClass }}"
        data-uniportal-dropdown-close-on-item-click="{{ $closeOnItemClick }}" role="menu" aria-hidden="true"
        data-uniportal-dropdown-target>
        {{ $target ?? '' }}
    </div>
</div>

{{--
<x-uniportal-dropdown class="!shadow-none !border-none !p-1" alignment="right">
    <x-slot name="trigger">
        <i class="bi bi-three-dots-vertical"></i>
    </x-slot>

    <x-slot name="target">
        <x-uniportal-dropdown-item href="#">Şikayet et</x-uniportal-dropdown-item>
    </x-slot>
</x-uniportal-dropdown>
 --}}
{{--
 <x-uniportal-dropdown class="!shadow-none !border-none !p-1" alignment="right">
    <x-slot name="trigger">
        <i class="bi bi-three-dots-vertical"></i>
    </x-slot>

    <x-slot name="target">
        <x-uniportal-dropdown-item href="#">
            <i class="bi bi-calendar-range-fill text-base text-green-400"></i>
            <span class="ms-2">Takivime ekle</span>
        </x-uniportal-dropdown-item>
        <x-uniportal-dropdown-item href="javascript:void(0)" class="etkinlik-şikayet-et"
            data-id="{{ encrypt($etkinlik->etkinlikler_id) }}">
            <i class="bi bi-exclamation-diamond-fill text-base text-rose-500"></i>
            <span class="ms-2">Şikayet et</span>
        </x-uniportal-dropdown-item>
    </x-slot>
</x-uniportal-dropdown>
--}}
