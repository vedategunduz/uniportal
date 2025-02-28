<x-empty-layout>
    <div class="flex flex-col gap-4 items-center justify-center h-screen">
        <a href="{{ route('main.index') }}" class="flex items-center space-x-3">
            <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
            <span class="text-2xl font-semibold whitespace-nowrap"> {{ config('app.name') }}</span>
        </a>
        <div class="bg-white p-8 rounded border shadow flex flex-col max-w-96 text-center">
            @if ($success)
                <img src="{{ asset('image/onay.png') }}" class="w-72" alt="">
            @else
                <img src="{{ asset('image/red.png') }}" class="w-72" alt="">
            @endif
            <p>{{ $message }}</p>
            <p>
                Giriş için <a href="{{ route('auth.giris.form') }}"
                    class="text-blue-700 hover:text-blue-700 underline">tıklayınız</a>
            </p>
        </div>
    </div>
</x-empty-layout>
