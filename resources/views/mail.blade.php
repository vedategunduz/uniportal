@component('mail::message')
# Merhaba!

Bu bir **örnek** Markdown maili.

@component('mail::button', ['url' => 'https://ornek.com'])
Butona Git
@endcomponent

Teşekkürler,<br>
{{ config('app.name') }}
@endcomponent
