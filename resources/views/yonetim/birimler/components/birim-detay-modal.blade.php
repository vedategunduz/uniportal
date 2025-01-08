<form action="" method="POST">
    <div class="mb-2">
        <label for="baslik">Birim adı</label>
        <input type="text" id="baslik" name="baslik" value="Bilgi işlem daire başkanlığı"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
    </div>
    <div class="mb-2">
        <label for="isletme_birimleri_id">Bağlı olduğu birim</label>
        <select name="" id=""
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option value="">Daire başkanlığı</option>
        </select>
    </div>
    <div class="">
        <span>Personeller</span>

        <div class="flex space-x-2">

            <div id="personeller" class="flex space-x-2">
                <x-personel-popover-cart />
            </div>

            <button class="border rounded-full size-12 bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6 mx-auto">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </button>
        </div>
    </div>
</form>
