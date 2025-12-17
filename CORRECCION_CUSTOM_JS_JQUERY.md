# Corrección: Error "$ is not defined" en custom.js

## 🔴 Problema

```
Uncaught ReferenceError: $ is not defined
    at custom.js:8:1
```

**Causa:**
- `custom.js` está usando `$` directamente (sintaxis de script global)
- En módulos ES6, `$` no está disponible en el scope del módulo
- Aunque jQuery se define en `window.$` en `bootstrap.js`, los módulos ES6 no tienen acceso automático a variables globales

---

## ✅ Solución Aplicada

### Cambio en `custom.js`

**Problema:**
- El archivo usaba `$` directamente sin importarlo o accederlo desde `window`

**Solución:**
```javascript
// Asegurar que jQuery esté disponible desde window
// En módulos ES6, $ no está disponible globalmente, debe accederse desde window
const $ = window.$ || window.jQuery;
const jQuery = window.jQuery || window.$;

if (!$) {
    console.error('jQuery no está disponible. Asegúrate de que se cargue antes de custom.js');
}
```

---

## 🔍 Explicación

### ¿Por qué no funciona `$` directamente?

En módulos ES6:
- Las variables globales no están disponibles automáticamente
- `$` debe importarse o accederse desde `window.$`
- `bootstrap.js` define `window.$ = jquery`, pero esto no hace que `$` esté disponible en el scope del módulo

### Solución

Definir `$` localmente desde `window.$`:
- ✅ Funciona en módulos ES6
- ✅ Mantiene compatibilidad con código existente
- ✅ No requiere cambiar todas las referencias a `$` en el archivo

---

## 📝 Orden de Carga

El orden correcto es:
1. `bootstrap.js` importa jQuery y lo define en `window.$`
2. `bootstrap.js` importa `custom.js`
3. `custom.js` accede a `window.$` y lo define localmente como `$`

---

## ✅ Estado Actual

- ✅ `custom.js` corregido para usar `window.$`
- ✅ Cache de Vite limpiado
- ✅ Compatibilidad mantenida con código existente

---

## 🛠️ Próximos Pasos

1. **Reiniciar el servidor Vite** (si está corriendo):
   ```bash
   # Detener (Ctrl+C)
   npm run dev
   ```

2. **Verificar que funcione:**
   - El error `$ is not defined` debería desaparecer
   - El código jQuery en `custom.js` debería funcionar correctamente

---

## 📚 Referencias

- [ES6 Modules and Global Variables](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Modules)
- [jQuery in ES6 Modules](https://api.jquery.com/)

