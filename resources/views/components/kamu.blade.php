<div class="shadow-md rounded p-2 grid grid-cols-3 border border-blue-100 shadow-blue-100 relative">

    <div class="absolute -right-0 shadow rounded-bl-full top-0 bg-blue-600 text-white text-xs px-2 pl-5 py-1">
        Üniversite
    </div>

    <div class="col-span-1 flex items-center justify-center">
        <img src="{{ $logoUrl }}" class="w-full" alt="">
    </div>

    <div class="col-span-2 pt-5 px-2 flex flex-col justify-between">
        <a href="{{ encrypt($href) }}" class="inline-block text-sm">{{ $text }}</a>

        <ul class="flex gap-2 justify-end">
            <li>
                <a href="{{ $websiteUrl }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="size-4">
                        <path fill="#104E8B"
                            d="M177.8 63.2l10 17.4c2.8 4.8 4.2 10.3 4.2 15.9l0 41.4c0 3.9 1.6 7.7 4.3 10.4c6.2 6.2 16.5 5.7 22-1.2l13.6-17c4.7-5.9 12.9-7.7 19.6-4.3l15.2 7.6c3.4 1.7 7.2 2.6 11 2.6c6.5 0 12.8-2.6 17.4-7.2l3.9-3.9c2.9-2.9 7.3-3.6 11-1.8l29.2 14.6c7.8 3.9 12.6 11.8 12.6 20.5c0 10.5-7.1 19.6-17.3 22.2l-35.4 8.8c-7.4 1.8-15.1 1.5-22.4-.9l-32-10.7c-3.3-1.1-6.7-1.7-10.2-1.7c-7 0-13.8 2.3-19.4 6.5L176 212c-10.1 7.6-16 19.4-16 32l0 28c0 26.5 21.5 48 48 48l32 0c8.8 0 16 7.2 16 16l0 48c0 17.7 14.3 32 32 32c10.1 0 19.6-4.7 25.6-12.8l25.6-34.1c8.3-11.1 12.8-24.6 12.8-38.4l0-12.1c0-3.9 2.6-7.3 6.4-8.2l5.3-1.3c11.9-3 20.3-13.7 20.3-26c0-7.1-2.8-13.9-7.8-18.9l-33.5-33.5c-3.7-3.7-3.7-9.7 0-13.4c5.7-5.7 14.1-7.7 21.8-5.1l14.1 4.7c12.3 4.1 25.7-1.5 31.5-13c3.5-7 11.2-10.8 18.9-9.2l27.4 5.5C432 112.4 351.5 48 256 48c-27.7 0-54 5.4-78.2 15.2zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z" />
                    </svg>
                </a>
            </li>
            <li>
                <a href="{{ $instagramUrl }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="size-4">
                        <defs>
                          <linearGradient id="instagramGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#405DE6" />
                            <stop offset="10%" stop-color="#5851DB" />
                            <stop offset="20%" stop-color="#833AB4" />
                            <stop offset="30%" stop-color="#C13584" />
                            <stop offset="40%" stop-color="#E1306C" />
                            <stop offset="50%" stop-color="#FD1D1D" />
                            <stop offset="60%" stop-color="#F56040" />
                            <stop offset="70%" stop-color="#F77737" />
                            <stop offset="80%" stop-color="#FCAF45" />
                            <stop offset="90%" stop-color="#FFDC80" />
                            <stop offset="100%" stop-color="#FFDC80" />
                          </linearGradient>
                        </defs>
                        <path fill="url(#instagramGradient)"
                          d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/>
                      </svg>
                </a>
            </li>
            <li>
                <a href="{{ $xUrl }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="size-4">
                        <path fill="#000"
                            d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
                    </svg>
                </a>
            </li>
            <li>
                <a href="{{ $linkedinUrl }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="size-4">
                        <path fill="#0a66c2"
                            d="M100.3 448H7.4V148.9h92.9zM53.8 108.1C24.1 108.1 0 83.5 0 53.8a53.8 53.8 0 0 1 107.6 0c0 29.7-24.1 54.3-53.8 54.3zM447.9 448h-92.7V302.4c0-34.7-.7-79.2-48.3-79.2-48.3 0-55.7 37.7-55.7 76.7V448h-92.8V148.9h89.1v40.8h1.3c12.4-23.5 42.7-48.3 87.9-48.3 94 0 111.3 61.9 111.3 142.3V448z" />
                    </svg>
                </a>
            </li>
        </ul>
    </div>
</div>