<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="sidebar-light sidebar-left-big-icons">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="googlebot" content="noindex">
    <meta name="robots" content="noindex">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Facturación Electrónica</title>

    @vite(['resources/js/app.js'])

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    



    <style>
        html{
            background-color: #fff;
        }

        .body-web {
            height: 100%;
            background-color: #fff;
        }
        #main-wrapper {
            height: 100%;
        }
        /* .row {
            height: 100%;
            justify-content: center;
            align-items: center;
        } */
    </style>
</head>
<body class="body-web">
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @yield('content')
            </div>
        </div>
    </div>

    {{--@stack('scripts')--}}

    @yield('content-mercadopago')

    
</body>
</html>
