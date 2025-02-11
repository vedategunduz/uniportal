@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-2"']) }}>
