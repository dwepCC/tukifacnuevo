<!DOCTYPE html>
@php
    $path = explode('/', request()->path());
    $path[1] = (array_key_exists(1, $path) > 0) ? $path[1] : '';
    $path[2] = (array_key_exists(2, $path) > 0) ? $path[2] : '';
    $path[0] = ($path[0] === '') ? 'documents' : $path[0];
    $visual->sidebar_theme = property_exists($visual, 'sidebar_theme') ? $visual->sidebar_theme : ''
@endphp
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TUKIFAC - Facturación Electrónica</title>
    <meta name="googlebot" content="noindex">
    <meta name="robots" content="noindex">

    <script>
        window.vc_visual = window.vc_visual || {};
        window.vc_visual.sidebar_theme = @json($visual->sidebar_theme);
    </script>

    @vite(['resources/css/tailwind.css','resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('porto-ecommerce/assets/font-awesome/css/fontawesome-all.min.css') }}">

    @stack('styles')

    <script src="{{ asset('porto-light/vendor/modernizr/modernizr.js') }}"></script>

    <style>
        @media (min-width: 768px) {
            html:not(.sidebar-collapsed) #sidebar-left { width: 16rem; }
            html.sidebar-collapsed #sidebar-left { width: 4rem; }
            html.sidebar-collapsed #sidebar-left .sidebar-text { display: none; }
            html.sidebar-collapsed #sidebar-left .sidebar-icon { margin-right: 0; }
            html.sidebar-collapsed #sidebar-left .sidebar-logo-full { display: none; }
            html.sidebar-collapsed #sidebar-left .sidebar-logo-mini { display: inline-block; }
            html:not(.sidebar-collapsed) #sidebar-left .sidebar-logo-mini { display: none; }
            html:not(.sidebar-collapsed) #main-content { margin-left: 16rem !important; }
            html.sidebar-collapsed #main-content { margin-left: 4rem !important; }
            html:not(.sidebar-collapsed) #tenant-header { margin-left: 16rem !important; }
            html.sidebar-collapsed #tenant-header { margin-left: 4rem !important; }
        }
        @media (max-width: 767px) {
            #sidebar-left {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                width: 16rem;
                transform: translateX(-100%);
                transition: transform 0.2s ease;
                z-index: 40;
            }
            html.sidebar-open #sidebar-left { transform: translateX(0); }
            html.sidebar-open, html.options-user-mobile-opened { overflow: hidden !important; }
        }
        #sidebar-left::-webkit-scrollbar { width: 8px; }
        #sidebar-left::-webkit-scrollbar-track { background: transparent; }
        #sidebar-left::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }
        #sidebar-left::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        #sidebar-left { scrollbar-color: #cbd5e1 transparent; scrollbar-width: thin; }
    </style>

    @if ($vc_company->favicon)
        <link rel="shortcut icon" type="image/png" href="{{ asset($vc_company->favicon) }}" />
    @endif
</head>

<body class="h-full bg-gray-100">
    <!-- Spinner de carga global TUKIFAC -->
    {{--<div id="global-loader" class="global-loader">
        <div class="loader-content">
            <img src="{{ asset('storage/tuki-load.webp') }}" alt="TUKIFAC" class="loader-image">
            <p class="">Cargando...</p>
        </div>
    </div>--}}

    <!-- Layout Principal -->
<div class="min-h-screen flex flex-col">
    <!-- Sidebar - Ahora ocupa toda la altura desde arriba -->
    <aside id="sidebar-left" class="fixed left-0 top-0 h-screen bg-white text-gray-900 border-r border-gray-200 flex flex-col transition-all duration-300 w-64 z-40 overflow-y-auto">
        @include('tenant.layouts.partials.sidebar')
    </aside>
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/40 z-30 hidden md:hidden"></div>

    <!-- Header Fijo - Ahora comienza después del sidebar -->
                @include('tenant.layouts.partials.header')

    <!-- Contenido Principal -->
    <main id="main-content" class="flex-1 overflow-auto transition-all duration-300 pt-16">
        <div class="content-body p-4 min-h-[calc(100vh-4rem)]">
            @yield('content')
        </div>
    </main>
</div>

    @stack('scripts')
    @include('tenant.layouts.partials.check_last_password_update')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const htmlEl = document.documentElement;
            const sidebar = document.getElementById('sidebar-left');
            const toggleButton = document.getElementById('sidebar-toggle');
            const headerToggleBtn = document.querySelector('.sidebar-toggle-btn');
            const mobileMenuBtn = document.querySelector('.mobile-menu-toggle');
            const mobileCloseBtn = document.querySelector('#sidebar-left .sidebar-close-btn');
            const openers = document.querySelectorAll('[data-toggle-class="sidebar-left-opened"]');

            function isDesktop(){ return window.matchMedia('(min-width: 768px)').matches; }
            function applyTooltips(collapsed){
                if (collapsed) {
                    document.querySelectorAll('#sidebar-left a').forEach((a)=>{
                        const textEl = a.querySelector('.sidebar-text');
                        const txt = textEl ? textEl.textContent.trim() : '';
                        if (txt) a.setAttribute('title', txt);
                    });
                } else {
                    document.querySelectorAll('#sidebar-left a[title]').forEach((a)=> a.removeAttribute('title'));
                }
            }

            function toggleDesktop(){
                const collapsed = htmlEl.classList.toggle('sidebar-collapsed');
                localStorage.setItem('sidebarCollapsed', collapsed ? 'true' : 'false');
                applyTooltips(collapsed);
            }
            function toggleMobile(){
                const opened = htmlEl.classList.toggle('sidebar-open');
                if (opened) {
                    const overlay = document.getElementById('sidebar-overlay');
                    if (overlay) {
                        overlay.classList.remove('hidden');
                        overlay.addEventListener('click', function(){ htmlEl.classList.remove('sidebar-open'); overlay.classList.add('hidden'); }, { once: true });
                    }
                }
            }
            function outsideClose(e){
                const sidebarEl = document.getElementById('sidebar-left');
                const overlay = document.getElementById('sidebar-overlay');
                if (sidebarEl && !sidebarEl.contains(e.target)){
                    htmlEl.classList.remove('sidebar-open');
                    if (overlay) overlay.classList.add('hidden');
                }
            }

            if (toggleButton) {
                toggleButton.addEventListener('click', function(){
                    if (isDesktop()) toggleDesktop(); else toggleMobile();
                });
            }
            if (headerToggleBtn) {
                headerToggleBtn.addEventListener('click', function(e){
                    e.preventDefault();
                    if (isDesktop()) toggleDesktop(); else toggleMobile();
                });
            }
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function(e){ e.preventDefault(); toggleMobile(); });
            }
            if (mobileCloseBtn) {
                mobileCloseBtn.addEventListener('click', function(e){ 
                    e.preventDefault(); 
                    htmlEl.classList.remove('sidebar-open'); 
                    const overlay = document.getElementById('sidebar-overlay');
                    if (overlay) overlay.classList.add('hidden');
                });
            }
            if (openers && openers.length) {
                openers.forEach(function(btn){
                    btn.addEventListener('click', function(e){ e.preventDefault(); toggleMobile(); });
                });
            }

            document.querySelectorAll('#sidebar-left nav ul > li > a').forEach(function(anchor){
                const next = anchor.nextElementSibling;
                if (next && next.tagName === 'UL'){
                    anchor.classList.add('menu-collapse');
                    anchor.setAttribute('aria-expanded','false');
                    next.classList.add('submenu','hidden');
                    const chevron = document.createElement('i');
                    chevron.className = 'fas fa-chevron-down ml-auto text-gray-500 text-xs';
                    anchor.appendChild(chevron);
                    const hasActive = next.querySelector('.bg-blue-50');
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

            // Cargar estado guardado en desktop
            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true' && isDesktop()) {
                htmlEl.classList.add('sidebar-collapsed');
                applyTooltips(true);
            }

            // Control del spinner global
            const globalLoader = document.getElementById('global-loader');
            window.addEventListener('load', function() {
                setTimeout(() => {
                    if(globalLoader) {
                        globalLoader.style.opacity = '0';
                        setTimeout(() => {
                            globalLoader.remove();
                        }, 300);
                    }
                }, 500);
            });

            // Función global para mostrar/ocultar spinner
            window.showLoader = function(show = true) {
                let loader = document.getElementById('global-loader');
                
                if (!loader && show) {
                    loader = document.createElement('div');
                    loader.id = 'global-loader';
                    loader.className = 'global-loader';
                    loader.innerHTML = `
                        <div class="loader-content">
                            <img src="{{ asset('img/tukifac-logo-loader.png') }}" alt="TUKIFAC" class="loader-image">
                            <p class="mt-2">Procesando TUKIFAC...</p>
                        </div>
                    `;
                    document.body.prepend(loader);
                }
                
                if (loader) {
                    loader.style.display = show ? 'flex' : 'none';
                }
            };
        });

        // Manejo de dropdown de notificaciones
        $(document).ready(function () {
            $('#dropdown-notifications').click(function (e) {
                $('#dropdown-notifications').toggleClass('showed');
                $('#dn-toggle').toggleClass('show');
                $('#dn-menu').toggleClass('show');
                e.stopPropagation();
            });
        });

        $(document).click(function () {
            $('#dropdown-notifications').removeClass('showed');
            $('#dn-toggle').removeClass('show');
            $('#dn-menu').removeClass('show');
        });
    </script>
</body>
</html>
