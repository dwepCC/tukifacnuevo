/**
 * App principal con Inertia.js y Vue 3
 * Reemplaza resources/js/app.js y resources/js/system.js para usar Inertia
 * Ya no se trabaja con Blade, todo se maneja con Vue 3 + Inertia.js
 */
import './bootstrap'
import { axios } from './bootstrap'

import { createApp, h } from 'vue'
import { createPinia } from 'pinia'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from 'ziggy-js'
import { InertiaProgress } from '@inertiajs/progress'

// Element Plus - Full Import (según documentación oficial)
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import 'element-plus/theme-chalk/dark/css-vars.css'
import locale from 'element-plus/dist/locale/es.mjs'

// CSS
import '../css/tailwind.css'
import '../css/icons/font-awesome/css/fontawesome-all.css'
import '../sass/element-ui.scss'

// Store
import { useMainStore } from './stores/main'

// Event Bus
import { eventBus } from './helpers/compat'

// Composables
import { useGlobalFilters } from './composables/useGlobalFilters'
import { useGlobalMethods } from './composables/useGlobalMethods'

// Componentes tenant
import { registerTenantComponents } from './tenant-components'

// Componentes system
import SystemHeader from '@/components/system/SystemHeader.vue'
import SystemSidebar from '@/components/system/SystemSidebar.vue'

// Componentes system adicionales (para uso global si es necesario)
import SystemSupportConfiguration from './views/system/configuration/supportConfiguration.vue'
import SystemConfigurationQrApi from './views/system/configuration/qrApiConfiguration.vue'
import SystemClientsIndex from './views/system/clients/index.vue'
import SystemClientsForm from './views/system/clients/form.vue'
import SystemUsersform from './views/system/users/form.vue'
import SystemUsersTokenUser from './views/system/users/token-user.vue'
import SystemCertificateIndex from './views/system/certificate/index.vue'
import SystemCompaniesForm from './views/system/companies/form.vue'
import SystemAccountingIndex from '@viewsModuleAccount/system/accounting/index.vue'
import SystemMultiUsersIndex from '@viewsModuleMultiUser/system/multi-users/index.vue'
import SystemMassiveInvoiceIndex from './views/system/massive_invoice/index.vue'
import SystemUpdateIndex from './views/system/update/index.vue'
import SystemBackupIndex from './views/system/backup/index.vue'
import SystemConfigurationCulqui from './views/system/configuration/culqi.vue'
import SystemConfigurationApkUrl from './views/system/configuration/apk-url.vue'
import SystemConfigurationTokenRucDni from './views/system/configuration/token_ruc_dni.vue'
import SystemConfigurationPhpInfo from './views/system/configuration/php_info.vue'
import SystemConfigurationServerStatus from './views/system/configuration/server_status.vue'
import SystemConfigurationLogin from './views/system/configuration/login.vue'
import SystemConfigurationOtherConfiguration from './views/system/configuration/other_configuration.vue'
import SystemConfigurationEmail from './views/system/configuration/emailConfiguration.vue'
import SystemReportLoginLockout from '@viewsModuleReport/system/report_login_lockout/index.vue'
import SystemUserNotChangePassword from '@viewsModuleReport/system/user_not_change_password/index.vue'
import SystemPlansIndex from './views/system/plans/index.vue'
import SystemPlansForm from './views/system/plans/form.vue'
import SystemConfigurationCronOrderPayments from './views/system/configuration/cronOrderPayments.vue'
import SystemPaymentsIndex from './views/system/payments/index.vue'
// InputService se importa y registra en tenant-components.js, no aquí

