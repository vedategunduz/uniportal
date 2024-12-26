@extends('layouts.auth')

@section('title', 'User dashboard')

@section('links')

@endsection

@section('aside')
    <nav class="">
        <ul>
            <li><a href="{{ route('kullanici.cikis') }}" class="">Çıkış</a></li>
        </ul>
    </nav>
@endsection

@section('content')

@endsection

@section('scripts')
@endsection
