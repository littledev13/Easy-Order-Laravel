<!-- resources/views/layouts/app.blade.php -->

<html>

<head>
    <title>@yield('title') | Easy Order</title>
    @vite('resources/js/tw-elements.umd.min.js')
    @vite('resources/css/app.css')
    @vite('resources/css/all.css')
</head>

<body>
    <div class="container mx-auto">
        @section('header')
        @show
        @yield('content')
    </div>
    @vite('resources/js/main.js')
</body>

</html>
