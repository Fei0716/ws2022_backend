<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Portal</title>

    <link rel="stylesheet" href="{{URL('bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL('style.css')}}">
</head>
<body>
    @include('layout.nav')
    <div class="container">
        @yield('content')
    </div>
    <script src="{{URL('bootstrap/js/bootstrap.min.js')}}"></script>
    @yield('script')
</body>
</html>