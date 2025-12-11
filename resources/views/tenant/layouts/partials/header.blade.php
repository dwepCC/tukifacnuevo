    <header id="tenant-header" class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 shadow-md tenant-header h-16">
        <div class="flex items-center justify-between h-full px-4">
            <!-- Contenido del Header -->
            <div class="flex-1">
    <div class="flex items-center justify-between px-4 py-3 md:py-0 h-16 md:h-20 gap-4">
        <!-- Left Section: Menu Toggles -->
        <div class="flex items-center gap-4">
            <!-- Sidebar Toggle -->
            <button class="sidebar-toggle-btn hidden md:flex items-center justify-center w-10 h-10 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                data-toggle-class="sidebar-left-collapsed"
                data-target="html"
                data-fire-event="sidebar-left-toggle">
                <i class="fas fa-bars text-gray-600 text-lg" aria-label="Toggle"></i>
            </button>
            
            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle md:hidden flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                data-toggle-class="sidebar-left-opened"
                data-target="html"
                data-fire-event="sidebar-left-opened">
                <div class="w-6 h-6 flex items-center justify-center">
                    <i class="fas fa-bars text-gray-700 text-[20px]"></i>
                </div>
                <span class="text-sm font-medium text-gray-700">Módulos</span>
            </button>
        </div>

        <!-- Center Section: Logo and Ads -->
        <div class="flex items-center justify-center flex-1">
            <div class="logo-container-mobile md:hidden">
                <a href="{{route('tenant.dashboard.index')}}" class="inline-flex items-center">
                    <img src="{{ asset('logo/Tukifac-large-ver-2.webp') }}" alt="Tukifac Logo" 
                        class="h-10 md:h-12 w-auto max-w-[180px] object-contain" />
                </a>
            </div>

            <!-- Ads (Desktop) -->
            @if ($tenant_show_ads && $url_tenant_image_ads)
                <div class="hidden lg:block mx-6">
                    <img src="{{$url_tenant_image_ads}}" class="max-h-12 max-w-md object-contain">
                </div>
            @endif
        </div>

        <!-- Right Section: Actions and User Menu -->
        <div class="flex items-center gap-3">
            <!-- Quick Actions (Desktop) -->
            <div class="hidden lg:flex items-center gap-2 ml-2">
                <a href="/documents/create" 
                   class="flex items-center gap-2 px-3 py-2 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 transition-colors duration-200"
                   title="Nuevo comprobante" 
                   data-toggle="tooltip">
                    <i class="fas fa-file-alt text-[18px]"></i>
                    <span class="text-sm font-medium">NC</span>
                </a>
                
                <a href="/sale-notes" 
                   class="flex items-center gap-2 px-3 py-2 rounded-lg bg-green-50 hover:bg-green-100 text-green-700 transition-colors duration-200"
                   title="Notas de Venta" 
                   data-toggle="tooltip">
                    <i class="fas fa-book text-[18px]"></i>
                    <span class="text-sm font-medium">NV</span>
                </a>

                <a href="/pos" 
                   class="flex items-center gap-2 px-3 py-2 rounded-lg bg-purple-50 hover:bg-purple-100 text-purple-700 transition-colors duration-200"
                   title="Punto de venta" 
                   data-toggle="tooltip">
                    <i class="fas fa-shopping-cart text-[18px]"></i>
                    <span class="text-sm font-medium">POS</span>
                </a>
            </div>

            <!-- Payment Status Card -->
            <div class="hidden lg:block payment-status-card bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 rounded-xl p-3 min-w-[280px]">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <span class="text-sm font-semibold text-gray-800" id="plan_name">Plan: Cargando...</span>
                        <span id="days_indicator" class="text-xs font-medium ml-2"></span>
                    </div>
                    <span class="px-2 py-1 rounded-full text-xs font-semibold" id="status_plan">Cargando...</span>
                </div>
                <div class="text-sm text-gray-600 mb-1">
                    Fecha de pago: <span class="font-medium text-gray-800" id="payment_date">Cargando...</span>
                </div>
                <div class="card-content" id="cardContent"></div>
            </div>

            <!-- Notifications and System Indicators -->
            <div class="flex items-center gap-2">
                <!-- Support WhatsApp -->
                <ul class="notifications flex items-center gap-2">
                    <li class="lt-soporte">
                        <a target="_blank" href="https://wa.me/51916996847" 
                           class="flex items-center gap-1.5 bg-green-600 hover:bg-green-700 rounded-lg px-3 py-1.5 text-white text-sm font-medium transition-colors duration-200">
                            <i class="fab fa-whatsapp"></i>
                            <span>Soporte</span>
                        </a>
                    </li>
                </ul>

                <!-- System Mode Indicator -->
                @php
                    $is_pse = $vc_company->send_document_to_pse;
                    $environment = 'SUNAT';
                    $is_ose = ($vc_company->soap_send_id === '02') ? true : false;
                    if ($is_pse) { $environment = 'PSE'; }
                    if ($is_ose) { $environment = 'OSE'; }
                    if ($is_ose && $is_pse) { $environment = 'OSE-PSE'; }
                    $productionClass = ($vc_company->soap_type_id == "02" && $is_ose) ? 'bg-green-600' : 'bg-blue-600';
                @endphp
                
                @if($vc_company->soap_type_id == "1")
                    <a href="@if(in_array('configuration', $vc_modules)){{route('tenant.companies.create')}}@else # @endif"
                       class="hidden md:flex flex-col items-center justify-center px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 rounded-lg text-white text-xs font-medium transition-colors duration-200"
                       data-toggle="tooltip"
                       title="Modo: DEMO - Conectado a {{ $environment }}">
                        <span class="font-bold">DEMO</span>
                        <span class="text-xs opacity-90">{{ $environment }}</span>
                    </a>
                @elseif($vc_company->soap_type_id == "02")
                    <a href="@if(in_array('configuration', $vc_modules)){{route('tenant.companies.create')}}@else # @endif"
                       class="hidden md:flex flex-col items-center justify-center px-3 py-1.5 {{ $productionClass }} hover:opacity-90 rounded-lg text-white text-xs font-medium transition-colors duration-200"
                       data-toggle="tooltip"
                       title="PRODUCCIÓN - Conectado a {{ $environment }}">
                        <span class="font-bold">PROD</span>
                        <span class="text-xs opacity-90">{{ $environment }}</span>
                    </a>
                @else
                    <a href="@if(in_array('configuration', $vc_modules)){{route('tenant.companies.create')}}@else # @endif"
                       class="hidden md:flex flex-col items-center justify-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-white text-xs font-medium transition-colors duration-200"
                       data-toggle="tooltip"
                       title="Modo: INTERNO - Conectado a SERVIDOR">
                        <span class="font-bold">INTERNO</span>
                        <span class="text-xs opacity-90">SERVIDOR</span>
                    </a>
                @endif

                <!-- Separator -->
                <span class="separator h-8 w-px bg-gray-300 mx-1 hidden md:block"></span>

                <!-- Notifications -->
                <ul class="notifications flex items-center gap-2">
                    @if($vc_document > 0)
                    <li>
                        <a href="{{route('tenant.documents.not_sent')}}" 
                           class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                           data-toggle="tooltip" 
                           title="Comprobantes no enviados">
                            <i class="fas fa-bell text-gray-600 text-[20px]"></i>
                            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ $vc_document }}
                            </span>
                        </a>
                    </li>
                    @endif

                    <li>
                        <a href="{{ route('tenant_orders_index') }}" 
                           class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                           data-toggle="tooltip" 
                           title="Pedidos pendientes">
                            <i class="fas fa-clipboard-list text-gray-600 text-[20px]"></i>
                            <span class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ $vc_orders }}
                            </span>
                        </a>
                    </li>

                    @if($vc_document_regularize_shipping > 0)
                    <li>
                        <a href="{{route('tenant.documents.regularize_shipping')}}" 
                           class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                           data-toggle="tooltip" 
                           title="Comprobantes pendientes de rectificación">
                            <i class="fas fa-exclamation-triangle text-yellow-600 text-lg"></i>
                            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ $vc_document_regularize_shipping }}
                            </span>
                        </a>
                    </li>
                    @endif

                    @if(in_array('reports', $vc_modules) && $vc_finished_downloads > 0)
                    <li>
                        <a href="{{route('tenant.reports.download-tray.index')}}" 
                           class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                           data-toggle="tooltip" 
                           title="Reportes procesados">
                            <i class="fas fa-file-download text-gray-600 text-lg"></i>
                            <span class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ $vc_finished_downloads }}
                            </span>
                        </a>
                    </li>
                    @endif
                </ul>

                <!-- Support Sidebar Toggle -->
                @inject('systemUser', 'App\Models\System\User')
                @php
                    $supportUser = $systemUser::first();
                    $hasSupportContact = $supportUser && ($supportUser->phone || $supportUser->whatsapp_number || $supportUser->address_contact);
                @endphp
                
                @if($hasSupportContact)
                <span class="separator h-8 w-px bg-gray-300 mx-1"></span>
                <ul class="notifications">
                    <li class="m-0">
                        <button onclick="toggleSupportSidebar()" 
                                class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                                title="Soporte" 
                                data-toggle="tooltip">
                            <i class="fas fa-headset text-gray-600 text-[20px]"></i>
                        </button>
                    </li>
                </ul>
                @endif

                <!-- User Profile -->
                <div id="userbox" class="relative">
                    <button class="user-profile-btn flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <div class="profile-info-pc hidden md:block text-right">
                            <span class="block text-sm font-medium text-gray-800">{{ $vc_user->name }}</span>
                            <span class="block text-xs text-gray-600 truncate max-w-[120px]">{{ $vc_user->email }}</span>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm">
                            @php
                                $userName = $vc_user->name;
                                $nameParts = explode(' ', trim($userName));
                                if (count($nameParts) >= 2) {
                                    $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1));
                                } else {
                                    $initials = strtoupper(substr($userName, 0, 2));
                                }
                            @endphp
                            {{ $initials }}
                        </div>
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="user-dropdown-menu absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50 hidden">
                        <!-- User Info -->
                        <div class="px-4 py-3 border-b border-gray-100">
                            <div class="text-sm font-medium text-gray-800">{{ $vc_user->name }}</div>
                            <div class="text-xs text-gray-600 truncate">{{ $vc_user->email }}</div>
                        </div>

                        <!-- Menu Items -->
                        <div class="py-2">
                            @if(in_array('users', $vc_module_levels))
                            <a href="{{route('tenant.users.index')}}" 
                               class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                </svg>
                                <span>Usuarios</span>
                            </a>
                            @endif

                            @if(in_array('users_establishments', $vc_module_levels))
                            <a href="{{route('tenant.establishments.index')}}" 
                               class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M11 6h9" />
                                    <path d="M11 12h9" />
                                    <path d="M12 18h8" />
                                    <path d="M4 16a2 2 0 1 1 4 0c0 .591 -.5 1 -1 1.5l-3 2.5h4" />
                                    <path d="M6 10v-6l-2 2" />
                                </svg>
                                <span>Sucursales & Series</span>
                            </a>
                            @endif

                            <a href="https://www.mediafire.com/file/0nngrr7hgmdrkvd/app-tukifac.apk/file"
                               class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" 
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M7 16.5l-5 -3l5 -3l5 3v5.5l-5 3z"></path>
                                    <path d="M2 13.5v5.5l5 3"></path>
                                    <path d="M7 16.545l5 -3.03"></path>
                                    <path d="M17 16.5l-5 -3l5 -3l5 3v5.5l-5 3z"></path>
                                    <path d="M12 19l5 3"></path>
                                    <path d="M17 16.5l5 -3"></path>
                                    <path d="M12 13.5v-5.5l-5 -3l5 -3l5 3v5.5"></path>
                                    <path d="M7 5.03v5.455"></path>
                                    <path d="M12 8l5 -3"></path>
                                </svg>
                                <span>APP Móvil</span>
                            </a>

                            @if(in_array('cuenta', $vc_modules) && in_array('account_users_list', $vc_module_levels))
                            <a href="{{route('tenant.payment.index')}}" 
                               class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-3 -2l-2 2l-2 -2l-2 2l-2 -2l-3 2" />
                                    <path d="M14.8 8a2 2 0 0 0 -1.8 -1h-2a2 2 0 1 0 0 4h2a2 2 0 1 1 0 4h-2a2 2 0 0 1 -1.8 -1" />
                                    <path d="M12 6v10" />
                                </svg>
                                <span>Mis Pagos</span>
                            </a>
                            @endif

                            @if(in_array('configuration', $vc_modules))
                            <a href="{{ url('list-settings') }}" 
                               class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                    <path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" />
                                    <path d="M12 12l0 .01" />
                                    <path d="M3 13a20 20 0 0 0 18 0" />
                                </svg>
                                <span>Configuraciones Globales</span>
                            </a>
                            @endif
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-100 my-2"></div>

                        <!-- Logout -->
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                <path d="M9 12h12l-3 -3" />
                                <path d="M18 15l3 -3" />
                            </svg>
                            <span>Cerrar Sesión</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Ads -->
    @if ($tenant_show_ads && $url_tenant_image_ads)
        <div class="lg:hidden border-t border-gray-100 px-4 py-2">
            <img src="{{$url_tenant_image_ads}}" class="max-h-12 w-full object-contain">
        </div>
    @endif
            </div>
        </div>
    </header>

