<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>OGS</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        }
    </script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

    </style>

</head>

<body class="hold-transition sidebar-mini">
    <div class="" id="app">
        <router-view :key="$route.fullPath"></router-view>
        <vue-progress-bar></vue-progress-bar>
    </div>

    </div>
    @auth
        <script>
            window.user = @json(auth()->user())
        </script>
    @endauth
    <script src="{{ mix('/js/app.js') }}"></script>
</body>

</html>
