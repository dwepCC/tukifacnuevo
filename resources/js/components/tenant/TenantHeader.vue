<template>
  <header 
    id="tenant-header" 
    :class="[
      'fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 shadow-md h-16 transition-all duration-300',
      isSidebarCollapsed ? 'md:ml-16' : 'md:ml-64'
    ]"
  >
    <div class="flex items-center justify-between h-full px-4">
      <div class="flex-1">
        <div class="flex items-center justify-between px-4 py-3 md:py-0 h-16 md:h-20 gap-4">
          <!-- Left Section: Menu Toggles -->
          <div class="flex items-center gap-4">
            <!-- Sidebar Toggle (Desktop) -->
            <button 
              @click="$emit('toggle-sidebar')"
              class="md:flex items-center justify-center w-10 h-10 rounded-lg hover:bg-gray-100 transition-colors duration-200"
              aria-label="Toggle sidebar"
            >
              <i class="fas fa-bars text-gray-600 text-lg"></i>
            </button>
            
            <!-- Mobile Menu Toggle -->
            <button 
              @click="$emit('toggle-sidebar')"
              class="md:hidden flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
            >
              <div class="w-6 h-6 flex items-center justify-center">
                <i class="fas fa-bars text-gray-700 text-[20px]"></i>
              </div>
              <span class="text-sm font-medium text-gray-700">Módulos</span>
            </button>
          </div>

          <!-- Center Section: Logo and Ads -->
          <div class="flex items-center justify-center flex-1">
            <!-- Logo Mobile -->
            <div class="logo-container-mobile md:hidden">
              <Link :href="route('tenant.dashboard.index')" class="inline-flex items-center">
                <img 
                  src="/logo/Tukifac-large-ver-2.webp" 
                  alt="Tukifac Logo" 
                  class="h-10 md:h-12 w-auto max-w-[180px] object-contain" 
                />
              </Link>
            </div>

            <!-- Ads (Desktop) -->
            <div v-if="tenantShowAds && urlTenantImageAds" class="lg:block mx-6">
              <img :src="urlTenantImageAds" class="max-h-12 max-w-md object-contain" alt="Ads" />
            </div>
          </div>

          <!-- Right Section: Actions and User Menu -->
          <div class="flex items-center gap-3">
            <!-- Quick Actions (Desktop) -->
            <div class="lg:flex items-center gap-2 ml-2">
              <Link 
                href="/documents/create" 
                class="flex items-center gap-2 px-3 py-2 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 transition-colors duration-200"
                title="Nuevo comprobante"
              >
                <i class="fas fa-file-alt text-[18px]"></i>
                <span class="text-sm font-medium">NC</span>
              </Link>
              
              <Link 
                href="/sale-notes" 
                class="flex items-center gap-2 px-3 py-2 rounded-lg bg-green-50 hover:bg-green-100 text-green-700 transition-colors duration-200"
                title="Notas de Venta"
              >
                <i class="fas fa-book text-[18px]"></i>
                <span class="text-sm font-medium">NV</span>
              </Link>

              <Link 
                href="/pos" 
                class="flex items-center gap-2 px-3 py-2 rounded-lg bg-purple-50 hover:bg-purple-100 text-purple-700 transition-colors duration-200"
                title="Punto de venta"
              >
                <i class="fas fa-shopping-cart text-[18px]"></i>
                <span class="text-sm font-medium">POS</span>
              </Link>
            </div>

            <!-- Payment Status Card -->
            <div class=" lg:block payment-status-card bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 rounded-xl p-3 min-w-[280px]">
              <div class="flex justify-between items-start mb-2">
                <div>
                  <span class="text-sm font-semibold text-gray-800">{{ planName }}</span>
                  <span v-if="daysIndicator" :class="['text-xs font-medium ml-2', daysIndicatorClass]">
                    {{ daysIndicator }}
                  </span>
                </div>
                <span :class="['px-2 py-1 rounded-full text-xs font-semibold', statusPlanClass]">
                  {{ statusPlan }}
                </span>
              </div>
              <div class="text-sm text-gray-600 mb-1">
                Fecha de pago: <span class="font-medium text-gray-800">{{ paymentDate }}</span>
              </div>
              <div class="card-content" v-html="cardContent"></div>
            </div>

            <!-- Notifications and System Indicators -->
            <div class="flex items-center gap-2">
              <!-- Support WhatsApp -->
              <ul class="notifications flex items-center gap-2">
                <li class="lt-soporte">
                  <a 
                    target="_blank" 
                    href="https://wa.me/51916996847" 
                    rel="noopener noreferrer"
                    class="flex items-center gap-1.5 bg-green-600 hover:bg-green-700 rounded-lg px-3 py-1.5 text-white text-sm font-medium transition-colors duration-200"
                  >
                    <i class="fab fa-whatsapp"></i>
                    <span>Soporte</span>
                  </a>
                </li>
              </ul>

              <!-- System Mode Indicator -->
              <Link
                v-if="hasModule('configuration')"
                :href="route('tenant.companies.create')"
                :class="[
                  'md:flex flex-col items-center justify-center px-3 py-1.5 rounded-lg text-white text-xs font-medium transition-colors duration-200',
                  systemModeClass
                ]"
                :title="systemModeTitle"
              >
                <span class="font-bold">{{ systemModeLabel }}</span>
                <span class="text-xs opacity-90">{{ systemEnvironment }}</span>
              </Link>
              <a
                v-else
                href="#"
                :class="[
                  'md:flex flex-col items-center justify-center px-3 py-1.5 rounded-lg text-white text-xs font-medium transition-colors duration-200',
                  systemModeClass
                ]"
                :title="systemModeTitle"
              >
                <span class="font-bold">{{ systemModeLabel }}</span>
                <span class="text-xs opacity-90">{{ systemEnvironment }}</span>
              </a>

              <!-- Separator -->
              <span class="separator h-8 w-px bg-gray-300 mx-1 md:block"></span>

              <!-- Notifications -->
              <ul class="notifications flex items-center gap-2">
                <li v-if="vcDocument > 0">
                  <Link 
                    :href="route('tenant.documents.not_sent')"
                    class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                    title="Comprobantes no enviados"
                  >
                    <i class="fas fa-bell text-gray-600 text-[20px]"></i>
                    <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                      {{ vcDocument }}
                    </span>
                  </Link>
                </li>

                <li>
                  <Link 
                    :href="route('tenant_orders_index')"
                    class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                    title="Pedidos pendientes"
                  >
                    <i class="fas fa-clipboard-list text-gray-600 text-[20px]"></i>
                    <span class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                      {{ vcOrders }}
                    </span>
                  </Link>
                </li>

                <li v-if="vcDocumentRegularizeShipping > 0">
                  <Link 
                    :href="route('tenant.documents.regularize_shipping')"
                    class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                    title="Comprobantes pendientes de rectificación"
                  >
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-lg"></i>
                    <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                      {{ vcDocumentRegularizeShipping }}
                    </span>
                  </Link>
                </li>

                <li v-if="hasModule('reports') && vcFinishedDownloads > 0">
                  <Link 
                    :href="route('tenant.reports.download-tray.index')"
                    class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                    title="Reportes procesados"
                  >
                    <i class="fas fa-file-download text-gray-600 text-lg"></i>
                    <span class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                      {{ vcFinishedDownloads }}
                    </span>
                  </Link>
                </li>
              </ul>

              <!-- Support Sidebar Toggle -->
              <template v-if="hasSupportContact">
                <span class="separator h-8 w-px bg-gray-300 mx-1"></span>
                <ul class="notifications">
                  <li class="m-0">
                    <button 
                      @click="toggleSupportSidebar"
                      class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                      title="Soporte"
                    >
                      <i class="fas fa-headset text-gray-600 text-[20px]"></i>
                    </button>
                  </li>
                </ul>
              </template>

              <!-- User Profile -->
              <div class="relative" ref="userMenuRef">
                <button 
                  @click="toggleUserMenu"
                  class="user-profile-btn flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                >
                  <div class="profile-info-pc  md:block text-right">
                    <span class="block text-sm font-medium text-gray-800">{{ user?.name }}</span>
                    <span class="block text-xs text-gray-600 truncate max-w-[120px]">{{ user?.email }}</span>
                  </div>
                  <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm">
                    {{ userInitials }}
                  </div>
                </button>

                <!-- Dropdown Menu -->
                <div 
                  v-show="isUserMenuOpen"
                  class="user-dropdown-menu absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50"
                  @click.stop
                >
                  <!-- User Info -->
                  <div class="px-4 py-3 border-b border-gray-100">
                    <div class="text-sm font-medium text-gray-800">{{ user?.name }}</div>
                    <div class="text-xs text-gray-600 truncate">{{ user?.email }}</div>
                  </div>

                  <!-- Menu Items -->
                  <div class="py-2">
                    <Link 
                      v-if="hasModuleLevel('users')"
                      :href="route('tenant.users.index')"
                      class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                      </svg>
                      <span>Usuarios</span>
                    </Link>

                    <Link 
                      v-if="hasModuleLevel('users_establishments')"
                      :href="route('tenant.establishments.index')"
                      class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M11 6h9" />
                        <path d="M11 12h9" />
                        <path d="M12 18h8" />
                        <path d="M4 16a2 2 0 1 1 4 0c0 .591 -.5 1 -1 1.5l-3 2.5h4" />
                        <path d="M6 10v-6l-2 2" />
                      </svg>
                      <span>Sucursales & Series</span>
                    </Link>

                    <a 
                      href="https://www.mediafire.com/file/0nngrr7hgmdrkvd/app-tukifac.apk/file"
                      target="_blank"
                      rel="noopener noreferrer"
                      class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

                    <Link 
                      v-if="hasModule('cuenta') && hasModuleLevel('account_users_list')"
                      :href="route('tenant.payment.index')"
                      class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-3 -2l-2 2l-2 -2l-2 2l-2 -2l-3 2" />
                        <path d="M14.8 8a2 2 0 0 0 -1.8 -1h-2a2 2 0 1 0 0 4h2a2 2 0 1 1 0 4h-2a2 2 0 0 1 -1.8 -1" />
                        <path d="M12 6v10" />
                      </svg>
                      <span>Mis Pagos</span>
                    </Link>

                    <Link 
                      v-if="hasModule('configuration')"
                      href="/list-settings"
                      class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                        <path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" />
                        <path d="M12 12l0 .01" />
                        <path d="M3 13a20 20 0 0 0 18 0" />
                      </svg>
                      <span>Configuraciones Globales</span>
                    </Link>
                  </div>

                  <!-- Divider -->
                  <div class="border-t border-gray-100 my-2"></div>

                  <!-- Logout -->
                  <form :action="route('logout')" method="POST" @submit.prevent="handleLogout">
                    <button 
                      type="submit"
                      class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200 text-left"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                        <path d="M9 12h12l-3 -3" />
                        <path d="M18 15l3 -3" />
                      </svg>
                      <span>Cerrar Sesión</span>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Mobile Ads -->
        <div v-if="tenantShowAds && urlTenantImageAds" class="lg:hidden border-t border-gray-100 px-4 py-2">
          <img :src="urlTenantImageAds" class="max-h-12 w-full object-contain" alt="Ads" />
        </div>
      </div>
    </div>

    <!-- Support Sidebar -->
    <SupportSidebar v-if="hasSupportContact" :is-open="isSupportSidebarOpen" @close="closeSupportSidebar" />
  </header>
