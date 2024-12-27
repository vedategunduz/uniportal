@extends('layouts.auth')

@section('title', 'Giriş yap')

@section('content')
   {{ Auth::user() }}
@endsection
