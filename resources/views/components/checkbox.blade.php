@props([
    'name' => 'name',
    'id' => uniqid(),
    'checked' => false,
    'disabled' => false,
])

<div class="">
    <input type="checkbox" @disabled($disabled == 'true') @checked($checked == 'true') name="{{ $name }}"
        id="{{ $id }}"
        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">

    <label for="{{ $id }}" class="text-sm ms-2 font-medium text-gray-900 inline-flex flex-col">
        {{ $slot }}
    </label>
</div>
