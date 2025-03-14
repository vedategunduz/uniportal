@props(['yorumlar', 'depth' => 0])

@if ($yorumlar->count())
    @foreach ($yorumlar as $yorum)
        <x-paylasim.yorum-component :yorum="$yorum" :depth="$depth" />
    @endforeach
@else
2
    <div class="text-center text-gray-500 py-4">
        Henüz yorum yapılmamış.
    </div>
@endif
