@extends('layouts.empty')

@section('title', $message)

@section('links')

@endsection

@section('content')
    <div class="flex flex-col gap-4 items-center justify-center h-screen">
        <a href="{{ route('main.index') }}" class="flex items-center space-x-3">
            <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
            <span class="text-2xl font-semibold whitespace-nowrap">uniportal</span>
        </a>
        <div class="bg-white p-8 rounded border shadow flex flex-col max-w-96">
            @if ($success)
                <img src="{{ asset('image/onay.png') }}" class="w-72" alt="">

                <h2 class="text-2xl font-semibold mb-2 text-gray-700 text-center">{{ $message }}</h2>
                <p class="text-gray-500 text-sm mb-4">
                    Takviminize eklemek için aşağıdaki butona tıklayabilirsiniz.
                </p>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ $googleCalendarUrl }}" class="flex items-center border py-1 px-2 rounded" target="_blank">
                        <img src="{{ asset('image/googleclander.webp') }}" class="size-8" alt="">
                        <span class="ml-2">Google Takvim</span>
                    </a>
                    <a href="{{ route('api.etkinlik.katilim.download-ics', ['id' => encrypt($etkinlik->etkinlikler_id)]) }}"
                        class="flex items-center border py-1 px-2 rounded">
                        <span class="ml-2">ICS Dosyası</span>
                    </a>
                </div>
            @else
                <img src="{{ asset('image/red.png') }}" class="w-72" alt="">
                <h2 class="text-2xl font-semibold mb-2 text-gray-700 text-center">{{ $message }}</h2>

                <p class="text-gray-500 text-sm mb-4">
                    Yanıtınızı değiştirmek için aşağıdaki butona tıklayabilirsiniz.
                </p>

                <div class="">
                    <a href="{{ route('api.etkinlik.katilim.onayla', ['parametre' => $parametre]) }}"
                        class="text-center block hover:text-white bg-blue-700 text-white text-sm rounded px-4 py-2.5 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                        Daveti onayla
                    </a>
                </div>
            @endif
        </div>
    </div>

@endsection

@section('scripts')

@endsection
