<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <!--================= Meta tag =================-->
        <meta charset="utf-8">
        <title>@yield('title', 'Authentication') | ISM MINISTERS PRAYER NETWORK</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/fav.png') }}">
        
        <!--================= Bootstrap V5 css =================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <!--================= Elegant icon css  =================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/elegant-icon.css') }}">
        <!--================= style css =================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('style.css') }}">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

        @yield('customCSS')
    </head>

    <body style="margin: 0; padding: 0;">
        <main style="min-height: 100vh;">
            @yield('main')
        </main>

        <!--================= Jquery latest version =================-->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        
        @yield('customJS')
    </body>
</html>
