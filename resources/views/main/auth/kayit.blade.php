<x-empty-layout>
    <div class="flex flex-col items-center justify-center h-screen">
        <form class="max-w-sm w-full mx-auto text-gray-700 space-y-3">
            <div class="pb-8">
                <a href="{{ route('main.index') }}" class="flex items-center w-fit mx-auto space-x-3">
                    <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
                    {{-- <span class="text-2xl font-semibold whitespace-nowrap">uniportal</span> --}}
                </a>
                <div class="text-center mt-8">
                    <h3 class="text-2xl font-semibold">Hesap oluştur</h3>
                    <p class="">
                        Hesabınızı oluşturun
                    </p>
                </div>
            </div>
            <select id="kayit_tipi" tabindex="1"
                class="hidden bg-white border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="">Kayıt tipi seçiniz</option>
                <option value="1">İşletme</option>
                <option value="2">Üniversite</option>
            </select>
            <select name="isletmeler_id" id="isletmeler_id" tabindex="2"
                class="hidden bg-white border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 w-full p-2.5">
                <option value="">Seçiniz</option>
                @foreach ($universiteler as $universite)
                    <option value="{{ $universite->isletmeler_id }}">{{ $universite->baslik }}</option>
                @endforeach
            </select>
            <div class="grid grid-cols-2 gap-2">
                <div class="relative">
                    <input type="text" name="ad" id="ad" tabindex="3"
                        class="block p-2.5 w-full  bg-white text-gray-900 rounded border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " />
                    <label for="ad"
                        class="absolute  font-medium text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">
                        Ad
                    </label>
                </div>
                <div class="relative">
                    <input type="text" name="soyad" id="soyad" tabindex="4"
                        class="block p-2.5 w-full  bg-white text-gray-900 rounded border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " />
                    <label for="soyad"
                        class="absolute  font-medium text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">
                        Soyad
                    </label>
                </div>
            </div>
            <div class="relative">
                <input type="text" name="email" id="email" tabindex="5"
                    class="block p-2.5 w-full  bg-white text-gray-900 rounded border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " />
                <label for="email"
                    class="absolute  font-medium text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">
                    Email
                </label>
            </div>
            <div class="">
                <div class="relative">
                    <button type="button" class="absolute top-0 right-0 w-12 h-full flex items-center justify-center"
                        tabindex="7">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                            <path
                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                        </svg>
                    </button>
                    <input type="password" name="password" id="password" tabindex="6"
                        class="block p-2.5 w-full  bg-white text-gray-900 rounded border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " />
                    <label for="password"
                        class="absolute  font-medium text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">
                        Şifre
                    </label>
                </div>
                <div class="password-error text-rose-500"></div>
            </div>
            <div class="">
                <div class="relative">
                    <button type="button" class="absolute top-0 right-0 w-12 h-full flex items-center justify-center"
                        tabindex="9">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                            <path
                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                        </svg>
                    </button>
                    <input type="password" name="password_confirmation" id="password_confirmation" tabindex="8"
                        class="block p-2.5 w-full  bg-white text-gray-900 rounded border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " />
                    <label for="password_confirmation"
                        class="absolute font-medium text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">
                        Şifre tekrar
                    </label>
                </div>
                <div class="password-confirm-error text-rose-500"></div>
            </div>

            {{-- <div class="relative">
                <input type="text" name="referans_kodu" id="referans_kodu" tabindex="10"
                    class="block uppercase p-2.5 w-full  bg-white text-gray-900 rounded border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " />
                <label for="referans_kodu"
                    class="absolute  font-medium text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">
                    Referans kodu
                </label>
            </div> --}}
            <label for="agreement" class="flex items-center gap-2">
                <input type="checkbox" name="agreement" id="agreement" tabindex="11"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                <span class=" font-medium">
                    <a href="#" class="text-blue-700 hover:text-blue-700 hover:underline"
                        tabindex="12">Şartları</a> ve
                    <a href="#" class="text-blue-700 hover:text-blue-700 hover:underline"
                        tabindex="13">gizlilik
                        politikasını</a>
                    kabul ediyorum
                </span>
            </label>
            <button type="submit" tabindex="14"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg  px-4 py-2 text-center w-full">
                Hesap oluştur
            </button>
            <div class="text-center mt-3">
                <a href="{{ route('auth.giris.form') }}" tabindex="15"
                    class=" font-medium text-blue-700 hover:text-blue-700 !hover:underline">Mevcut bir hesapta oturum
                    açın</a>
            </div>
        </form>
    </div>
    <script>
        const form = document.querySelector('form');
        const password = document.querySelector('input[name=password]');
        const password_error = document.querySelector('.password-error');
        const password_confirmation = document.querySelector('input[name=password_confirmation]');
        const password_confirm_error = document.querySelector('.password-confirm-error');

        const kayit_tipi = document.querySelector('#kayit_tipi');

        kayit_tipi.addEventListener('change', function() {
            const value = this.value;

            if (value == 2) {
                this.nextElementSibling.classList.remove('hidden');
            } else {
                this.nextElementSibling.classList.add('hidden');
            }
        })

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            let formSubmit = true;

            const agreement = document.querySelector('input[name=agreement]');

            if (!agreement.checked) {
                errorAlert('Şartları ve gizlilik politikasını kabul etmelisiniz');
                formSubmit = false;
            }

            if (password.value.length < 8) {
                password_error.innerText = 'Şifre en az 8 karakter olmalıdır';
                password.classList.add('text-rose-500');
                formSubmit = false;
            }

            if (password.value !== password_confirmation.value)
                formSubmit = false;

            if (formSubmit) {
                const formData = new FormData(form);
                const RESPONSE_DATA = await fetchData(`auth/kayit`, formData, true);

                if (RESPONSE_DATA.success) {
                    successAlert(RESPONSE_DATA.message);
                } else {
                    if (RESPONSE_DATA.errors) {
                        for (const [key, value] of Object.entries(RESPONSE_DATA.errors))
                            errorAlert(value);
                    } else
                        errorAlert(RESPONSE_DATA.message);
                }
            }
        })

        document.addEventListener('click', (e) => {
            if (e.target.matches('button[type=button]')) {
                const button = e.target;
                const password_input = button.nextElementSibling;

                password_input.type = password_input.type === 'password' ? 'text' : 'password';

                if (password_input.type == 'password') {
                    button.innerHTML =
                        `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" /><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" /></svg>`;
                } else {
                    button.innerHTML =
                        `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16"><path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/></svg>`;
                }
            }
        });

        password.addEventListener('input', () => {
            if (password.value !== password_confirmation.value) {
                password_confirm_error.innerText = 'Şifreler uyuşmuyor';
                password_confirmation.classList.add('text-rose-500');
            } else {
                password_confirm_error.innerText = '';
                password_confirmation.classList.remove('text-rose-500');
            }

            if (password.value.length < 8) {
                password_error.innerText = 'Şifre en az 8 karakter olmalıdır';
                password.classList.add('text-rose-500');
            } else {
                password_error.innerText = '';
                password.classList.remove('text-rose-500');
            }
        });

        password_confirmation.addEventListener('input', () => {
            if (password.value !== password_confirmation.value) {
                password_confirm_error.innerText = 'Şifreler uyuşmuyor';
                password_confirmation.classList.add('text-rose-500');
            } else {
                password_confirm_error.innerText = '';
                password_confirmation.classList.remove('text-rose-500');
            }
        });
    </script>
</x-empty-layout>
