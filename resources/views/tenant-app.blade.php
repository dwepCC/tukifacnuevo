<!DOCTYPE html>
@php
    $path = explode('/', request()->path());
    $path[1] = (array_key_exists(1, $path) > 0) ? $path[1] : '';
    $path[2] = (array_key_exists(2, $path) > 0) ? $path[2] : '';
    $path[0] = ($path[0] === '') ? 'documents' : $path[0];
@endphp
<html lang="es" class="h-full sidebar-light sidebar-left-big-icons">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="googlebot" content="noindex">
    <meta name="robots" content="noindex">

    <title inertia>{{ config('app.name', 'TUKIFAC - Facturación Electrónica') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('porto-ecommerce/assets/font-awesome/css/fontawesome-all.min.css') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.29/sweetalert2.min.css" />

    <style>
        @media (min-width: 768px) {
            html:not(.sidebar-collapsed) #sidebar-left { width: 16rem; }
            html.sidebar-collapsed #sidebar-left { width: 4rem; }
            html.sidebar-collapsed #sidebar-left .sidebar-text { display: none; }
            html.sidebar-collapsed #sidebar-left .sidebar-icon { margin-right: 0; }
            html.sidebar-collapsed #sidebar-left .sidebar-logo-full { display: none; }
            html.sidebar-collapsed #sidebar-left .sidebar-logo-mini { display: inline-block; }
            html:not(.sidebar-collapsed) #sidebar-left .sidebar-logo-mini { display: none; }
        }
        @media (max-width: 767px) {
            #sidebar-left {
                transform: translateX(-100%);
            }
            html.sidebar-open #sidebar-left {
                transform: translateX(0);
            }
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
<body class="h-full bg-gray-100 pr-0">
    @inertia
</body>
</html>

