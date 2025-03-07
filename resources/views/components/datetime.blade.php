@props([
    'id' => uniqid(),
    'label' => 'Zaman',
])

<div class="relative">
    <label for="{{ $id }}"
        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-[5] origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
        {{ $label }}
    </label>
    <input type="datetime-local" id="{{ $id }}"
        {{ $attributes->merge([
            'class' =>
                'peer bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 w-full block p-2.5',
        ]) }} />
</div>
