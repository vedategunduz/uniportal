@extends('layouts.app')

@section('title', 'Hakkında')

@section('links')
    <style>
        .hakkinda-video {
            position: relative;
            padding: 1rem
        }

        .hakkinda-video::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 70%;
            border: 8px solid #7167FF;
            border-radius: 0 0 0 8px;
            left: 0rem;
            bottom: 0rem;
            clip-path: polygon(0 0, 0 100%, 40% 100%);
        }
    </style>
@endsection

@section('content')

    <div class="grid lg:grid-cols-2 gap-4">

        <div class="rounded text-gray-800 order-2 lg:order-1">
            <h2 class="text-2xl font-bold mb-4">Hakkımızda</h2>

            <p class="leading-relaxed">
                [Şirket/Proje Adı], [sektörünüz] alanında faaliyet gösteren, yenilikçi ve kaliteli hizmet sunmayı amaçlayan
                bir girişimdir.
                [Kuruluş yılı] yılından bu yana müşteri memnuniyetini ön planda tutarak, [hizmetleriniz veya ürünleriniz
                hakkında kısa bilgi]
                alanında çözümler geliştirmektedir.
            </p>

            <h3 class="text-xl font-semibold mt-6">Misyonumuz ve Vizyonumuz</h3>
            <p class="leading-relaxed mt-2">
                [Misyonunuzu buraya ekleyin, örneğin: "Teknolojiyi insan hayatını kolaylaştırmak için kullanmak."]
            </p>
            <p class="leading-relaxed mt-2">
                [Gelecek hedefleriniz hakkında bilgi verin, örneğin: "Yenilikçi çözümlerle sektöre yön vermek."]
            </p>

            <p class="leading-relaxed mt-6">
                Daha fazla bilgi almak için <a href="#" class="text-blue-600 hover:underline">bizimle
                    iletişime geçebilirsiniz</a>.
            </p>
        </div>

        <div class="order-1 lg:order-2">
            <div class="hakkinda-video">
                <video autoplay muted loop class="rounded w-full" loading="lazy">
                    <source src="{{ asset('image/hakkinda.mp4') }}" type="video/mp4">
                </video>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-6 gap-4 overflow-x-auto custom-scroll p-4 mt-8">
        <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript" target="_blank">
            <img src="{{ asset('image/kullandigimiz_teknolojiler/js-official-svgrepo-com.svg') }}"
                class="w-full h-full shrink-0" loading="lazy" alt="Javascript logo">
        </a>
        <a href="https://laravel.com/" target="_blank">
            <img src="{{ asset('image/kullandigimiz_teknolojiler/laravel-svgrepo-com (1).svg') }}"
                class="w-full h-full shrink-0" loading="lazy" alt="Laravel logo">
        </a>
        <a href="https://www.mysql.com/" target="_blank">
            <img src="{{ asset('image/kullandigimiz_teknolojiler/mysql-logo-svgrepo-com.svg') }}"
                class="w-full h-full shrink-0" loading="lazy" alt="MySql logo">
        </a>
        <a href="https://tailwindcss.com/" target="_blank">
            <img src="{{ asset('image/kullandigimiz_teknolojiler/tailwind-svgrepo-com.svg') }}"
                class="w-full h-full shrink-0" loading="lazy" alt="Tailwindcss logo">
        </a>
        <a href="https://vite.dev/" target="_blank">
            <img src="{{ asset('image/kullandigimiz_teknolojiler/vite-svgrepo-com.svg') }}" class="w-full h-full shrink-0"
                loading="lazy" alt="vite logo">
        </a>
        <a href="https://vite.dev/" target="_blank">
            <img src="{{ asset('image/kullandigimiz_teknolojiler/Livewire.svg') }}" class="w-full h-full shrink-0"
                loading="lazy" alt="Livewire logo">
        </a>
    </div>

    <div class="grid grid-cols-4 gap-4">
        <div class="flex items-center gap-2 p-4">
            <i class="bi bi-lightning-charge-fill text-yellow-500"></i>
            <span>Hazır Kullanım</span>
        </div>
        <div class="flex items-center gap-2 p-4">
            <i class="bi bi-bar-chart-line text-blue-500"></i>
            <span>Dinamik İstatistikler</span>
        </div>
        <div class="flex items-center gap-2 p-4">
            <i class="bi bi-clock-fill text-red-500"></i>
            <span>Zaman Yönetimi</span>
        </div>
        <div class="flex items-center gap-2 p-4">
            <i class="bi bi-layout-text-window-reverse text-green-500"></i>
            <span>Kolay Arayüz</span>
        </div>
        <div class="flex items-center gap-2 p-4">
            <i class="bi bi-shield-check text-indigo-500"></i>
            <span>Veri Bütünlüğü</span>
        </div>
        <div class="flex items-center gap-2 p-4">
            <i class="bi bi-box-seam text-purple-500"></i>
            <span>Ortam Bağımsız</span>
        </div>
        <div class="flex items-center gap-2 p-4">
            <i class="bi bi-upload text-orange-500"></i>
            <span>Doküman Aktarımı</span>
        </div>
        <div class="flex items-center gap-2 p-4">
            <i class="bi bi-tags-fill text-pink-500"></i>
            <span>Etiketleme Sistemi</span>
        </div>
        <div class="flex items-center gap-2 p-4">
            <i class="bi bi-shield-lock-fill text-teal-500"></i>
            <span>Güvenli Liman</span>
        </div>
        <div class="flex items-center gap-2 p-4">
            <i class="bi bi-share-fill text-blue-600"></i>
            <span>Bilgi Paylaşımı</span>
        </div>
        <div class="flex items-center gap-2 p-4">
            <i class="bi bi-phone-fill text-gray-600"></i>
            <span>Mobil Kullanım</span>
        </div>
        <div class="flex items-center gap-2 p-4">
            <i class="bi bi-key-fill text-cyan-500"></i>
            <span>Kolay Erişim</span>
        </div>
    </div>


@endsection

@section('scripts')

@endsection
