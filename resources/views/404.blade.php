@extends('layouts.empty')

@section('title', '404')

@section('links')

@endsection

@section('content')
    <div class="flex flex-col items-center  h-screen">
        <img src="{{ asset('image/404 Error-rafiki.png') }}" class="h-full" alt="">

        <a href="{{ route('main.index') }}">Anasayfa</a>
    </div>
@endsection

@section('scripts')
@endsection