</template>

<script setup>
import { computed, ref, onMounted, onUnmounted } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import SupportSidebar from './partials/SupportSidebar.vue'

defineProps({
  isSidebarCollapsed: {
    type: Boolean,
    default: false
  }
})

defineEmits(['toggle-sidebar'])

const page = usePage()

// Datos del tenant
const modules = computed(() => page.props.vc_modules || [])
const moduleLevels = computed(() => page.props.vc_module_levels || [])
const company = computed(() => page.props.vc_company || {})
const tenantShowAds = computed(() => page.props.tenant_show_ads || false)
const urlTenantImageAds = computed(() => page.props.url_tenant_image_ads || null)
const user = computed(() => page.props.vc_user || page.props.auth?.user || {})
const vcDocument = computed(() => page.props.vc_document || 0)
const vcOrders = computed(() => page.props.vc_orders || 0)
const vcDocumentRegularizeShipping = computed(() => page.props.vc_document_regularize_shipping || 0)
const vcFinishedDownloads = computed(() => page.props.vc_finished_downloads || 0)

// Estado del menú de usuario
const isUserMenuOpen = ref(false)
const userMenuRef = ref(null)

// Estado del sidebar de soporte
const isSupportSidebarOpen = ref(false)

// Funciones de utilidad
const hasModule = (module) => modules.value.includes(module)
const hasModuleLevel = (level) => moduleLevels.value.includes(level)

