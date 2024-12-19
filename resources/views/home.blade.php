@extends('layouts.app')

@section('title', 'Anasayfa')

<style>
    pre {
        white-space: pre-wrap;
        /* Satırları gerektiğinde sarar */
        word-wrap: break-word;
        /* Uzun kelimeleri kırarak sarmayı sağlar */
        overflow-x: auto;
        /* Yatay kaydırma çubuğu ekler */
        padding: 15px;
        /* İç boşluk ekler (isteğe bağlı) */
    }

    code {
        font-family: Consolas, "Courier New", monospace;
        /* Monospace font kullanımı */
        font-size: 14px;
        /* Yazı boyutu */
    }
</style>


@section('content')
    <main>
        @if ($veriler)
            <pre>
            <code>
                {!! $veriler !!}
            </code>
        </pre>
        @endif
    </main>
@endsection
