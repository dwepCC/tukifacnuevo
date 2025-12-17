/**
 * App principal - Migrado a Vue 3
 * Reemplaza resources/js/app.js (Vue 2)
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
import '../css/icons/font-awesome/css/fontawesome-all.css'
import '../sass/element-ui.scss'

// Store
import { useMainStore } from './stores/main'

// Event Bus
import { eventBus } from './helpers/compat'

// Composables (reemplazan mixins globales)
import { useGlobalFilters } from './composables/useGlobalFilters'
import { useGlobalMethods } from './composables/useGlobalMethods'

// Componentes tenant
import { registerTenantComponents } from './tenant-components'

// DOM fixes
import {
  applyThemeAndShowContent,
  setupHeaderDomEvents,
  setupEcommerceAuthHandlers,
  updateTenantPageTitle
} from './tenant/dom-fixes'

// Inicializar app
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

// Global properties (reemplaza Vue.prototype)
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

// Global filters y methods (para compatibilidad durante migración)
const filters = useGlobalFilters()
const methods = useGlobalMethods()

// Hacer disponibles globalmente para componentes Options API durante migración
app.config.globalProperties.$filters = filters
app.config.globalProperties.$methods = methods

// Registrar componentes tenant
registerTenantComponents(app)

// Montar app - Estrategia para Vue 3 con Blade
// En Vue 3, mount() reemplaza el contenido del elemento
// Solución: Crear un componente raíz que compile el template del contenido preservado
const mountApp = () => {
  const mainWrapper = document.getElementById('main-wrapper')
  if (!mainWrapper) {
    setTimeout(mountApp, 100)
    return
  }

  const hasContent = mainWrapper.children.length > 0 || mainWrapper.innerHTML.trim().length > 0
  
  if (!hasContent) {
    setTimeout(mountApp, 100)
    return
  }

  // Guardar el contenido HTML original
  const originalHTML = mainWrapper.innerHTML.trim()
  
  if (!originalHTML) {
    setTimeout(mountApp, 100)
    return
  }

  console.log('[Vue 3] Montando app tenant con contenido de Blade:', {
    hasContent: hasContent,
    htmlLength: originalHTML.length,
    hasVueComponents: originalHTML.includes('system-') || originalHTML.includes('tenant-')
  })

  // Crear un componente raíz que compile el template
  // Escapar caracteres especiales para evitar errores de sintaxis
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

  // Registrar componentes tenant
  registerTenantComponents(rootApp)

  // Copiar propiedades globales
  rootApp.config.globalProperties.$clipboard = app.config.globalProperties.$clipboard
  rootApp.config.globalProperties.$eventHub = app.config.globalProperties.$eventHub
  rootApp.config.globalProperties.$http = app.config.globalProperties.$http
  rootApp.config.globalProperties.$setStorage = app.config.globalProperties.$setStorage
  rootApp.config.globalProperties.$getStorage = app.config.globalProperties.$getStorage
  rootApp.config.globalProperties.$store = app.config.globalProperties.$store
  rootApp.config.globalProperties.$filters = app.config.globalProperties.$filters
  rootApp.config.globalProperties.$methods = app.config.globalProperties.$methods

  try {
    // Montar la nueva app
    rootApp.mount('#main-wrapper')
    console.log('[Vue 3] App tenant montada correctamente')
    
    // Inicializar configuración del store
    const store = useMainStore()
    store.loadConfiguration()
  } catch (error) {
    console.error('[Vue 3] Error al montar app tenant:', error)
    console.error('[Vue 3] HTML original:', originalHTML.substring(0, 500))
  }
}

// Esperar a que el DOM esté completamente cargado
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', mountApp)
} else {
  // DOM ya está listo, pero esperar un tick para que Blade renderice el contenido
  setTimeout(mountApp, 0)
}

// Inicializar DOM fixes
if (window && window.vc_visual && window.vc_visual.sidebar_theme) {
  applyThemeAndShowContent(window.vc_visual.sidebar_theme)
}
setupHeaderDomEvents()
setupEcommerceAuthHandlers()
updateTenantPageTitle()

export default app
