<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://consent.cookiefirst.com/sites/sbyetransformacion.com-49a24baf-ead2-477d-9354-8b26d36f77bc
    /consent.js"></script>
    @vite(['resources/js/app.js'])
    @routes
    @inertiaHead
</head>

<body>
    @inertia
</body>

</html>
