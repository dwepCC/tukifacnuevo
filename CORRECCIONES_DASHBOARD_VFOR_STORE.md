# Correcciones: Dashboard - v-for y Store

## ✅ Correcciones Realizadas

### 1. Sintaxis `v-for` en Vue 3

#### `modules/Dashboard/Resources/assets/js/views/index.vue`
- ✅ Línea 490: Movido `:key` del `<tr>` al `<template>`
- ✅ Línea 545: Movido `:key` del `<tr>` al `<template>`

**Antes:**
```vue
<template v-for="(row, index) in items_by_sales">
    <tr :key="index">...</tr>
</template>
```

**Después:**
```vue
<template v-for="(row, index) in items_by_sales" :key="index">
    <tr>...</tr>
</template>
```

#### `modules/Dashboard/Resources/assets/js/views/items/SalesByProduct.vue`
- ✅ Línea 129: Movido `:key` del `<tr>` al `<template>`

---

### 2. Configuración de `$store` como Global Property

#### Problema
Los componentes Options API estaban usando `this.$store.commit()` y `this.$store.dispatch()`, pero `$store` no estaba configurado como propiedad global en Vue 3.

#### Solución
Se agregó un Proxy que simula la API de Vuex usando Pinia internamente:

**`resources/js/app.js` y `resources/js/system.js`:**
```javascript
import { useMainStore } from './stores/main'
app.config.globalProperties.$store = new Proxy({}, {
  get(target, prop) {
    const store = useMainStore()
    if (prop === 'commit') {
      return (mutation, payload) => {
        if (typeof store[mutation] === 'function') {
          return store[mutation](payload)
        }
        console.warn(`Mutation "${mutation}" no encontrada en el store`)
      }
    }
    if (prop === 'dispatch') {
      return (action, payload) => {
        if (typeof store[action] === 'function') {
          return store[action](payload)
        }
        console.warn(`Action "${action}" no encontrada en el store`)
        return Promise.resolve()
      }
    }
    if (prop === 'state') {
      return store
    }
    if (prop === 'getters') {
      return store
    }
    return store[prop]
  }
})
```

---

### 3. Import de Vuex Adapter

#### `modules/Dashboard/Resources/assets/js/views/index.vue`
- ✅ Cambiado de `vuex/dist/vuex.mjs` a `@/stores/vuex-adapter`
- ✅ `mapActions` ahora funciona correctamente con Pinia

**Antes:**
```javascript
import {mapActions, mapState} from "vuex/dist/vuex.mjs";
```

**Después:**
```javascript
import {mapActions, mapState} from "@/stores/vuex-adapter";
```

---

## 🔍 Problema de Recarga Infinita

### Posibles Causas
1. **`$store` no definido**: Si `this.$store` no existe, puede causar errores que hacen que Vite recargue constantemente.
2. **Errores de compilación**: Errores de sintaxis Vue 3 pueden causar recargas infinitas en modo desarrollo.

### Solución Aplicada
- ✅ Configurado `$store` como global property
- ✅ Corregidos errores de sintaxis `v-for`
- ✅ Actualizado import de Vuex a adapter de Pinia

---

## ✅ Estado Actual

- ✅ 3 archivos corregidos (2 errores de `v-for`, 1 import de Vuex)
- ✅ `$store` configurado como global property en `app.js` y `system.js`
- ✅ Compatibilidad con componentes Options API que usan `this.$store.commit()` y `this.$store.dispatch()`

---

## 📝 Notas

- El Proxy de `$store` llama a `useMainStore()` cada vez que se accede a una propiedad, lo cual es seguro porque Pinia maneja los singletons internamente.
- Los componentes Options API ahora pueden usar `this.$store.commit()` y `this.$store.dispatch()` sin cambios adicionales.
- La recarga infinita debería estar resuelta ahora que `$store` está configurado correctamente.

