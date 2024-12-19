<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    {{ Session::get('roller_id') }}

    @foreach ($menuler as $menu)
        <a href="{{ $menu['menu_link'] }}">{!! $menu['menu_icon'] !!} {{ $menu['menu_adi'] }}</a>
    @endforeach
    
</body>

</html>
