@props(['disabled' => false])

<textarea @disabled($disabled)
    {{ $attributes->merge(['class' => 'block w-full max-h-32 custom-scroll text-sm text-gray-900 bg-gray-50 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500 disabled:text-gray-500']) }}>{{ $slot }}</textarea>
