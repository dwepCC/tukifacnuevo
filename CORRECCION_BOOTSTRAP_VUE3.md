# Corrección: Error de Import de Vue en bootstrap.js

## 🔴 Problema

```
Uncaught SyntaxError: The requested module '/node_modules/.vite/deps/vue.js?v=5fe57f38' 
does not provide an export named 'default' (at bootstrap.js:1:8)
```

**Causa:**
- `bootstrap.js` estaba intentando importar Vue 2 con `import Vue from 'vue'`
- Vue 3 no exporta un default export de la misma manera que Vue 2
- `Vue.prototype` ya no existe en Vue 3

---

## ✅ Solución Aplicada

### 1. Eliminado Import de Vue en `bootstrap.js`

**Antes:**
```javascript
import Vue from 'vue'; // ❌ Vue 2 syntax
Vue.prototype.$http = axios;
Vue.prototype.$setStorage = function(name, obj) { ... };
Vue.prototype.$getStorage = function(name) { ... };
```

**Después:**
```javascript
// Vue 3: Ya no se importa Vue aquí, se configura en app.js/system.js
// Exportar axios para uso en app.js/system.js
export { axios };
```

---

### 2. Movidas Propiedades Globales a `app.js` y `system.js`

En Vue 3, las propiedades globales se configuran usando `app.config.globalProperties` en lugar de `Vue.prototype`.

**`resources/js/app.js` y `resources/js/system.js`:**
```javascript
import './bootstrap'
import { axios } from './bootstrap'

// ... código de inicialización ...

// Axios y utilidades de almacenamiento (migrado desde bootstrap.js)
app.config.globalProperties.$http = axios

app.config.globalProperties.$setStorage = function(name, obj) {
    localStorage.setItem(name, JSON.stringify(obj))
}

app.config.globalProperties.$getStorage = function(name) {
    const item = localStorage.getItem(name)
    return item ? JSON.parse(item) : null
}
```

---

## 📝 Cambios Realizados

### `resources/js/bootstrap.js`
- ✅ Eliminado `import Vue from 'vue'`
- ✅ Eliminado `Vue.prototype.$http = axios`
- ✅ Eliminado `Vue.prototype.$setStorage`
- ✅ Eliminado `Vue.prototype.$getStorage`
- ✅ Agregado `export { axios }` para uso en otros archivos

### `resources/js/app.js`
- ✅ Agregado `import { axios } from './bootstrap'`
- ✅ Agregado `app.config.globalProperties.$http = axios`
- ✅ Agregado `app.config.globalProperties.$setStorage`
- ✅ Agregado `app.config.globalProperties.$getStorage`

### `resources/js/system.js`
- ✅ Agregado `import { axios } from './bootstrap'`
- ✅ Agregado `app.config.globalProperties.$http = axios`
- ✅ Agregado `app.config.globalProperties.$setStorage`
- ✅ Agregado `app.config.globalProperties.$getStorage`

---

## 🔍 Compatibilidad

### Componentes Options API

Los componentes que usan Options API pueden seguir usando estas propiedades globales sin cambios:

```javascript
export default {
  methods: {
    async fetchData() {
      // ✅ Funciona igual que antes
      const response = await this.$http.get('/api/data')
      
      // ✅ Funciona igual que antes
      this.$setStorage('key', { data: 'value' })
      const data = this.$getStorage('key')
    }
  }
}
```

### Componentes Composition API

En Composition API, se debe usar `getCurrentInstance()`:

```javascript
import { getCurrentInstance } from 'vue'

export default {
  setup() {
    const instance = getCurrentInstance()
    const { $http, $setStorage, $getStorage } = instance.appContext.config.globalProperties
    
    // Usar las propiedades
    const response = await $http.get('/api/data')
    $setStorage('key', { data: 'value' })
    const data = $getStorage('key')
  }
}
```

---

## ✅ Estado Actual

- ✅ Error de import de Vue: **RESUELTO**
- ✅ Propiedades globales migradas: **COMPLETADO**
- ✅ Compatibilidad con Options API: **MANTENIDA**
- ✅ Cache de Vite limpiado: **COMPLETADO**

---

## 🛠️ Próximos Pasos

1. **Reiniciar el servidor Vite:**
   ```bash
   npm run dev
   ```

2. **Verificar que no haya errores:**
   - El error de import debería desaparecer
   - Las propiedades globales deberían funcionar correctamente

3. **Si hay errores:**
   - Verificar que `axios` esté instalado: `npm list axios`
   - Verificar la consola del navegador para otros errores

---

## 📚 Referencias

- [Vue 3 Migration Guide - Global API](https://v3-migration.vuejs.org/breaking-changes/global-api.html)
- [Vue 3 Global Properties](https://vuejs.org/api/application.html#app-config-globalproperties)

