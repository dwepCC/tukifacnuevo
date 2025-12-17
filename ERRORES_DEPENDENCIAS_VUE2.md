# Errores: Dependencias Vue 2 No Instaladas

## ✅ Problema Resuelto

El error de ESM con `laravel-vite-plugin` se resolvió renombrando `vite.config.js` a `vite.config.mjs`.

## ⚠️ Nuevo Problema: Componentes que Usan Vue 2

Hay componentes que todavía importan dependencias de Vue 2 que ya no están instaladas.

---

## Dependencias Faltantes

### 1. `vue-ckeditor5`
- **Archivo:** `resources/js/views/tenant/sale_notes/partials/item.vue`
- **Solución:** Usar `@ckeditor/ckeditor5-build-classic` directamente (ya instalado)

### 2. `vuex`
- **Archivos:**
  - `modules/DocumentaryProcedure/Resources/assets/js/views/files/TableArchives.vue`
  - `resources/js/views/tenant/documents/partials/consigned.vue`
- **Solución:** Migrar a Pinia (ya tienes el store migrado)

### 3. `vue-keypress`
- **Archivo:** `resources/js/views/tenant/sale_notes/partials/item.vue`
- **Solución:** Usar eventos nativos de Vue 3 o `@vueuse/core`

### 4. `vue-data-tables`
- **Archivo:** `resources/js/components/incomeLots.vue`
- **Solución:** Usar tabla de Element Plus o crear componente propio

### 5. `vue2-dropzone`
- **Archivo:** `modules/DocumentaryProcedure/Resources/assets/js/views/files/ModalAddEdit.vue`
- **Solución:** Usar `vue-dropzone-next` (ya instalado) o `@vueuse/core`

### 6. `vue-content-loading`
- **Archivo:** `modules/Dashboard/Resources/assets/js/views/partials/dashboard_inventory.vue`
- **Solución:** Usar skeleton de Element Plus o mantener la dependencia si es compatible

---

## Plan de Acción

### Opción 1: Instalar Temporalmente (Rápido)

Instalar las dependencias Vue 2 temporalmente para que el servidor funcione mientras migras:

```bash
npm install vue-ckeditor5 vue-keypress vue-content-loading vue2-dropzone --legacy-peer-deps
```

**Nota:** `vuex` y `vue-data-tables` NO deben instalarse (ya migrados/reemplazados).

### Opción 2: Migrar Componentes (Recomendado)

Migrar los componentes uno por uno a Vue 3:

1. **`item.vue`** - Reemplazar `vue-ckeditor5` y `vue-keypress`
2. **`TableArchives.vue` y `consigned.vue`** - Reemplazar `vuex` por Pinia
3. **`incomeLots.vue`** - Reemplazar `vue-data-tables` por Element Plus table
4. **`ModalAddEdit.vue`** - Reemplazar `vue2-dropzone` por `vue-dropzone-next`
5. **`dashboard_inventory.vue`** - Reemplazar `vue-content-loading` o mantener si funciona

---

## Soluciones Específicas

### Reemplazar `vue-ckeditor5`

```javascript
// ❌ Antes (Vue 2)
import VueCkeditor from 'vue-ckeditor5'

// ✅ Después (Vue 3)
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
```

### Reemplazar `vuex`

```javascript
// ❌ Antes (Vue 2)
import { mapState, mapActions } from 'vuex'

// ✅ Después (Vue 3)
import { useMainStore } from '@/stores/main'
// O usar el adapter:
import { mapState, mapActions } from '@/stores/vuex-adapter'
```

### Reemplazar `vue-keypress`

```vue
<!-- ❌ Antes (Vue 2) -->
<vue-keypress key-code="13" @pressed="handleEnter" />

<!-- ✅ Después (Vue 3) -->
<input @keyup.enter="handleEnter" />
```

### Reemplazar `vue-data-tables`

```vue
<!-- ❌ Antes (Vue 2) -->
<data-tables :data="items" />

<!-- ✅ Después (Vue 3) -->
<el-table :data="items">
  <!-- columnas -->
</el-table>
```

### Reemplazar `vue2-dropzone`

```javascript
// ❌ Antes (Vue 2)
import vue2Dropzone from 'vue2-dropzone'

// ✅ Después (Vue 3)
import vueDropzone from 'vue-dropzone-next'
```

---

## Recomendación

**Para continuar trabajando ahora:**

1. Instalar temporalmente las dependencias compatibles:
   ```bash
   npm install vue-content-loading vue-dropzone-next --legacy-peer-deps
   ```

2. Migrar los componentes problemáticos gradualmente:
   - Empezar por los más simples
   - Probar cada migración antes de continuar

3. **NO instalar:**
   - `vuex` (ya migrado a Pinia)
   - `vue-data-tables` (reemplazar por Element Plus)
   - `vue-ckeditor5` (usar CKEditor directamente)
   - `vue-keypress` (usar eventos nativos)

---

## Archivos a Migrar

1. ✅ `resources/js/views/tenant/sale_notes/partials/item.vue`
2. ✅ `modules/DocumentaryProcedure/Resources/assets/js/views/files/TableArchives.vue`
3. ✅ `resources/js/views/tenant/documents/partials/consigned.vue`
4. ✅ `resources/js/components/incomeLots.vue`
5. ✅ `modules/DocumentaryProcedure/Resources/assets/js/views/files/ModalAddEdit.vue`
6. ✅ `modules/Dashboard/Resources/assets/js/views/partials/dashboard_inventory.vue`

