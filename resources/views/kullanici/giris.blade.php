@extends('layouts.app')

@section('title', 'Giriş yap')

@section('content')
    <form action="{{ route('kullanici.giris.yap') }}" method="POST" class="max-w-sm mx-auto">
        @csrf
        <div class="mb-3">
            <x-label for="email" text="Email:" />
            <x-input type="email" id="email" name="email" value="admin@nku.edu.tr" />
        </div>
        <div class="mb-3">
            <x-label for="password" text="Şifre:" />
            <x-input type="password" name="password" id="password" value="12345600" />
        </div>
        <x-button type="submit" text="Oturum aç" id="" />
    </form>
@endsection
