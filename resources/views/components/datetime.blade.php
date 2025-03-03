@props([
    'id' => uniqid(),
    'label' => 'Zaman',
])

<div class="">
    <label for="{{ $id }}" class="block text-sm/6 font-medium text-gray-900">
        {{ $label }}
    </label>
    <input type="datetime-local" id="{{ $id }}"
        {{ $attributes->merge([
            'class' =>
                'bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 w-full block p-2.5',
        ]) }} />
</div>
