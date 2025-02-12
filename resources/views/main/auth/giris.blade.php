<x-empty-layout>
    <div class="flex flex-col items-center justify-center h-screen">
        <form action="{{ route('auth.giris.yap') }}" method="POST" class="max-w-sm w-full mx-auto text-gray-700 px-4">
            @csrf
            <div class="mb-8">
                <a href="{{ route('main.index') }}" class="flex items-center w-fit mx-auto space-x-3">
                    <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
                    {{-- <span class="text-2xl font-semibold whitespace-nowrap">uniportal</span> --}}
                </a>
                <div class="text-center mt-8">
                    <h3 class="text-2xl font-semibold">Oturum aç</h3>
                    <p class="">
                        Hesabınıza erişim sağlayın
                    </p>
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="block mb-2  font-medium">
                    Email
                </label>
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-person-fill size-5 absolute top-1/2 -translate-y-1/2 left-3" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                    </svg>
                    <input type="email" name="email" id="email"
                        class="pl-10 bg-gray-50 border border-gray-300  rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        value="admin@nku.edu.tr" placeholder="example@xxx.edu.tr">
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="block mb-2  font-medium">
                    Şifre
                </label>
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-key-fill size-5 absolute top-1/2 -translate-y-1/2 left-3" viewBox="0 0 16 16">
                        <path
                            d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2M2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                    </svg>
                    <input type="password" name="password" id="password"
                        class="pl-10 bg-gray-50 border border-gray-300  rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        value="12345600" placeholder="Şifre">
                    <button type="button" class="absolute top-0 right-0 w-12 h-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                            <path
                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="mb-6 flex items-center justify-between">
                <label for="remember" class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    <span class=" font-medium">Beni hatırla</span>
                </label>
                <a href="#" class=" font-medium text-blue-700 hover:text-blue-700 hover:underline">Şifremi
                    unuttum</a>
            </div>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg  px-4 py-2 text-center w-full">
                Oturum aç
            </button>
            <div class="text-center mt-3">
                <a href="{{ route('auth.kayit.form') }}"
                    class=" font-medium text-blue-700 hover:text-blue-700 hover:underline">Hesap
                    oluştur</a>
            </div>
        </form>
    </div>
    <script>
        const password_input = document.querySelector('input[type=password]');
        const change_password_type = document.querySelector('button[type=button]');

        change_password_type.addEventListener('click', () => {
            if (password_input.type === 'password') {
                password_input.type = 'text';
                change_password_type.innerHTML =
                    `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16"><path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/></svg>`;
            } else {
                password_input.type = 'password';
                change_password_type.innerHTML =
                    `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" /><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" /></svg>`;
            }
        });

        @if (!empty(session('error')))
            errorAlert("{{ session('error') }}");
        @endif
    </script>
</x-empty-layout>
