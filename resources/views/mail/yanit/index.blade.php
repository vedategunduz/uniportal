@extends('layouts.empty')

@section('title', 'Giriş yap')

@section('links')

@endsection

@section('content')
    <div class="flex items-center justify-center h-screen">
        <div class="bg-white py-8 rounded shadow-lg flex flex-col items-center">
            @if ($success)
                <img src="{{ asset('image/onay.png') }}" class="w-96" alt="">
            @else
                <img src="{{ asset('image/red.png') }}" class="w-96" alt="">
            @endif
            <h4 class="capitalize">{{ $message }}</h4>
            <a href="{{ route('main.index') }}" class="mt-2 text-sm text-blue-500">Anasayfaya dön</a>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
