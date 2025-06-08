<!DOCTYPE html>
<html>

<head>
    <title>Restablecimiento de contraseña</title>
</head>

<body>
    <p>Hola,</p>
    <p>Hemos recibido una solicitud para restablecer la contraseña de su cuenta.</p>
    <p>Para ello utilize el siguiente token:</p>
    <span style="color: blue">{{ $token }}</span>
    <p>Si no ha solicitado este restablecimiento, ignore este mensaje.</p>
    <p>Gracias,<br>El equipo de {{ config('app.name') }}</p>
</body>

</html>
