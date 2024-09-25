<!DOCTYPE html>
<html>

<head>
    <title>Verifikasi Akun</title>
</head>

<body>
    <p>Hello {{ $details['name'] }},</p>
    <p>Your OTP is: <strong>{{ $details['otp'] }}</strong></p>
    <p>This OTP will expire at {{ $details['expires_at'] }}.</p>

    <p>Terima kasih telah melakukan registrasi.</p>
</body>

</html>
