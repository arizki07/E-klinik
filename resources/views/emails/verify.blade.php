<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
</head>

<body>
    <h1>Hello, {{ $user->name }}!</h1>
    <p>Please click the link below to verify your email address:</p>
    <a href="{{ $url }}">Verify Email</a>
    <p>If you did not create an account, no further action is required.</p>
</body>

</html>
