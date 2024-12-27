@extends('layouts.app')

@section('title', 'uniportal | Kamular')

@section('content')

    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" id="kamular">
        @foreach ($kamular as $kamu)
            <x-kamu logoUrl="{{ $kamu->logo_url }}" websiteUrl="{{ $kamu->website_url }}" xUrl="{{ $kamu->x_url }}" instagramUrl="{{ $kamu->instagram_url }}"
                linkedinUrl="{{ $kamu->linkedin_url }}" text="{{ $kamu->baslik }}" href="/{{ $kamu->kamular_id }}" />
        @endforeach
    </section>

    <div class="py-4" id="pagination">
        {{ $pagination = $kamular->links('pagination::tailwind') }}
    </div>

@endsection

@section('scripts')
    <script>
        const kamuContainer = document.getElementById('kamular');
        const pagination = document.getElementById('pagination');

        // Paginator linklerine tıklama olayını dinle
        pagination.addEventListener('click', function(e) {
            // Sadece <a> etiketlerine tıklanmışsa
            if (e.target.tagName === 'A') {
                e.preventDefault(); // Sayfanın yeniden yüklenmesini engelle
                const url = e.target.getAttribute('href'); // Hedef URL'yi al
                fetchKamu(url); // Ajax isteğini başlat
            }
        });

        // Veri çekme ve DOM güncelleme fonksiyonu
        function fetchKamu(url) {
            // Yükleniyor göstergesi ekleyin (isteğe bağlı)
            kamuContainer.innerHTML = '<p>Yükleniyor...</p>';
            pagination.innerHTML = '';

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Ajax isteği olduğunu belirt
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Gelen HTML'i güncelle
                    // return console.log(data);

                    kamuContainer.innerHTML = data.html;
                    pagination.innerHTML = data.pagination;
                    // URL'yi tarayıcıda güncelle (isteğe bağlı)
                    // history.pushState(url, '', url);
                })
                .catch(error => {
                    console.error('Hata:', error);
                    kamuContainer.innerHTML = '<p>Veri yüklenirken bir hata oluştu.</p>';
                    pagination.innerHTML = '';
                });
        }

        // // // Tarayıcı ileri/geri butonları için destek
        // window.addEventListener('popstate', function() {
        //     fetchKamu(window.location.href);
        // });
    </script>
@endsection
