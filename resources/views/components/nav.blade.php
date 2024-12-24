<section class="container">
    <nav class="lg:flex items-center justify-between">
        <a href="/" class="text-2xl font-bold text-blue-600">{{ $logo }}</a>
        <ul class="lg:flex">
            @foreach ($links as $link)
                <li>
                    <a href="{{ $link['path'] }}" class="{{ $class }}">
                        {!! $link['icon'] !!}
                        <span>
                            {{ $link['name'] }}
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
        <ul>
            <li>
                <a href="/giris" class="block rounded-full border border-blue-400 text-blue-500 font-medium px-6 py-3 text-center hover:bg-blue-100 transition">
                    Oturum aç
                </a>
            </li>
        </ul>
    </nav>
</section>
