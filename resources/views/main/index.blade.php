@extends('layouts.app')

@section('title', 'Anasayfa')

@section('content')

    {{-- <video autoplay muted width="100%" height="100%" class="">
        <source src="image/ford.mp4" type="video/mp4">
    </video> --}}

    <livewire:etkinlik-component />

    <div class="text-center py-2">
        <x-button id="tikla" class="">Daha fazla</x-button>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('tikla').addEventListener('click', function() {
            Livewire.dispatch('showMore');
        });

        document.querySelectorAll('.shareBtn').forEach(button => {
            button.addEventListener('click', async () => {
                if (navigator.share) {
                    try {
                        await navigator.share({
                            title: document.title,
                            url: window.location.href,
                        });
                        console.log("Paylaşım başarılı!");
                    } catch (err) {
                        console.error("Paylaşım başarısız:", err);
                    }
                } else {
                    alert("Tarayıcınız paylaşım desteği sunmuyor.");
                }
            })
        })
    </script>
@endsection
