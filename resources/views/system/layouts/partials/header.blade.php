<header class="w-full bg-white border-b shadow-sm" style="left:0;">
    <div class="m-2 flex items-center justify-between px-4 h-16">
        @php
            use App\Models\System\Configuration;
            $configuration = Configuration::first();
            $logo = $configuration->login->logo ?? null;
        @endphp
        @if ($logo)
            <a href="{{ route('system.dashboard') }}" class="logo pt-2 pt-md-0">
                <img class="uk-logo-inverse" width="100" height="auto" src="{{ $logo }}" alt="Logo" />
            </a>
        @elseif (file_exists(public_path('theme/logo.svg')))
            <a href="{{ route('system.dashboard') }}" class="logo pt-2 pt-md-0">
                <img class="uk-logo-inverse" width="100" height="auto" src="{{ asset('theme/logo.svg') }}" alt="Logo" />
            </a>
        @else
            <a href="{{ route('system.dashboard') }}" class="text-logo pt-md-0">
                PANEL RESELLER
            </a>
        @endif
        <div class="md:hidden inline-flex items-center justify-center" data-toggle-class="sidebar-left-opened" data-target="html"
            data-fire-event="sidebar-left-opened">
            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>
    <!-- start: search & user box -->
    <div class="flex items-center gap-3 ml-auto px-4">
        <div class="flex items-center justify-center mr-4">
            <a class="inline-flex items-center rounded-md border border-blue-600 text-blue-600 hover:bg-blue-50 text-sm px-2 py-1 mr-2" href="https://manual.uio.la/Pro7/Actualizaciones/2025/7.2" target="_BLANK">🎉 Versión 7.2</a>
            <a class="inline-flex items-center justify-center rounded-md bg-gray-900 text-white text-sm px-2 py-1" href="https://manual.uio.la/Pro7" target="_BLANK">
                <span>Manual</span>
                <svg  xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-book ms-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6l0 13" /><path d="M12 6l0 13" /><path d="M21 6l0 13" /></svg>                
            </a>
        </div>
        <span class="mx-2 w-px h-6 bg-gray-200"></span>
        <div id="userbox" class="userbox dropdown">
            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <figure class="profile-picture">
                    {{-- <img src="{{asset('img/%21logged-user.jpg')}}" alt="Joseph Doe" class="rounded-circle"
                        data-lock-picture="img/%21logged-user.jpg" /> --}}
                    <div class="border rounded-circle text-center bg-transparent" style="border: none !important">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="32"  height="32"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" /></svg>
                    </i>
                    </div>
                </figure>
                <div class="profile-info" data-lock-name="{{ \Auth::getUser()->email }}"
                    data-lock-email="{{ \Auth::getUser()->email }}">
                    <span class="name">{{ \Auth::getUser()->name }}</span>
                    <span class="role">{{ \Auth::getUser()->email }}</span>
                </div>
                <i class="fa custom-caret"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-admin">
                <ul class="list-unstyled mb-0">
                    <li>
                        <a class="dropdown-item" role="menuitem" href="{{ route('system.users.create') }}">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="18"  height="18"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                            Perfil
                        </a>
                        <a class="dropdown-item" role="menuitem" href="#" onclick="toggleThemeSidebar()">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="18"  height="18"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-paint"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" /><path d="M19 6h1a2 2 0 0 1 2 2a5 5 0 0 1 -5 5l-5 0v2" /><path d="M10 15m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" /></svg>
                            Estilos y Temas</a>
                        <a class="dropdown-item" role="menuitem" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="18"  height="18"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-logout"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" /><path d="M9 12h12l-3 -3" /><path d="M18 15l3 -3" /></svg>
                            @lang('app.buttons.logout')
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end: search & user box -->

    
</header>
