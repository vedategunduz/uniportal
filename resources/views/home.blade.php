@extends('layouts.app')

@section('title', 'Anasayfa')

@section('content')

<form action="{{ route('ekle') }}" method="POST">
    @csrf
    <div class="">
        <label for="etkinlik_tur">Etkinlik kategorisi:</label>
        <input type="text" name="etkinlik_tur" id="etkinlik_tur" placeholder="Bilişim" class="border border-slate-200 block">
    </div>
    <button type="submit">Gönder</button>
</form>

@endsection