<!-- Support Sidebar -->
@if($hasSupportContact)
<div id="supportSidebar" class="fixed inset-y-0 right-0 w-80 bg-white shadow-xl transform translate-x-full transition-transform duration-300 z-50">
    <div class="h-full flex flex-col">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white">
            <h3 class="text-lg font-semibold text-gray-800">Soporte al Cliente</h3>
            <button onclick="toggleSupportSidebar()" class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Body -->
        <div class="flex-1 overflow-y-auto p-6">
            @if($supportUser && $supportUser->introduction)
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <div class="text-sm text-gray-700">
                    {!! $supportUser->introduction !!}
                </div>
            </div>
            @endif

            <div class="space-y-4">
                @if($supportUser && $supportUser->whatsapp_number)
                <div class="flex items-start gap-4 p-4 border border-green-100 rounded-lg bg-green-50">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="fab fa-whatsapp text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-1">WhatsApp</h4>
                        <a href="https://wa.me/{{ $supportUser->whatsapp_number }}" 
                           target="_blank"
                           class="text-green-600 hover:text-green-700 font-medium text-lg">
                            {{ $supportUser->whatsapp_number }}
                        </a>
                        <p class="text-sm text-gray-600 mt-1">Soporte inmediato</p>
                    </div>
                </div>
                @endif

                @if($supportUser && $supportUser->phone)
                <div class="flex items-start gap-4 p-4 border border-orange-100 rounded-lg bg-orange-50">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center">
                        <i class="fas fa-phone text-orange-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-1">Teléfono</h4>
                        <a href="tel:{{ $supportUser->phone }}" 
                           class="text-orange-600 hover:text-orange-700 font-medium text-lg">
                            {{ $supportUser->phone }}
                        </a>
                        <p class="text-sm text-gray-600 mt-1">Llamada directa</p>
                    </div>
                </div>
                @endif

                @if($supportUser && $supportUser->address_contact)
                <div class="flex items-start gap-4 p-4 border border-blue-100 rounded-lg bg-blue-50">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-envelope text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-1">Correo Electrónico</h4>
                        <a href="mailto:{{ $supportUser->address_contact }}" 
                           target="_blank"
                           class="text-blue-600 hover:text-blue-700 font-medium text-lg">
                            {{ $supportUser->address_contact }}
                        </a>
                        <p class="text-sm text-gray-600 mt-1">Soporte por correo</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div id="supportBackdrop" 
     onclick="toggleSupportSidebar()"
     class="fixed inset-0 bg-black bg-opacity-50 hidden transition-opacity duration-300 z-40"></div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle user dropdown
    const userBtn = document.querySelector('.user-profile-btn');
    const userDropdown = document.querySelector('.user-dropdown-menu');
    
    if (userBtn && userDropdown) {
        userBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            userDropdown.classList.add('hidden');
        });

        userDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }

    // Toggle support sidebar
    window.toggleSupportSidebar = function() {
        const sidebar = document.getElementById('supportSidebar');
        const backdrop = document.getElementById('supportBackdrop');
        
        if (sidebar) {
            sidebar.classList.toggle('translate-x-full');
        }
        if (backdrop) {
            backdrop.classList.toggle('hidden');
        }
    }
});

