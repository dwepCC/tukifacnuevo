/**
 * Adapter temporal para compatibilidad con código Vue 2 / Vuex
 * Permite usar el store de Pinia con la sintaxis de Vuex durante la migración gradual
 * 
 * USO TEMPORAL: Solo durante la migración. Eliminar cuando todo esté migrado.
 */

import { useMainStore } from './main'
import { storeToRefs } from 'pinia'

/**
 * Adapter que simula la API de Vuex para facilitar migración gradual
 * 
 * @example
 * // En lugar de:
 * import { mapState, mapActions } from 'vuex'
 * 
 * // Usar:
 * import { useVuexAdapter } from '@/stores/vuex-adapter'
 * const { state, dispatch, commit } = useVuexAdapter()
 */
export function useVuexAdapter() {
  const store = useMainStore()
  
  // Crear adapter que simula Vuex
  const adapter = {
    // State - reactivo usando storeToRefs
    get state() {
      return storeToRefs(store)
    },
    
    // Dispatch - mapea a actions de Pinia
    dispatch(action, payload) {
      if (typeof store[action] === 'function') {
        return store[action](payload)
      }
      console.warn(`Action "${action}" no encontrada en el store`)
      return Promise.resolve()
    },
    
    // Commit - mapea a actions de Pinia (en Pinia no hay mutations separadas)
    commit(mutation, payload) {
      // En Pinia, las mutations son actions
      if (typeof store[mutation] === 'function') {
        return store[mutation](payload)
      }
      console.warn(`Mutation "${mutation}" no encontrada en el store`)
    },
    
    // Getters - acceso directo al store
    getters: new Proxy({}, {
      get(target, prop) {
        return store[prop]
      }
    }),
    
    // Acceso directo al store de Pinia
    piniaStore: store
  }
  
  return adapter
}

/**
 * Helper para usar en componentes Options API durante migración
 * 
 * @example
 * export default {
 *   setup() {
 *     const { state, dispatch, commit } = useVuexAdapter()
 *     return { state, dispatch, commit }
 *   }
 * }
 */
export function mapState(keys) {
  // Lazy evaluation para evitar errores cuando Pinia no está inicializado
  // Si no se pasan keys, retornar todas las propiedades del store
  if (!keys || keys.length === 0) {
    try {
      const store = useMainStore()
      const refs = storeToRefs(store)
      
      return Object.keys(refs).reduce((acc, key) => {
        acc[key] = function() {
          try {
            const store = useMainStore()
            return store[key]
          } catch (error) {
            if (error.message && error.message.includes('active Pinia')) {
              console.warn(`Pinia no está inicializado aún para la propiedad "${key}"`)
              return undefined
            }
            throw error
          }
        }
        return acc
      }, {})
    } catch (error) {
      if (error.message && error.message.includes('active Pinia')) {
        console.warn('Pinia no está inicializado aún. mapState retornará funciones que esperan a Pinia.')
        return {}
      }
      throw error
    }
  }
  
  // Si se pasan keys específicas
  return keys.reduce((acc, key) => {
    acc[key] = function() {
      try {
        const store = useMainStore()
        return store[key]
      } catch (error) {
        if (error.message && error.message.includes('active Pinia')) {
          console.warn(`Pinia no está inicializado aún para la propiedad "${key}"`)
          return undefined
        }
        throw error
      }
    }
    return acc
  }, {})
}

/**
 * Helper para mapear actions (similar a mapActions de Vuex)
 * 
 * @param {string[]} actions - Array de nombres de actions
 * @returns {Object} Objeto con métodos mapeados
 * 
 * @example
 * export default {
 *   setup() {
 *     const actions = mapActions(['loadConfiguration', 'setCustomers'])
 *     return { ...actions }
 *   }
 * }
 */
export function mapActions(actions) {
  // Lazy evaluation: solo acceder al store cuando se invoque el método
  // Esto permite que mapActions se llame antes de que Pinia esté inicializado
  return actions.reduce((acc, action) => {
    acc[action] = function(...args) {
      try {
        const store = useMainStore()
        if (typeof store[action] === 'function') {
          return store[action](...args)
        } else {
          console.warn(`Action "${action}" no encontrada en el store`)
          return Promise.resolve()
        }
      } catch (error) {
        // Si Pinia no está inicializado, esperar un poco y reintentar
        if (error.message && error.message.includes('active Pinia')) {
          console.warn(`Pinia no está inicializado aún. La action "${action}" se ejecutará cuando Pinia esté listo.`)
          // Retornar una promesa que se resuelve cuando Pinia esté listo
          return new Promise((resolve) => {
            const checkPinia = setInterval(() => {
              try {
                const store = useMainStore()
                if (typeof store[action] === 'function') {
                  clearInterval(checkPinia)
                  resolve(store[action](...args))
                }
              } catch (e) {
                // Seguir esperando
              }
            }, 50)
            // Timeout después de 5 segundos
            setTimeout(() => {
              clearInterval(checkPinia)
              console.error(`Timeout esperando Pinia para action "${action}"`)
              resolve()
            }, 5000)
          })
        }
        throw error
      }
    }
    return acc
  }, {})
}

/**
 * Helper para mapear mutations (en Pinia son actions)
 * 
 * @param {string[]} mutations - Array de nombres de mutations
 * @returns {Object} Objeto con métodos mapeados
 */
export function mapMutations(mutations) {
  // Lazy evaluation para evitar errores cuando Pinia no está inicializado
  return mutations.reduce((acc, mutation) => {
    acc[mutation] = function(...args) {
      try {
        const store = useMainStore()
        if (typeof store[mutation] === 'function') {
          return store[mutation](...args)
        } else {
          console.warn(`Mutation "${mutation}" no encontrada en el store`)
        }
      } catch (error) {
        if (error.message && error.message.includes('active Pinia')) {
          console.warn(`Pinia no está inicializado aún. La mutation "${mutation}" se ejecutará cuando Pinia esté listo.`)
        } else {
          throw error
        }
      }
    }
    return acc
  }, {})
}

/**
 * Helper para mapear getters (acceso directo al state)
 * 
 * @param {string[]} getters - Array de nombres de propiedades del state
 * @returns {Object} Objeto con computed properties
 */
export function mapGetters(getters) {
  // Lazy evaluation para evitar errores cuando Pinia no está inicializado
  return getters.reduce((acc, getter) => {
    acc[getter] = function() {
      try {
        const store = useMainStore()
        const refs = storeToRefs(store)
        if (refs[getter]) {
          return refs[getter].value
        } else {
          console.warn(`Getter "${getter}" no encontrado`)
          return undefined
        }
      } catch (error) {
        if (error.message && error.message.includes('active Pinia')) {
          console.warn(`Pinia no está inicializado aún. El getter "${getter}" retornará undefined.`)
          return undefined
        }
        throw error
      }
    }
    return acc
  }, {})
}

