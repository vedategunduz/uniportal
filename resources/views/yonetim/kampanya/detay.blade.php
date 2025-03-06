@extends('layouts.auth')

@section('title', 'Kampanya Yönetimi')
@section('links')

@endsection

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-3">
        <div class="col-span-2">
            <div class="shadow rounded border border-gray-300 p-4">
                <h4>{{ $etkinlik->baslik }}</h4>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
