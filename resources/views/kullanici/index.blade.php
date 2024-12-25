@extends('layouts.auth')

@section('title', 'User dashboard')

@section('content')

@section('aside')
    <nav class="">
        <ul>
            @foreach ($menuler as $menu)
                <li><a href="{{ $menu['menu']->menu_link }}">{{ $menu['menu']->menu_adi }}</a></li>
            @endforeach
            <li><a href="{{ route('kullanici.cikis') }}" class="">Çıkış</a></li>
        </ul>
    </nav>
@endsection

{{ Auth::user() }}

@endsection
