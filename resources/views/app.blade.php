<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @auth()
        <meta name="authorisation" content="{{ json_encode([
            'login' => auth()->user()->login,
            'role' => roleName(),
            'info' => auth()->user()->userInfo,
            'permissions' => permissions(),
            'manager' => auth()->user()->manager(),
        ]) }}">
    @endauth
    <link rel="shortcut icon" href="/favicon.png" type="image/png">
    @vite('resources/js/app.js')
    <title>Sendis</title>
</head>

<body>
    <div id="app"></div>
</body>

</html>
