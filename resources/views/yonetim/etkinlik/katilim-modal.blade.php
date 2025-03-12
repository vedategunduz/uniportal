<section>
    <form
        action="{{ route('yonetim.etkinlikler.katilimcilar.cevap', ['etkinlik_id' => encrypt($etkinlik->etkinlikler_id)]) }}"
        method="POST" class="etkinlik-katilim-modal-form">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class=""></div>
            <div class=""></div>
            <x-button type="submit" data-type="Reddedildi"
                class="etkinlik-katilim-cevap justify-center !bg-rose-600 hover:!bg-rose-700 focus:ring-rose-500 border-none text-white">
                Reddet
            </x-button>
            <x-button type="submit" data-type="Onaylandı"
                class="etkinlik-katilim-cevap  justify-center !bg-green-400 hover:!bg-green-500 focus:ring-green-300 border-none text-white">
                Onayla
            </x-button>
        </div>

        <div class="overflow-x-auto p-2 w-full">
            <table id="katilim-detay" class="table table-bordered table-hover max-w-full bg-white rounded">
                <thead class="bg-gray-50 text-gray-700">
                    <tr>
                        <th data-dt-order="disable"><x-checkbox name="toggleAll"></x-checkbox></th>
                        <th>İsim</th>
                        <th>Durum</th>
                        <th>İşletme</th>
                        <th>Unvan</th>
                        <th>Email</th>
                        <th>Açıklama</th>
                        <th data-dt-order="disable" title="Sohbet">#</th>
                        <th data-dt-order="disable" title="Notlar">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($etkinlik->katilimcilar as $katilimci)
                        <tr>
                            <td>
                                <x-checkbox name="kullanicilar_id[]" :value="encrypt($katilimci->kullanici->kullanicilar_id)"></x-checkbox>
                            </td>
                            <td>
                                <div class="flex flex-nowrap w-max items-center">
                                    <img src="{{ $katilimci->kullanici->profilFotoUrl }}"
                                        class="size-8 rounded-full shrink-0" alt="">
                                    <span class="ms-2 text-gray-800 text-nowrap">
                                        {{ $katilimci->kullanici->ad }} {{ $katilimci->kullanici->soyad }}
                                    </span>
                                </div>
                            </td>
                            <td data-durum>
                                <span @class([
                                    'border rounded text-xs px-2 py-1',
                                    'text-green-500 bg-green-100 border-green-400' =>
                                        $katilimci->durum == 'Onaylandı',
                                    'text-yellow-500 bg-yellow-100 border-yellow-400' =>
                                        $katilimci->durum == 'Beklemede',
                                    'text-red-500 bg-red-100 border-red-400' =>
                                        $katilimci->durum == 'Reddedildi',
                                ])>
                                    {{ $katilimci->durum }}
                                </span>
                            </td>
                            <td>
                                <span
                                    class="text-gray-800 text-nowrap">{{ $katilimci->kullanici->anaIsletme->kisaltma }}</span>
                            </td>
                            <td>
                                <span
                                    class="text-gray-800 text-nowrap">{{ $katilimci->kullanici->anaUnvan->baslik }}</span>
                            </td>
                            <td>
                                <a href="#" class="text-gray-600 hover:text-gray-900">
                                    {{ $katilimci->kullanici->email }}
                                </a>
                            </td>
                            <td>
                                <span class="text-gray-600 hover:text-gray-900 show-more-text text-ellipsis line-clamp-3 text-wrap break-words">{{ $katilimci->aciklama }}</span>
                            </td>
                            <td>
                                <div class="flex">
                                    <a href="javascript:void(0)"
                                        class="sohbet-baslat inline-flex items-center gap-2 p-2 bg-green-400 text-xs !text-white rounded rounded-r-none text-nowrap"
                                        data-id="{{ encrypt($katilimci->kullanici->kullanicilar_id) }}"
                                        data-etkinlik-id="{{ encrypt($etkinlik->etkinlikler_id) }}">
                                        <span>Sohbet başlat</span>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="ziyaret-kanallar inline-flex items-center gap-2 p-2 bg-green-300 text-xs !text-white rounded rounded-l-none"
                                        data-name="{{ $etkinlik->kod }}">
                                        <span>
                                            @php
                                                $count = 0;

                                                foreach ($etkinlik->mesajKanallari as $kanal) {
                                                    foreach ($kanal->katilimcilar as $k) {
                                                        if (
                                                            $k->kullanicilar_id ==
                                                            $katilimci->kullanici->kullanicilar_id
                                                        ) {
                                                            $count++;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            {{ $count }}
                                        </span>
                                        <i class="bi bi-chat-dots-fill"></i>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <button class="text-blue-500 hover:text-blue-800 py-1">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>
</section>
