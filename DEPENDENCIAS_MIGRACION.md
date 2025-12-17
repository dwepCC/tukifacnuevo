# Dependencias Migradas a Vue 3

## ✅ Dependencias Actualizadas

### Core
- ✅ `vue`: `^2.6.14` → `^3.4.0`
- ✅ `@vitejs/plugin-vue2` → `@vitejs/plugin-vue`: `^5.0.0`
- ✅ `vite`: `^4.4.9` → `^5.0.0`
- ✅ `axios`: `^0.27.2` → `^1.6.0`
- ✅ `laravel-vite-plugin`: `^0.7.7` → `^1.0.0`

### UI Framework
- ✅ `element-ui`: `^2.13.0` → `element-plus`: `^2.4.0` ⚠️ **REQUIERE CAMBIOS EN CÓDIGO**

### Estado
- ✅ `vuex`: `^3.6.2` → `pinia`: `^2.1.0` ⚠️ **REQUIERE MIGRACIÓN COMPLETA**

### Utilidades
- ✅ `vue-clipboard2`: `^0.3.3` → `@soerenmartius/vue3-clipboard`: `^2.0.0`
- ✅ `vue2-dropzone`: `^3.6.0` → `vue-dropzone-next`: `^0.1.0`
- ✅ `mitt`: `^3.0.1` (nuevo - para event bus)

### Gráficos
- ✅ `chart.js`: `^2.7.3` → `^4.4.0`
- ✅ `vue-chartjs`: `^3.4.0` → `^5.2.0`

### Editor
- ✅ `@ckeditor/ckeditor5-build-classic`: `^20.0.0` → `^40.0.0`

### Otras
- ✅ `moment`: `^2.22.2` → `^2.30.0`
- ✅ `xml2js`: `^0.4.22` → `^0.6.2`
- ✅ `jqwidgets-scripts`: `^10.1.5` → `^15.0.0`
- ✅ `canvas`: `^2.7.0` → `^2.11.2`

## ⚠️ Dependencias que Necesitan Verificación

Estas dependencias pueden no tener versión Vue 3 oficial. Se mantienen por ahora pero necesitan testing:

- ⚠️ `@riophae/vue-treeselect`: `^0.4.0` (verificar compatibilidad)
- ⚠️ `vue-ckeditor5`: `^0.5.0` (verificar compatibilidad)
- ⚠️ `vue-content-loading`: `^1.6.0` (verificar compatibilidad)
- ⚠️ `vue-jstree`: `^2.1.6` (verificar compatibilidad)
- ⚠️ `vue-keypress`: `^2.1.1` (verificar compatibilidad)
- ⚠️ `vue-wysiwyg`: `^1.7.2` (verificar compatibilidad)

## ❌ Dependencias Eliminadas (No Compatibles)

- ❌ `vue-data-tables`: `^3.4.5` - **NO COMPATIBLE CON VUE 3**
  - **Alternativa**: Usar `element-plus` table o crear componente propio
  - **Alternativa**: `@tanstack/vue-table` (si necesitas funcionalidad avanzada)

## 📝 Notas de Migración

### Element UI → Element Plus
- Cambios en nombres de algunos componentes
- Cambios en props de algunos componentes
- Ver: https://element-plus.org/en-US/guide/migration.html

### Vuex → Pinia
- No hay mutations, solo actions
- State es reactivo directamente
- Ver: https://pinia.vuejs.org/

### Event Bus
- `new Vue()` ya no funciona
- Usar `mitt` para event bus
- Ver helpers/compat.js

## 🔄 Próximos Pasos

1. Instalar dependencias: `npm install`
2. Verificar errores de compatibilidad
3. Crear adapters/wrappers para dependencias problemáticas
4. Migrar código gradualmente