// Iniciales del usuario
const userInitials = computed(() => {
  const userName = user.value?.name || ''
  const nameParts = userName.split(' ').filter(Boolean)
  if (nameParts.length >= 2) {
    return (nameParts[0][0] + nameParts[1][0]).toUpperCase()
  }
  return userName.substring(0, 2).toUpperCase()
})

// Información del plan de pago
const planName = ref('Plan: Cargando...')
const paymentDate = ref('Cargando...')
const statusPlan = ref('')
const daysIndicator = ref('')
const statusPlanClass = ref('px-2 py-1 rounded-full text-xs font-semibold')
const daysIndicatorClass = ref('text-xs font-medium ml-2')
const cardContent = ref('')

// Modo del sistema (DEMO/PROD/INTERNO)
const systemModeLabel = computed(() => {
  const soapTypeId = company.value?.soap_type_id
  if (soapTypeId === '1') return 'DEMO'
  if (soapTypeId === '02') return 'PROD'
  return 'INTERNO'
})

const systemEnvironment = computed(() => {
  const isPse = company.value?.send_document_to_pse
  const isOse = company.value?.soap_send_id === '02'
  let env = 'SUNAT'
  if (isPse) env = 'PSE'
  if (isOse) env = 'OSE'
  if (isOse && isPse) env = 'OSE-PSE'
  return env
})

