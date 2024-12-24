@extends('layouts.default.app')

@section('title', 'uniportal | Kamular')

@section('content')

    <section class="grid grid-cols-5 gap-4">
        @foreach ($kamular as $kamu)
            <div class="border p-4">
                <a href="/kamu/" class="">{{ $kamu->baslik }}</a>
            </div>
        @endforeach
    </section>

    <div class="py-4">
        {{ $kamular->links() }}
    </div>

@endsection
