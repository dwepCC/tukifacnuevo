/**
 * Helpers de compatibilidad para Vue 3
 * Facilita la migración gradual de Vue 2 a Vue 3
 */

import { getCurrentInstance } from 'vue'
import mitt from 'mitt'

/**
 * Obtener instancia de Vue 3 (reemplaza this.$ en Composition API)
 */
export function useVueInstance() {
  const instance = getCurrentInstance()
  if (!instance) {
    throw new Error('useVueInstance debe usarse dentro de setup()')
  }
  return instance.appContext.config.globalProperties
}

/**
 * Event Bus compatible con Vue 3
 * Reemplaza: new Vue() para event bus
 */
export const eventBus = mitt()

/**
 * Helper para acceder a $message de Element Plus
 * Uso: const message = useMessage(); message.success('Mensaje')
 */
export function useMessage() {
  try {
    const instance = getCurrentInstance()
    if (instance) {
      return instance.appContext.config.globalProperties.$message
    }
  } catch (e) {
    // Si no está en setup(), retornar null
    console.warn('useMessage debe usarse dentro de setup()')
  }
  return null
}

/**
 * Helper para acceder a $notify de Element Plus
 */
export function useNotify() {
  try {
    const instance = getCurrentInstance()
    if (instance) {
      return instance.appContext.config.globalProperties.$notify
    }
  } catch (e) {
    console.warn('useNotify debe usarse dentro de setup()')
  }
  return null
}

/**
 * Helper para acceder a $confirm de Element Plus
 */
export function useConfirm() {
  try {
    const instance = getCurrentInstance()
    if (instance) {
      return instance.appContext.config.globalProperties.$confirm
    }
  } catch (e) {
    console.warn('useConfirm debe usarse dentro de setup()')
  }
  return null
}

/**
 * Helper para acceder a $loading de Element Plus
 */
export function useLoading() {
  try {
    const instance = getCurrentInstance()
    if (instance) {
      return instance.appContext.config.globalProperties.$loading
    }
  } catch (e) {
    console.warn('useLoading debe usarse dentro de setup()')
  }
  return null
}