const systemModeClass = computed(() => {
  const soapTypeId = company.value?.soap_type_id
  if (soapTypeId === '1') return 'bg-yellow-500 hover:bg-yellow-600'
  if (soapTypeId === '02') {
    const isOse = company.value?.soap_send_id === '02'
    return isOse ? 'bg-green-600 hover:opacity-90' : 'bg-blue-600 hover:opacity-90'
  }
  return 'bg-indigo-600 hover:bg-indigo-700'
})

const systemModeTitle = computed(() => {
  const soapTypeId = company.value?.soap_type_id
  const env = systemEnvironment.value
  if (soapTypeId === '1') return `Modo: DEMO - Conectado a ${env}`
  if (soapTypeId === '02') return `PRODUCCIÓN - Conectado a ${env}`
  return 'Modo: INTERNO - Conectado a SERVIDOR'
})

// Soporte
const hasSupportContact = computed(() => {
  // Esta información debería venir de las props compartidas
  // Por ahora retornamos false, se puede completar después
  return page.props.support_user && (
    page.props.support_user.phone || 
    page.props.support_user.whatsapp_number || 
    page.props.support_user.address_contact
  )
})

// Toggle menú de usuario
const toggleUserMenu = () => {
  isUserMenuOpen.value = !isUserMenuOpen.value
}

// Toggle sidebar de soporte
const toggleSupportSidebar = () => {
  isSupportSidebarOpen.value = !isSupportSidebarOpen.value
}

const closeSupportSidebar = () => {
  isSupportSidebarOpen.value = false
}

