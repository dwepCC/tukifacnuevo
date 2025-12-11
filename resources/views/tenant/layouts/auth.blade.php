@php
use Illuminate\Support\Facades\Storage;
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="googlebot" content="noindex">
    <meta name="robots" content="noindex">

    {{--    <title>{{ config('app.name', 'Facturación Electrónica') }}</title>--}}
    <title>{{ $vc_company->title_web }}</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/js/app.js'])

    

    {{-- @if (file_exists(public_path('theme/background/bkg_store.jpeg')))
        <style>
            .app{
                background: url('{{ asset('theme/background/bkg_store.jpeg') }}') center center / cover;
            }
        </style>
    @else
        <style>
            .app{
                background: url('{{ asset('porto-light/background/bkg_store.jpeg') }}') center center / cover;
            }
        </style>
    @endif --}}

</head>

<body>

    <div class="app">
        @yield('content')
    </div>

    @stack('scripts')
    <!-- <script src="//code.tidio.co/1vliqewz9v7tfosw5wxiktpkgblrws5w.js"></script> -->
</body>

</html>
