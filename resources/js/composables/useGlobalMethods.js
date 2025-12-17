/**
 * Composable para métodos globales
 * Reemplaza los métodos del mixin global de Vue 2
 * 
 * NOTA: Este composable está diseñado para usarse en app.js como globalProperties
 * Para uso en componentes, importar directamente los métodos necesarios
 */
import { ElMessage } from 'element-plus'

export function useGlobalMethods() {
  return {
    axiosError(error) {
      const response = error.response
      const status = response?.status
      
      if (status === 422) {
        // En Composition API, necesitas manejar errors de otra forma
        // Esto debería ser manejado en el componente
        console.error('Validation errors:', response.data)
        return response.data
      }
      
      if (status === 500) {
        ElMessage({
          type: 'error',
          message: response.data?.message || 'Error del servidor'
        })
      }
      
      return null
    },
    
    getResponseValidations(success = true, message = null) {
      return {
        success: success,
        message: message
      }
    },
    
    generalSleep(ms) {
      return new Promise(resolve => setTimeout(resolve, ms))
    }
  }
}
