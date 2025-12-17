# ¿Por qué usar `--legacy-peer-deps`?

## Explicación Simple

### El Problema

Desde **npm 7** (2020), npm verifica automáticamente las **peer dependencies** (dependencias que un paquete espera que tengas instaladas).

**Ejemplo del conflicto:**
```
Tu proyecto tiene: vue@3.4.0 ✅
element-ui requiere: vue@^2.2.0 ❌
→ npm detecta conflicto y BLOQUEA la instalación
```

### ¿Qué hace `--legacy-peer-deps`?

Le dice a npm: **"Ignora los conflictos de peer dependencies e instala de todas formas"**

Es como el comportamiento de npm 6 (antes de 2020), donde no se verificaban estrictamente.

---

## En Tu Caso Específico

### ¿Por qué lo necesitas?

Algunas dependencias que mantuviste **aún no tienen versión Vue 3 oficial** y declaran Vue 2 como peer dependency:

- `vue-ckeditor5` - Requiere Vue 2
- `vue-content-loading` - Requiere Vue 2  
- `vue-jstree` - Requiere Vue 2
- Otras...

npm detecta: "Tienes Vue 3 pero estos paquetes requieren Vue 2" → **BLOQUEA**

---

## Alternativas

### Opción 1: `--legacy-peer-deps` (Rápido)

```bash
npm install --legacy-peer-deps
```

**Ventajas:**
- ✅ Instala rápido
- ✅ Permite probar si funcionan

**Desventajas:**
- ⚠️ Puede haber errores en runtime
- ⚠️ No es solución permanente

### Opción 2: Eliminar Dependencias Problemáticas (Mejor)

**Mejor enfoque:** Eliminar las que causan conflictos y usar alternativas.

**Ejemplo:**
```json
// Eliminar
"vue-ckeditor5": "^0.5.0"  // ❌ Requiere Vue 2

// Ya tienes alternativa
"@ckeditor/ckeditor5-build-classic": "^40.0.0"  // ✅ Funciona con Vue 3
```

### Opción 3: Usar `overrides` (npm 8.3+)

Ya lo tienes en tu `package.json`:
```json
"overrides": {
  "vue-ckeditor5": {
    "vue": "^3.4.0"  // Fuerza Vue 3
  }
}
```

**Pero:** Solo funciona si las dependencias están en `dependencies`, no solo en `overrides`.

---

## Recomendación

### Para Ahora (Desarrollo)

1. **Primero intenta** `npm install` sin flags
2. Si falla, usa `npm install --legacy-peer-deps`
3. **Prueba** si las dependencias funcionan
4. **Reemplaza** las que no funcionan

### Para Producción

1. **Elimina** dependencias incompatibles
2. **Usa alternativas** o crea wrappers
3. **No uses `--legacy-peer-deps`** en producción

---

## Resumen

**¿Por qué `--legacy-peer-deps`?**
- npm 7+ bloquea instalaciones con conflictos
- Algunas dependencias requieren Vue 2 pero tienes Vue 3
- `--legacy-peer-deps` ignora estos conflictos

**¿Es seguro?**
- ⚠️ Para desarrollo: Sí, con precaución
- ❌ Para producción: No, mejor eliminar/reemplazar

**Mejor enfoque:**
1. Instalar sin `--legacy-peer-deps` primero
2. Ver qué conflictos hay
3. Eliminar/reemplazar dependencias problemáticas
4. Solo usar `--legacy-peer-deps` para dependencias que realmente necesitas
