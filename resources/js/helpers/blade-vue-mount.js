/**
 * Helper para montar Vue 3 preservando contenido de Blade
 * 
 * En Vue 3, mount() reemplaza el contenido del elemento.
 * Esta función crea un componente raíz que compila el template del contenido
 * preservando los componentes Vue dentro.
 */
import { createApp, h } from 'vue'

export function mountVueAppWithBladeContent({
  app,
  elementId = 'main-wrapper',
  plugins = [],
  components = {},
  globalProperties = {}
}) {
  const mountApp = () => {
    const element = document.getElementById(elementId)
    if (!element) {
      setTimeout(mountApp, 100)
      return
    }

    const hasContent = element.children.length > 0 || element.innerHTML.trim().length > 0
    
    if (!hasContent) {
      setTimeout(mountApp, 100)
      return
    }

    // Guardar el contenido HTML original
    const originalHTML = element.innerHTML.trim()
    
    if (!originalHTML) {
      setTimeout(mountApp, 100)
      return
    }

    // Crear un componente raíz que compile el template
    // Usar template string con escape seguro
    const RootComponent = {
      template: `<div>${originalHTML.replace(/`/g, '\\`').replace(/\${/g, '\\${')}</div>`
    }

    // Crear nueva app con componente raíz
    const rootApp = createApp(RootComponent)

    // Aplicar plugins
    plugins.forEach(plugin => {
      if (typeof plugin === 'function') {
        rootApp.use(plugin)
      } else if (plugin.plugin && plugin.options) {
        rootApp.use(plugin.plugin, plugin.options)
      }
    })

    // Registrar componentes
    Object.keys(components).forEach(name => {
      rootApp.component(name, components[name])
    })

    // Copiar propiedades globales
    Object.keys(globalProperties).forEach(key => {
      rootApp.config.globalProperties[key] = globalProperties[key]
    })

    // Montar la nueva app
    rootApp.mount(`#${elementId}`)

    return rootApp
  }

  // Esperar a que el DOM esté listo
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', mountApp)
  } else {
    setTimeout(mountApp, 0)
  }

  return mountApp
}

