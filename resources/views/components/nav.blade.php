<section class="container py-4">
    <nav class="lg:flex items-center justify-between">
        <a href="/" class="uppercase text-2xl font-bold text-blue-600">{{ $logo }}</a>
        <ul class="lg:flex lg:space-x-8">
            @foreach ($links as $link)
                <li>
                    <a href="#" class="text-zinc-700 flex flex-col items-center">
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
                <a href="/giris" class="block rounded-full border border-blue-400 text-blue-500 font-medium px-6 py-3 text-center">
                    Giriş yap
                </a>
            </li>
        </ul>
    </nav>
</section>
