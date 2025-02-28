@extends('layouts.app')

@section('title', 'Hakkında')

@section('banner')
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3011.450861272685!2d27.581520076735455!3d40.993503971352496!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14b4f4fdb97d93a9%3A0x7f4ceb44179aabd!2sTekirda%C4%9F%20Nam%C4%B1k%20Kemal%20%C3%9Cniversitesi!5e0!3m2!1str!2str!4v1740747195985!5m2!1str!2str"
        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"></iframe>
@endsection

@section('content')

    <form action="" class="max-w-screen-sm mx-auto mt-8 bg-white">

        <div class="space-y-4">
            <x-relative-input label="Ad" value=" " name="ad"/>

            <x-textarea name="mesaj" />

            <x-button>
                Gönder
            </x-button>
        </div>

    </form>

@endsection

@section('scripts')

@endsection
