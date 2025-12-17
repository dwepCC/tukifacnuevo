// Vue 3: Event Bus usando mitt (reemplaza new Vue())
// Este archivo mantiene compatibilidad con código que importa EventBus desde aquí
import mitt from 'mitt'

const bus = mitt()

// Crear wrapper compatible con sintaxis Vue 2 ($on, $emit, $off)
export const EventBus = {
  $on: bus.on.bind(bus),
  $emit: bus.emit.bind(bus),
  $off: bus.off.bind(bus),
  // También exportar métodos directos de mitt
  on: bus.on.bind(bus),
  emit: bus.emit.bind(bus),
  off: bus.off.bind(bus),
  // Nota: mitt no tiene métodos all() ni clear()
  // Si necesitas limpiar todos los listeners, crea una nueva instancia de mitt
}