@props(['url'])
<tr>
    <td class="header">
        <a href="{{ route('main.index') }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="https://flowbite.com/docs/images/logo.svg" style="height: 2rem; margin-right: .75rem"
                    alt="Flowbite Logo" />
                <span class="text-2xl font-semibold whitespace-nowrap"
                    style="white-space: nowrap; font-weight: 600; font-size: 1.5rem; line-height: 2rem;">
                    {{ config('app.name') }}</span>
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
