<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>C0RE :: JUMP</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">

</head>
<body>
<div id="wrap">
    @include('layout.partials.navigation')

    <div class="container content">
        @yield('content')
    </div>
</div>

<script>
    window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'auth' => Auth::check()
    ]); ?>
</script>

<script src="{{ elixir('js/app.js') }}"></script>

</body>
</html>