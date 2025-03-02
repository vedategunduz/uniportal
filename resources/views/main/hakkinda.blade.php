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
                <video autoplay muted loop class="rounded w-full">
                    <source src="{{ asset('image/hakkinda.mp4') }}" type="video/mp4">
                </video>
            </div>
        </div>
    </div>

    <div class="">
        Kullandığımız teknolojiler gelecek
    </div>
    <div class="">
        neden biz ulaks
    </div>

@endsection

@section('scripts')

@endsection
