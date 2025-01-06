@extends('layouts.auth')

@section('title', 'User dashboard')

@section('links')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <style>
        select.dt-input {
            width: 60px;
        }

        #resimcontainer {
            text-align: center
        }

        #resimcontainer,
        #resimlercontainer {
            img {
                max-width: 100%;
                max-height: 11.75rem;
                object-fit: cover;
                margin: 0 auto;
            }
        }
    </style>
@endsection

@section('content')
    <h3 class="font-semibold mb-4">Etkinlikler</h3>
    <div class="mb-4">
        <button type="button" data-modal-target="etkinlikModal"
            class="open-modal py-2 px-3 rounded-md shadow-md text-white bg-blue-600 hover:bg-blue-700 transition flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-5 me-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>

            <span>Etkinlik Ekle</span>
        </button>
    </div>

    <section id="etkinlikModal"
        class="hidden fixed top-0 left-0 w-screen h-screen inset-0 z-10 overflow-auto max-h-screen py-4">
        <button type="button" class="close-modal fixed top-0 left-0 w-full h-full bg-black/30 cursor-pointer z-20"
            data-modal-target="etkinlikModal"><span class="sr-only">Modalı kapat</span></button>

        <div class="mx-auto max-w-screen-2xl z-30 relative zoomIn-modal-animation">
            <div class="hidden absolute w-full h-full rounded items-center justify-center bg-black/50 z-50"
                id="etkinlikLoader">
                <span class="text-white">Lütfen bekleyin...</span>
            </div>
            <div class="bg-white rounded-md" id="etkinlikModalContent"></div>
        </div>
    </section>

    <div class="grid lg:grid-cols-3 gap-4">
        @foreach ($etkinlikler as $etkinlik)
            <div class="flex flex-col justify-between border border-dashed rounded p-4 shadow-sm">
                <h4 class="text-wrap h-14 overflow-hidden text-ellipsis whitespace-nowrap"> {{ $etkinlik->baslik }} </h4>
                <p class="mb-2"> {{ $etkinlik->isletme->baslik }} </p>

                <div class="grid lg:grid-cols-2 gap-4 p-4 rounded border">
                    <div class="space-y-2">
                        <p class="text-gray-700 font-bold flex items-center">
                            <span class="p-1.5 rounded bg-emerald-100 text-emerald-500 me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                </svg>
                            </span>
                            <span>Kontenjan</span>
                        </p>
                        <p> {{ $etkinlik->kontenjan }} </p>
                    </div>
                    <div class="space-y-2">
                        <p class="text-gray-700 font-bold flex items-center">
                            <span class="p-1.5 rounded bg-indigo-100 text-violet-500 me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" />
                                </svg>
                            </span>
                            <span>Başvuru tarihi</span>
                        </p>
                        <p>{{ $etkinlik->formatted_date_time }}</p>
                    </div>
                    <div class="space-y-2">
                        <p class="text-gray-700 font-bold flex items-center">
                            <span class="p-1.5 rounded bg-blue-100 text-blue-500 me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                            </span>
                            <span>Adres</span>
                        </p>
                        <p>Rüya Sokak 104 84639 İstanbul</p>
                    </div>
                    <div class="space-y-2">
                        <p class="text-gray-700 font-bold flex items-center">
                            <span class="p-1.5 rounded bg-indigo-100 text-indigo-500 me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </span>
                            <span>Başlama tarihi</span>
                        </p>
                        <p>{{ $etkinlik->formatted_date_time }}</p>
                    </div>
                </div>

                <div class="mt-2">
                    <button
                        class="etkinlikDuzenleButton px-4 py-1 rounded-md border border-blue-200 bg-blue-100 text-blue-700 hover:bg-blue-700 hover:text-white focus:bg-blue-700 focus:text-white focus:ring-2 ring-blue-300 transition"
                        data-modal-target="etkinlikModal" data-target="{{ encrypt($etkinlik->etkinlikler_id) }}"
                        type="button">Düzenle</button>
                </div>
            </div>
        @endforeach
    </div>
@endsection
