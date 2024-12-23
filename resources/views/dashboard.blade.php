@extends('layouts.user.app')

@section('title', 'User dashboard')

@section('content')
    @auth
        @section('aside')
            <aside>
                <nav>
                    <ul>
                        @foreach ($menuler as $menu)
                            <li><a href="{{ $menu['menu']->menu_link }}">{{ $menu['menu']->menu_adi }}</a></li>
                        @endforeach
                        <li><a href="cikis">Çıkış</a></li>
                    </ul>
                </nav>
            </aside>
        @endsection
        {{ Auth::user() }}
    @endauth
@endsection
