<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <h2>Registration</h2>
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <label for="username">Your name:</label>
        <input type="text" id="username" name="username" required>
        <br>

        <label for="phone_number">Your phone:</label>
        <input type="text" id="phone_number" name="phone_number" required>
        <br>

        <button type="submit">Register</button>
    </form>
</body>
</html>