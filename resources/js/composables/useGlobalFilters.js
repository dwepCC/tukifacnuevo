/**
 * Composable para filtros globales
 * Reemplaza los filters de Vue 2 que fueron removidos en Vue 3
 */
import moment from 'moment'

export function useGlobalFilters() {
  return {
    toDecimals(number, decimal = 2) {
      return Number(number).toFixed(decimal)
    },
    
    DecimalText(number, decimal = 2) {
      return isNaN(parseFloat(number)) ? number : Number(number).toFixed(decimal)
    },
    
    toDate(date) {
      if (date) {
        return moment(date).format('DD/MM/YYYY')
      }
      return ''
    },
    
    toTime(time) {
      if (time) {
        if (time.length === 5) {
          return moment(time + ':00', 'HH:mm:ss').format('HH:mm:ss')
        }
        return moment(time, 'HH:mm:ss').format('HH:mm:ss')
      }
      return ''
    },
    
    pad(value, fill = '', length = 3) {
      if (value) {
        return String(value).padStart(length, fill)
      }
      return value
    }
  }
}

