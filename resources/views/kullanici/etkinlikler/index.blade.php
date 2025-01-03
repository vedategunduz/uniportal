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
            <div class="bg-white rounded-md" id="etkinlikModalContent"></div>
        </div>
    </section>

    <table id="myTable">
        <thead>
            <tr>
                <th>Başlık</th>
                <th>Kontenjan</th>
                <th>Etkinlik Başlama</th>
                <th>Etkinlik Bitiş</th>
                <th>Başvuru Başlama</th>
                <th>Başvuru Bitiş</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($etkinlikler as $etkinlik)
                <tr>
                    <td>{{ $etkinlik->baslik }}</td>
                    <td>{{ $etkinlik->kontenjan }}</td>
                    <td>{{ $etkinlik->etkinlikBaslamaTarihi }}</td>
                    <td>{{ $etkinlik->etkinlikBitisTarihi }}</td>
                    <td>{{ $etkinlik->etkinlikBasvuruTarihi }}</td>
                    <td>{{ $etkinlik->etkinlikBasvuruBitisTarihi }}</td>
                    <td><button class="etkinlikDuzenleButton" data-modal-target="etkinlikModal"
                            data-target="{{ encrypt($etkinlik->etkinlikler_id) }}" type="button"
                            class="px-3 py-1 border rounded-md">Düzenle</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')

@endsection