// Payment status styles
function renderInfoPlan(data){
    if (data.success == true) {
        const statusElement = document.getElementById('status_plan');
        const daysIndicator = document.getElementById('days_indicator');
        
        // Clear previous classes
        statusElement.className = 'px-2 py-1 rounded-full text-xs font-semibold';
        daysIndicator.className = 'text-xs font-medium ml-2';
        
        if (data.days_overdue > 0) {
            statusElement.classList.add('bg-red-100', 'text-red-800');
            daysIndicator.classList.add('text-red-600');
            daysIndicator.textContent = data.days_overdue + ' día(s) de atraso';
            daysIndicator.style.display = 'inline';
        } else if (data.days_remaining > 0) {
            statusElement.classList.add('bg-yellow-100', 'text-yellow-800');
            daysIndicator.classList.add('text-yellow-600');
            daysIndicator.textContent = data.days_remaining + ' día(s) restantes';
            daysIndicator.style.display = 'inline';
        } else {
            if (data.has_pending_payment) {
                statusElement.classList.add('bg-yellow-100', 'text-yellow-800');
                daysIndicator.classList.add('text-yellow-600');
                daysIndicator.textContent = 'Fecha de pago hoy';
                daysIndicator.style.display = 'inline';
            } else {
                statusElement.classList.add('bg-green-100', 'text-green-800');
                daysIndicator.style.display = 'none';
            }
        }
        
        document.getElementById('plan_name').textContent = 'Plan: ' + data.plan_name;
        document.getElementById('payment_date').textContent = data.payment_date;
    }
}
</script>

<style>
/* Animation for status indicator */
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.payment-status-card {
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.1);
}

.user-dropdown-menu {
    animation: dropdownSlide 0.2s ease-out;
}

@keyframes dropdownSlide {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Mobile menu button animation */
.mobile-menu-toggle:active {
    transform: scale(0.95);
    transition: transform 0.1s;
}

/* Notification badge animation */
.notifications .relative span {
    animation: badgePop 0.3s ease-out;
}

@keyframes badgePop {
    0% { transform: scale(0); }
    70% { transform: scale(1.1); }
    100% { transform: scale(1); }
}
</style>
