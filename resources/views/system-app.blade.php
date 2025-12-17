<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="sidebar-light sidebar-left-big-icons dashboard-system">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="googlebot" content="noindex">
    <meta name="robots" content="noindex">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title inertia>{{ config('app.name', 'Facturación Electrónica') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.29/sweetalert2.min.css" />

    <style>
        .descarga { color:black; padding:5px; }
        ul.nav-main > li.nav-active > a {
            color: #1d4ed8;
            background-color: #eff6ff;
            border-radius: 0.375rem;
        }
        #sidebar-left::-webkit-scrollbar { width: 8px; }
        #sidebar-left::-webkit-scrollbar-track { background: transparent; }
        #sidebar-left::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }
        #sidebar-left::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        #sidebar-left { scrollbar-color: #cbd5e1 transparent; scrollbar-width: thin; }
    </style>

    @routes
    @vite(['resources/js/app-inertia.js'])
    @inertiaHead
    <script>
        window.Ziggy = @json($ziggy ?? []);
    </script>
</head>
<body class="pr-0">
    @inertia
</body>
</html>

