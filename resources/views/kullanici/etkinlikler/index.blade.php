@extends('layouts.auth')

@section('title', 'User dashboard')

@section('content')
    <h3 class="font-semibold mb-4">Etkinlikler</h3>
    <div class="flex justify-between items-center mb-4">
        <input type="text" name="q" id="q"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5"
            placeholder="Ara...">

        <a href="#" class="py-2 px-3 rounded-md shadow-md text-white bg-blue-600 hover:bg-blue-700 transition flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-5 me-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>

            <span>Etkinlik Ekle</span>
        </a>
    </div>
    <h3 class="mb-4">Başlık</h3>
    <p>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod illo quaerat cupiditate error vero doloremque
        laudantium dolore quam repellat hic, sit, veniam dolorum? Nam aut quaerat amet, voluptatum possimus suscipit?
    </p>
@endsection