// Cerrar menú al hacer click fuera
const handleClickOutside = (event) => {
  if (userMenuRef.value && !userMenuRef.value.contains(event.target)) {
    isUserMenuOpen.value = false
  }
}

// Logout
const handleLogout = () => {
  router.post(route('logout'))
}

// Cargar información del plan de pago
const loadPaymentInfo = async () => {
  try {
    // Usar fetch directamente en lugar de $http
    const response = await fetch('/cuenta/info_plan', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      credentials: 'same-origin'
    })
    
    if (response.ok) {
      const result = await response.json()
      if (result.success) {
        const data = result
        planName.value = `Plan: ${data.plan_name}`
        paymentDate.value = data.payment_date
        
        // Limpiar clases anteriores
        statusPlanClass.value = 'px-2 py-1 rounded-full text-xs font-semibold'
        daysIndicatorClass.value = 'text-xs font-medium ml-2'
        
        if (data.days_overdue > 0) {
          statusPlan.value = 'Vencido'
          statusPlanClass.value = 'px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800'
          daysIndicatorClass.value = 'text-xs font-medium ml-2 text-red-600'
          daysIndicator.value = `${data.days_overdue} día(s) de atraso`
        } else if (data.days_remaining > 0) {
          statusPlan.value = 'Por vencer'
          statusPlanClass.value = 'px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800'
          daysIndicatorClass.value = 'text-xs font-medium ml-2 text-yellow-600'
          daysIndicator.value = `${data.days_remaining} día(s) restantes`
        } else {
          if (data.has_pending_payment) {
            statusPlan.value = 'Pendiente'
            statusPlanClass.value = 'px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800'
            daysIndicatorClass.value = 'text-xs font-medium ml-2 text-yellow-600'
            daysIndicator.value = 'Fecha de pago hoy'
          } else {
            statusPlan.value = 'Al día'
            statusPlanClass.value = 'px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800'
            daysIndicator.value = ''
          }
        }
      }
    }
  } catch (error) {
    console.error('Error loading payment info:', error)
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
  loadPaymentInfo()
  
  // Exponer función global para renderInfoPlan (compatibilidad con código legacy)
  window.renderInfoPlan = (data) => {
    if (data && data.success) {
      planName.value = `Plan: ${data.plan_name}`
      paymentDate.value = data.payment_date
      
      statusPlanClass.value = 'px-2 py-1 rounded-full text-xs font-semibold'
      daysIndicatorClass.value = 'text-xs font-medium ml-2'
      
        if (data.days_overdue > 0) {
          statusPlan.value = 'Vencido'
          statusPlanClass.value = 'px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800'
          daysIndicatorClass.value = 'text-xs font-medium ml-2 text-red-600'
          daysIndicator.value = `${data.days_overdue} día(s) de atraso`
        } else if (data.days_remaining > 0) {
          statusPlan.value = 'Por vencer'
          statusPlanClass.value = 'px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800'
          daysIndicatorClass.value = 'text-xs font-medium ml-2 text-yellow-600'
          daysIndicator.value = `${data.days_remaining} día(s) restantes`
        } else {
          if (data.has_pending_payment) {
            statusPlan.value = 'Pendiente'
            statusPlanClass.value = 'px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800'
            daysIndicatorClass.value = 'text-xs font-medium ml-2 text-yellow-600'
            daysIndicator.value = 'Fecha de pago hoy'
          } else {
            statusPlan.value = 'Al día'
            statusPlanClass.value = 'px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800'
            daysIndicator.value = ''
          }
        }
    }
  }
  
  // Exponer función global para toggleSupportSidebar (compatibilidad)
  window.toggleSupportSidebar = toggleSupportSidebar
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>


<style scoped>
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

.mobile-menu-toggle:active {
  transform: scale(0.95);
  transition: transform 0.1s;
}

.notifications .relative span {
  animation: badgePop 0.3s ease-out;
}

@keyframes badgePop {
  0% { transform: scale(0); }
  70% { transform: scale(1.1); }
  100% { transform: scale(1); }
}
</style>
