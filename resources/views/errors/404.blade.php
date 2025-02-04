@extends('layouts.empty')

@section('title', '404')

@section('links')

@endsection

@section('content')
    <div class="flex flex-col items-center justify-center h-screen bg-gradient-to-br from-zinc-900 to-blue-900">
        <div class="max-h-96 text-center">
            <img src="{{ asset('image/404 Error-rafiki.png') }}" class="h-full mx-auto" alt="">
            <p class="text-white text-xl font-bold uppercase">
                Üzgünüz, aradığınız sayfa bulunamadı.
            </p>
            <div class="flex items-center justify-center space-x-2 mt-4">
                <a href="{{ route('main.index') }}"
                    class="uppercase bg-white text-blue-900 px-3 py-2 rounded-full font-medium hover:text-blue-900 transition">Anasayfa</a>
                <a href="{{ route('main.index') }}"
                    class="uppercase border text-white px-3 py-2 rounded-full font-medium hover:bg-white hover:text-blue-900 transition">İletişim</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
