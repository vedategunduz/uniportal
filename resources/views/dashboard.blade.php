@extends('layouts.user.app')

@section('title', 'User dashboard')

@section('content')

@section('aside')
    <nav class="">
        <ul>
            @foreach ($menuler as $menu)
                <li><a href="{{ $menu['menu']->menu_link }}">{{ $menu['menu']->menu_adi }}</a></li>
            @endforeach
            <li><a href="/profile/{{ encrypt(Auth::user()->kullanicilar_id) }}" class="">Profil</a></li>
            <li><a href="cikis" class="">Çıkış</a></li>
        </ul>
    </nav>
@endsection

{{ Auth::user() }}

@endsection
