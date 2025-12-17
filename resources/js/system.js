/**
 * System app - Migrado a Vue 3
 * Reemplaza resources/js/system.js (Vue 2)
 */
import './bootstrap'
import { axios } from './bootstrap'

import { createApp, h } from 'vue'
import { createPinia } from 'pinia'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import 'element-plus/theme-chalk/dark/css-vars.css'
import locale from 'element-plus/dist/locale/es.mjs'

// CSS
import '../css/tailwind.css'
import '../sass/element-ui.scss'

// Store
import { useMainStore } from './stores/main'

// Event Bus
import { eventBus } from './helpers/compat'

// Composables
import { useGlobalFilters } from './composables/useGlobalFilters'
import { useGlobalMethods } from './composables/useGlobalMethods'

// System components
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

import InputService from '../../modules/ApiPeruDev/Resources/assets/js/components/InputService.vue'

// Inicializar app
// En Vue 3, cuando montamos una app vacía, reemplaza el contenido
// Usaremos una estrategia diferente para preservar el contenido de Blade
const app = createApp({})

// Plugins
app.use(createPinia())
app.use(ElementPlus, {
  locale,
  size: 'small'
})

// Clipboard - helper para uso desde Options API
// useClipboard es un composable, debe usarse dentro de setup()
// Para Options API, crear un helper que se puede usar en métodos
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

// Global properties
app.config.globalProperties.$eventHub = eventBus

// Axios y utilidades de almacenamiento (migrado desde bootstrap.js)
app.config.globalProperties.$http = axios

app.config.globalProperties.$setStorage = function(name, obj) {
    localStorage.setItem(name, JSON.stringify(obj))
}

app.config.globalProperties.$getStorage = function(name) {
    const item = localStorage.getItem(name)
    return item ? JSON.parse(item) : null
}

// Store adapter para compatibilidad con Vuex (Options API)
// Se crea un singleton del store para evitar múltiples instancias
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

// Registrar componentes system
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
app.component('x-input-service', InputService)

// Montar app - Estrategia para Vue 3 con Blade
// En Vue 3, mount() reemplaza el contenido del elemento
// Solución: Usar un componente raíz que compile el template de forma segura
const mountApp = () => {
  const mainWrapper = document.getElementById('main-wrapper')
  if (mainWrapper && mainWrapper.children.length > 0) {
    // Guardar el contenido HTML original
    const originalHTML = mainWrapper.innerHTML.trim()
    
    if (!originalHTML) {
      setTimeout(mountApp, 100)
      return
    }
    
    // Crear un componente raíz que compile el template
    // Escapar caracteres especiales para evitar errores de sintaxis en el template string
    const escapedHTML = originalHTML
      .replace(/`/g, '\\`')
      .replace(/\${/g, '\\${')
      .replace(/\\/g, '\\\\')
    
    const RootComponent = {
      template: `<div>${escapedHTML}</div>`
    }
    
    // Crear nueva app con componente raíz
    const rootApp = createApp(RootComponent)
    
    // Aplicar plugins
    rootApp.use(createPinia())
    rootApp.use(ElementPlus, { locale, size: 'small' })
    
    // Registrar todos los componentes system
    rootApp.component('system-support-configuration', SystemSupportConfiguration)
    rootApp.component('system-clients-index', SystemClientsIndex)
    rootApp.component('system-qrapi-configuration', SystemConfigurationQrApi)
    rootApp.component('system-clients-form', SystemClientsForm)
    rootApp.component('system-users-form', SystemUsersform)
    rootApp.component('system-users-token-user', SystemUsersTokenUser)
    rootApp.component('system-certificate-index', SystemCertificateIndex)
    rootApp.component('system-companies-form', SystemCompaniesForm)
    rootApp.component('system-accounting-index', SystemAccountingIndex)
    rootApp.component('system-multi-users-index', SystemMultiUsersIndex)
    rootApp.component('system-massive-invoice-index', SystemMassiveInvoiceIndex)
    rootApp.component('system-update', SystemUpdateIndex)
    rootApp.component('system-backup', SystemBackupIndex)
    rootApp.component('system-configuration-culqi', SystemConfigurationCulqui)
    rootApp.component('system-configuration-apk-url', SystemConfigurationApkUrl)
    rootApp.component('system-configuration-token', SystemConfigurationTokenRucDni)
    rootApp.component('system-php-configuration', SystemConfigurationPhpInfo)
    rootApp.component('system-server-status', SystemConfigurationServerStatus)
    rootApp.component('system-login-settings', SystemConfigurationLogin)
    rootApp.component('system-login-other-configuration', SystemConfigurationOtherConfiguration)
    rootApp.component('system-email-configuration', SystemConfigurationEmail)
    rootApp.component('system-report-login-lockout-index', SystemReportLoginLockout)
    rootApp.component('system-user-not-change-password-index', SystemUserNotChangePassword)
    rootApp.component('system-plans-index', SystemPlansIndex)
    rootApp.component('system-plans-form', SystemPlansForm)
    rootApp.component('system-payments-index', SystemPaymentsIndex)
    rootApp.component('system-cron-order-configuration', SystemConfigurationCronOrderPayments)
    rootApp.component('x-input-service', InputService)
    
    // Copiar propiedades globales
    rootApp.config.globalProperties.$clipboard = app.config.globalProperties.$clipboard
    rootApp.config.globalProperties.$eventHub = app.config.globalProperties.$eventHub
    rootApp.config.globalProperties.$http = app.config.globalProperties.$http
    rootApp.config.globalProperties.$setStorage = app.config.globalProperties.$setStorage
    rootApp.config.globalProperties.$getStorage = app.config.globalProperties.$getStorage
    rootApp.config.globalProperties.$store = app.config.globalProperties.$store
    rootApp.config.globalProperties.$filters = app.config.globalProperties.$filters
    rootApp.config.globalProperties.$methods = app.config.globalProperties.$methods
    
    // Montar la nueva app
    rootApp.mount('#main-wrapper')
    
    // Inicializar configuración del store
    const store = useMainStore()
    store.loadConfiguration()
  } else if (mainWrapper) {
    // El elemento existe pero aún no tiene contenido, esperar un poco más
    setTimeout(mountApp, 100)
  }
}

// Esperar a que el DOM esté completamente cargado
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', mountApp)
} else {
  // DOM ya está listo, pero esperar un tick para que Blade renderice
  setTimeout(mountApp, 100)
}

export default app
