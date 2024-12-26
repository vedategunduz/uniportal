@extends('layouts.auth')

@section('title', 'User dashboard')

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

@section('content')

    <div id="editorjs" class="border"></div>

    <x-button type="submit" text="Kaydet" id="saveEditor" />

@endsection


@section('scripts')
    @vite(['resources/js/editor.js'])
@endsection
