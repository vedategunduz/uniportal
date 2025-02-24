<x-button type="button" class="open-aside-modal !shadow-none !border-0 message-notification" data-modal="aside-modal">
    <div class="relative">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="bi bi-chat-left-text-fill size-5" viewBox="0 0 16 16">
            <path
                d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793zm3.5 1a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1z" />
        </svg>
        <span
            class="absolute -top-1 -right-.5 scale-90 size-4 inline-flex items-center justify-center text-white bg-blue-700 rounded-full">
            {{ $count }}
        </span>
    </div>
</x-button>
