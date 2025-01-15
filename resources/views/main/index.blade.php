@extends('layouts.app')

@section('title', 'Anasayfa')

@section('content')


@endsection

@section('scripts')
    <script>
        let type = 'success';
        switch (type) {
            case 'success':
                CONTAINER_CLASS.push('border-emerald-300', 'bg-emerald-100', 'text-emerald-600');
                ALERT_HEAD.textContent = 'Başarılı!';
                ALERT_HEAD.classList.add('text-emerald-700', 'font-bold', 'me-2');
                break;
            case 'error':
                CONTAINER_CLASS.push('border-rose-300', 'bg-rose-100', 'text-rose-700');
                ALERT_HEAD.textContent = 'Hata!';
                ALERT_HEAD.classList.add('text-rose-700', 'font-bold', 'me-2');
                break;
            case 'info':
                CONTAINER_CLASS.push('border-blue-300', 'bg-blue-100', 'text-blue-600');
                ALERT_HEAD.textContent = 'Bilgi!';
                ALERT_HEAD.classList.add('text-blue-700', 'font-bold', 'me-2');
                break;
            case 'warning':
                CONTAINER_CLASS.push('border-yellow-300', 'bg-yellow-100', 'text-yellow-600');
                ALERT_HEAD.textContent = 'Uyarı!';
                ALERT_HEAD.classList.add('text-yellow-700', 'font-bold', 'me-2');
                break;
        }
    </script>
@endsection