// Configurar progress bar de Inertia
InertiaProgress.init({
  color: '#4B5563',
  showSpinner: true,
})

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    // Crear app de Vue
    const app = createApp({ render: () => h(App, props) })

    // Plugins
    app.use(plugin)
    app.use(createPinia())
    // Element Plus - Full Import (según documentación oficial)
    app.use(ElementPlus, {
      locale,
      size: 'small'
    })
    
    // Ziggy para rutas de Laravel
    // window.Ziggy se inyecta desde la vista Blade mediante @routes
    try {
      if (window.Ziggy && Object.keys(window.Ziggy).length > 0) {
        app.use(ZiggyVue, window.Ziggy)
      } else {
        // Intentar importar desde el archivo local si window.Ziggy no está disponible
        import('./ziggy.js').then(({ Ziggy }) => {
          app.use(ZiggyVue, Ziggy)
        }).catch(() => {
          console.warn('Ziggy no está disponible. Las funciones route() pueden no funcionar.')
        })
      }
    } catch (error) {
      console.warn('Error al configurar Ziggy:', error)
    }

    // Global properties - Event Bus con métodos compatibles con Vue 2
    app.config.globalProperties.$eventHub = {
      $on: eventBus.on.bind(eventBus),
      $emit: eventBus.emit.bind(eventBus),
      $off: eventBus.off.bind(eventBus),
      // También exportar métodos directos de mitt
      on: eventBus.on.bind(eventBus),
      emit: eventBus.emit.bind(eventBus),
      off: eventBus.off.bind(eventBus),
    }

    // Axios y utilidades de almacenamiento
    app.config.globalProperties.$http = axios
    app.config.globalProperties.$setStorage = function(name, obj) {
      localStorage.setItem(name, JSON.stringify(obj))
    }
    app.config.globalProperties.$getStorage = function(name) {
      const item = localStorage.getItem(name)
      return item ? JSON.parse(item) : null
    }

    // Clipboard
    app.config.globalProperties.$clipboard = {
      async copy(text) {
        try {
          const { useClipboard } = await import('vue-clipboard3')
          const { copy } = useClipboard()
          await copy(text)
          return true
        } catch (error) {
          console.error('Error al copiar al portapapeles:', error)
          return false
        }
      }
    }

    // Store adapter para compatibilidad con Vuex (Options API)
    const storeInstance = useMainStore()
    app.config.globalProperties.$store = {
      commit(mutation, payload) {
        if (typeof storeInstance[mutation] === 'function') {
          return storeInstance[mutation](payload)
        }
        console.warn(`Mutation "${mutation}" no encontrada en el store`)
      },
      dispatch(action, payload) {
        if (typeof storeInstance[action] === 'function') {
          return storeInstance[action](payload)
        }
        console.warn(`Action "${action}" no encontrada en el store`)
        return Promise.resolve()
      },
      get state() {
        return storeInstance
      },
      get getters() {
        return storeInstance
      }
    }

    // Global filters y methods
    const filters = useGlobalFilters()
    const methods = useGlobalMethods()
    app.config.globalProperties.$filters = filters
    app.config.globalProperties.$methods = methods

    // Registrar componentes tenant
    registerTenantComponents(app)

    // Registrar componentes system globalmente
    app.component('SystemHeader', SystemHeader)
    app.component('SystemSidebar', SystemSidebar)
    app.component('system-support-configuration', SystemSupportConfiguration)
    app.component('system-clients-index', SystemClientsIndex)
    app.component('system-qrapi-configuration', SystemConfigurationQrApi)
    app.component('system-clients-form', SystemClientsForm)
    app.component('system-users-form', SystemUsersform)
    app.component('system-users-token-user', SystemUsersTokenUser)
    app.component('system-certificate-index', SystemCertificateIndex)
    app.component('system-companies-form', SystemCompaniesForm)
    app.component('system-accounting-index', SystemAccountingIndex)
    app.component('system-multi-users-index', SystemMultiUsersIndex)
    app.component('system-massive-invoice-index', SystemMassiveInvoiceIndex)
    app.component('system-update', SystemUpdateIndex)
    app.component('system-backup', SystemBackupIndex)
    app.component('system-configuration-culqi', SystemConfigurationCulqui)
    app.component('system-configuration-apk-url', SystemConfigurationApkUrl)
    app.component('system-configuration-token', SystemConfigurationTokenRucDni)
    app.component('system-php-configuration', SystemConfigurationPhpInfo)
    app.component('system-server-status', SystemConfigurationServerStatus)
    app.component('system-login-settings', SystemConfigurationLogin)
    app.component('system-login-other-configuration', SystemConfigurationOtherConfiguration)
    app.component('system-email-configuration', SystemConfigurationEmail)
    app.component('system-report-login-lockout-index', SystemReportLoginLockout)
    app.component('system-user-not-change-password-index', SystemUserNotChangePassword)
    app.component('system-plans-index', SystemPlansIndex)
    app.component('system-plans-form', SystemPlansForm)
    app.component('system-payments-index', SystemPaymentsIndex)
    app.component('system-cron-order-configuration', SystemConfigurationCronOrderPayments)
    // x-input-service ya se registra en registerTenantComponents(), no duplicar aquí

    // Montar app
    app.mount(el)

    // Inicializar configuración del store
    const store = useMainStore()
    store.loadConfiguration()
  },
})