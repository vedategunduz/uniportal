@extends('layouts.default.app')

@section('title', 'Giriş yap')

@section('content')
    <div class="flex items-center justify-center min-h-screen">

        <form action="{{ route('giris_yap') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="border block" value="admin@nku.edu.tr">
            </div>
            <div class="mb-3">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="border block" value="12345600">
            </div>
            <button type="submit">Giriş yap</button>
        </form>

    </div>
@endsection
