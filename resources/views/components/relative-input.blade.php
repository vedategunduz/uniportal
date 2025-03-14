@props([
    'disabled' => false,
    'label' => 'Label',
    'id' => uniqid(),
])

<div class="relative">
    <x-text-input id="{{ $id }}" :disabled="$disabled" {{ $attributes->merge([ 'class' => 'peer bg-white' ])}} placeholder=" "/>

    {{-- <input @disabled($disabled)
        id="{{ $id }}"
        {{ $attributes->merge([
            'class' =>
                'block p-2.5 w-full text-sm text-gray-900 bg-transparent rounded border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer'
        ]) }} /> --}}
    <label for="{{ $id }}"
        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-[5] origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
        {{ $label }}
    </label>
</div>
