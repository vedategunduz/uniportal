@props(['yorumlar', 'depth' => 0])

@foreach ($yorumlar as $yorum)
    <x-etkinlik.yorum-component :yorum="$yorum" :depth="$depth" />
@endforeach
