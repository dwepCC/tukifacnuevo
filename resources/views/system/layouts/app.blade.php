<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="sidebar-light sidebar-left-big-icons dashboard-system">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="googlebot" content="noindex">
    <meta name="robots" content="noindex">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Facturación Electrónica</title>

    <!-- Scripts -->

    <!-- Fonts -->
    {{--<link rel="dns-prefetch" href="https://fonts.gstatic.com">--}}
    {{--<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">--}}


    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    

    {{--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.29/sweetalert2.min.css" />

    <!-- Specific Page Vendor CSS -->
    {{-- jQuery UI eliminado - usando Tailwind CSS --}}
    {{-- <link rel="stylesheet" href="{{asset('porto-light/vendor/jquery-ui/jquery-ui.css')}}" /> --}}
    {{-- <link rel="stylesheet" href="{{asset('porto-light/vendor/jquery-ui/jquery-ui.theme.css')}}" /> --}}
    

    <!-- Daterange picker plugins css -->
    

    {{-- jQuery Loading eliminado - usar alternativas modernas --}}
    {{-- <link rel="stylesheet" href="{{asset('porto-light/vendor/jquery-loading/dist/jquery.loading.css')}}" /> --}}

    @stack('styles')
    {{-- Modernizr eliminado - no necesario en navegadores modernos --}}
    {{-- <script src="{{ asset('porto-light/vendor/modernizr/modernizr.js') }}"></script> --}}

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
    <!-- vite aqui -->
    @vite(['resources/js/system.js'])
</head>
<body class="pr-0">
    <section class="body">
        <!-- start: header -->
        @include('system.layouts.partials.header')
        <!-- end: header -->
        <div class="inner-wrapper flex">
            <!-- start: sidebar -->
            @include('system.layouts.partials.sidebar')
            <!-- end: sidebar -->
            <section role="main" class="content-body flex-1 p-4" id="main-wrapper">
              @yield('content')
            </section>
        </div>
    </section>

    @stack('scripts')

    <script>
    document.addEventListener('DOMContentLoaded', function(){
        document.querySelectorAll('#sidebar-left nav ul > li > a').forEach(function(anchor){
            const next = anchor.nextElementSibling;
            if (next && next.tagName === 'UL'){
                anchor.classList.add('menu-collapse');
                anchor.setAttribute('aria-expanded','false');
                next.classList.add('submenu','hidden');
                const chevron = document.createElement('i');
                chevron.className = 'fas fa-chevron-down ml-auto text-gray-500 text-xs';
                anchor.appendChild(chevron);
                const hasActive = next.querySelector('li.nav-active');
                if (hasActive) {
                    next.classList.remove('hidden');
                    anchor.setAttribute('aria-expanded','true');
                    chevron.classList.add('rotate-180');
                }
                anchor.addEventListener('click', function(e){
                    e.preventDefault();
                    const isOpen = next.classList.toggle('hidden') === false;
                    anchor.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                    chevron.classList.toggle('rotate-180', isOpen);
                });
            }
        });
    });
    </script>

{{-- <?php echo config('app.limite_reseller'); ?> --}}
</body>

</html>
