<section class="flex justify-center -space-x-4">
    @foreach ($kullanicilar as $kullanici)
        <div @class(['rounded-full border-2 border-gray-50'])>
            <img src="{{ $kullanici->kullanici->profilFotoUrl }}" class="size-8 rounded-full" alt="">
        </div>
    @endforeach
    <button type="button"
        class="size-9 rounded-full flex items-center justify-center bg-blue-950 text-xs text-white border-2">
        <i class="bi bi-plus"></i>
        {{ $kullanicilar->count() }}
    </button>
</section>
