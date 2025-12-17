# Corrección: Error de Import de Vue en bus.js

## 🔴 Problema

```
Uncaught SyntaxError: The requested module '/node_modules/.vite/deps/vue.js?v=5fe57f38' 
does not provide an export named 'default' (at bus.js:1:8)
```

**Causa:**
- `bus.js` estaba intentando importar Vue 2 con `import Vue from 'vue'`
- Vue 3 no exporta un default export de la misma manera que Vue 2
- `new Vue()` ya no existe en Vue 3

---

## ✅ Solución Aplicada

### Cambio de Event Bus

**Antes (Vue 2):**
```javascript
import Vue from 'vue'
export const EventBus = new Vue()
```

**Después (Vue 3):**
```javascript
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
  all: bus.all.bind(bus),
  clear: bus.clear.bind(bus),
}
```

---

## 🔍 Compatibilidad

### Sintaxis Vue 2 (Mantenida)

El wrapper permite que el código existente siga funcionando:

```javascript
// ✅ Funciona igual que antes
import { EventBus } from '@/helpers/bus'

EventBus.$on('event', handler)
EventBus.$emit('event', data)
EventBus.$off('event', handler)
```

### Sintaxis Vue 3 (Nueva)

También puedes usar los métodos directos de mitt:

```javascript
// ✅ Nueva sintaxis (más limpia)
import { EventBus } from '@/helpers/bus'

EventBus.on('event', handler)
EventBus.emit('event', data)
EventBus.off('event', handler)
```

---

## 📝 Notas Importantes

### Event Bus vs $eventHub

El proyecto tiene dos event buses:

1. **`EventBus`** (de `bus.js`): Para uso directo en componentes
2. **`$eventHub`** (de `compat.js`): Disponible globalmente como `this.$eventHub` en componentes Options API

Ambos usan `mitt` internamente y son compatibles.

### Uso Recomendado

- **Options API**: Usar `this.$eventHub` (ya configurado globalmente)
- **Composition API**: Usar `import { eventBus } from '@/helpers/compat'`
- **Código legacy**: Usar `import { EventBus } from '@/helpers/bus'` (mantiene compatibilidad)

---

## ✅ Estado Actual

- ✅ `bus.js` migrado a Vue 3
- ✅ Compatibilidad con sintaxis Vue 2 mantenida
- ✅ Cache de Vite limpiado

---

## 🛠️ Próximos Pasos

1. **Reiniciar el servidor Vite** (si está corriendo):
   ```bash
   # Detener (Ctrl+C)
   npm run dev
   ```

2. **Verificar que funcione:**
   - El error de import debería desaparecer
   - Los event buses deberían funcionar correctamente

---

## 📚 Referencias

- [Vue 3 Migration Guide - Event Bus](https://v3-migration.vuejs.org/breaking-changes/events-api.html)
- [mitt Documentation](https://github.com/developit/mitt)

