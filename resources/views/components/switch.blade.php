@props([
    'checked' => false,
])

<label class="inline-flex items-center cursor-pointer">
    <input type="checkbox" class="sr-only peer" @if ($checked) checked @endif {{ $attributes }}>
    <div
        class="relative w-7 h-4 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-blue-600">
    </div>
    <span class="ms-3 text-xs font-light text-gray-900 dark:text-gray-300">{{ $slot }}</span>
</label>
