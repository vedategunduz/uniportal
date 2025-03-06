@php
    use Carbon\Carbon;

    $tarihAraligi =
        Carbon::parse($etkinlik->etkinlikBaslamaTarihi)->translatedFormat('d M Y, H:i') .
        ' - ' .
        Carbon::parse($etkinlik->etkinlikBitisTarihi)->translatedFormat('d M Y, H:i');
    $tarihAraligi2 =
        Carbon::parse($etkinlik->etkinlikBasvuruBaslamaTarihi)->translatedFormat('d M Y, H:i') .
        ' - ' .
        Carbon::parse($etkinlik->etkinlikBasvuruBitisTarihi)->translatedFormat('d M Y, H:i');
@endphp

<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>

</head>

<body
    style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -webkit-text-size-adjust: none; background-color: #ffffff; color: #718096; height: 100%; line-height: 1.4; margin: 0; padding: 0; width: 100% !important;">

    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation"
        style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; background-color: #edf2f7; margin: 0; padding: 0; width: 100%;">
        <tr>
            <td align="center"
                style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
                <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation"
                    style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; margin: 0; padding: 0; width: 100%;">
                    <tr>
                        <td class="header"
                            style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; padding: 25px 0; text-align: center;">
                            <a href="{{ route('main.index') }}"
                                style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; color: #3d4852; font-size: 19px; font-weight: bold; text-decoration: none; display: inline-block;">
                                {{ config('app.name') }}
                            </a>
                        </td>
                    </tr>

                    <!-- Email Body -->
                    <tr>
                        <td class="body" width="100%" cellpadding="0" cellspacing="0"
                            style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; background-color: #edf2f7; border-bottom: 1px solid #edf2f7; border-top: 1px solid #edf2f7; margin: 0; padding: 0; width: 100%; border: hidden !important;">
                            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0"
                                role="presentation"
                                style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px; background-color: #ffffff; border-color: #e8e5ef; border-radius: 2px; border-width: 1px; box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015); margin: 0 auto; padding: 0; width: 570px;">
                                <!-- Body content -->
                                <tr>
                                    <td>
                                        <div style="text-align: center">
                                            <img src="{{ asset('image/etkinlik-katilim.png') }}"
                                                style="position: relative; max-width: 100%; height: 200px;"
                                                alt="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-cell"
                                        style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; max-width: 100vw; padding: 32px;">
                                        <h1
                                            style="color: #3d4852; font-size: 18px; font-weight: bold; margin-top: 0; text-align: left;">
                                            Merhaba, {{ $user->ad }}
                                            <span style="text-transform: uppercase">{{ $user->soyad }}</span>
                                        </h1>

                                        <p
                                            style="font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                            <strong>{{ $etkinlik->baslik }}</strong> etkinliğine {{ $kullanici->ad }}
                                            {{ $kullanici->soyad }} adına katılım tabebi oluşturulmuştur.
                                            Kişiye ait bilgiler aşağıda yer almaktadır.
                                        </p>

                                        <!-- Eklenen bilgiler -->
                                        <p
                                            style="font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                            <strong>Çalıştığı Kurum:</strong> {{ $kullanici->anaIsletme->baslik }}<br>
                                            <strong>Telefon Numarası:</strong> {{ $kullanici->telefon }}<br>
                                            <strong>E-Posta Adresi:</strong> {{ $kullanici->email }}<br><br>

                                            @if (!empty($aciklama))
                                                <strong>Not:</strong> {{ $aciklama }} <br><br>
                                            @endif

                                            Talebi <a
                                                href="{{ route('etkinlikler.detay', encrypt($etkinlik->etkinlikler_id)) }}">{{ config('app.name') }}</a>
                                            üzerinden inceleyebileyip cevaplayabilirsiniz.
                                        </p>

                                        <p
                                            style="font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left; word-wrap: break-word; max-width: 80%">
                                            Eğer bağlantıya tıklamada sorun yaşıyorsanız, aşağıdaki URL’yi tarayıcınızın
                                            adres çubuğuna kopyalayabilirsiniz:
                                            <br>
                                            <span
                                                style="color:#1a56db">{{ route('etkinlikler.detay', encrypt($etkinlik->etkinlikler_id)) }}
                                            </span>
                                        </p>

                                        <p
                                            style="font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                            Saygılarımla,<br>
                                            {{ config('app.name') }} Ekibi
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
                            <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0"
                                role="presentation"
                                style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px; margin: 0 auto; padding: 0; text-align: center; width: 570px;">
                                <tr>
                                    <td class="content-cell" align="center"
                                        style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; max-width: 100vw; padding: 32px;">
                                        <p
                                            style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; line-height: 1.5em; margin-top: 0; color: #b0adc5; font-size: 12px; text-align: center;">
                                            © 2025 {{ config('app.name') }}. Her hakkı saklıdır.</p>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
