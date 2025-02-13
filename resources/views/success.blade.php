<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Successful registration</title>
</head>
<body>
    <h2>Registration successful!</h2>
    <p>Your unique link: <a href="{{ request()->get('link') }}">{{ request()->get('link') }}</a></p>
</body>
</html>