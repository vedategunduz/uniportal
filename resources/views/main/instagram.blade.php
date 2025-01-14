<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <input type="text" name="text" id="instagram_text" value="Bu bir test mesajıdır.">
    <button type="button">Gönder</button>
    {{ csrf_token() }}
    <script>
        document.querySelector('button').addEventListener('click', function() {
            fetch('/postEt', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        caption: 'patates',
                        image_url: 'https://placehold.co/400'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Sonuç:', data);
                })
                .catch(error => {
                    console.error('Hata:', error);
                });
        });
    </script>

    {{-- <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId: '1145500797190184',
                xfbml: true,
                version: 'v21.0'
            });
        };
    </script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script> --}}

</body>

</html>
