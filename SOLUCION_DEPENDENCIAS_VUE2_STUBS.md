# Solución: Dependencias Vue 2 no resueltas

## 🔴 Problema

Vite no puede resolver las siguientes dependencias de Vue 2:
- `vuex` / `vuex/dist/vuex.mjs`
- `vue-keypress`
- `vue-data-tables`
- `vue2-dropzone` / `vue2-dropzone/dist/vue2Dropzone.min.css`
- `vue-ckeditor5`
- `vue-content-loading`

**Error:**
```
Error: The following dependencies are imported but could not be resolved:
  vuex (imported by ...)
  vue-keypress (imported by ...)
  ...
Are they installed?
```

---

## ✅ Solución Aplicada

### 1. Stubs Temporales

Se crearon stubs temporales en `resources/js/stubs/` para cada dependencia:

- **`vuex-stub.js`**: Stub para Vuex (usar `@/stores/vuex-adapter`)
- **`vue-keypress-stub.js`**: Stub para vue-keypress (usar eventos nativos `@keydown`)
- **`vue-data-tables-stub.js`**: Stub para vue-data-tables (migrar a Element Plus Table)
- **`vue2-dropzone-stub.js`**: Stub para vue2-dropzone (migrar a Element Plus Upload)
- **`vue-ckeditor5-stub.js`**: Stub para vue-ckeditor5 (usar `@/components/CKEditor.vue`)
- **`vue-content-loading-stub.js`**: Stub para vue-content-loading (migrar a Element Plus Skeleton)

### 2. Alias en `vite.config.mjs`

Se agregaron alias para redirigir las importaciones a los stubs:

```javascript
resolve: {
  alias: {
    // ... otros alias ...
    
    // Stubs temporales para dependencias Vue 2
    'vuex': path.resolve(__dirname, 'resources/js/stubs/vuex-stub.js'),
    'vuex/dist/vuex.mjs': path.resolve(__dirname, 'resources/js/stubs/vuex-stub.js'),
    'vue-keypress': path.resolve(__dirname, 'resources/js/stubs/vue-keypress-stub.js'),
    'vue-data-tables': path.resolve(__dirname, 'resources/js/stubs/vue-data-tables-stub.js'),
    'vue2-dropzone': path.resolve(__dirname, 'resources/js/stubs/vue2-dropzone-stub.js'),
    'vue2-dropzone/dist/vue2Dropzone.min.css': path.resolve(__dirname, 'resources/js/stubs/vue2-dropzone-stub.js'),
    'vue-ckeditor5': path.resolve(__dirname, 'resources/js/stubs/vue-ckeditor5-stub.js'),
    'vue-content-loading': path.resolve(__dirname, 'resources/js/stubs/vue-content-loading-stub.js'),
  }
}
```

---

## 📋 Archivos que Necesitan Migración

### Vuex → Pinia

**Archivos que importan `vuex` o `vuex/dist/vuex.mjs`:**

1. `modules/DocumentaryProcedure/Resources/assets/js/views/files/TableArchives.vue`
2. `resources/js/views/tenant/documents/partials/consigned.vue`
3. `resources/js/views/tenant/sale_notes/partials/item.vue`
4. `resources/js/views/tenant/item_sets/index.vue`
5. `resources/js/views/tenant/documents/index.vue`
6. ... (muchos más - ver grep results)

**Solución:**
```javascript
// Antes
import { mapActions, mapState } from "vuex/dist/vuex.mjs"

// Después
import { mapActions, mapState } from "@/stores/vuex-adapter"
```

### vue-keypress → Eventos Nativos

**Archivos que importan `vue-keypress`:**

1. `resources/js/views/tenant/sale_notes/partials/item.vue`
2. `resources/js/views/tenant/sale_notes/form.vue`
3. `resources/js/views/tenant/purchases/partials/item.vue`
4. `resources/js/views/tenant/pos/partials/table.vue`
5. ... (muchos más)

**Solución:**
```vue
<!-- Antes -->
<keypress keyevent="keyup" :keycode="13" @keypressed="handleEnter" />

<!-- Después -->
<div @keyup.enter="handleEnter">
  <!-- contenido -->
</div>
```

### vue-data-tables → Element Plus Table

**Archivos que importan `vue-data-tables`:**

1. `resources/js/components/incomeLots.vue`
2. `modules/Inventory/Resources/assets/js/inventory-review/index.vue`

**Solución:** Migrar a `<el-table>` de Element Plus

### vue2-dropzone → Element Plus Upload

**Archivos que importan `vue2-dropzone`:**

1. `modules/DocumentaryProcedure/Resources/assets/js/views/files/ModalAddEdit.vue`
2. `modules/DocumentaryProcedure/Resources/assets/js/views/files/ModalStage.vue`
3. ... (varios más)

**Solución:** Migrar a `<el-upload>` de Element Plus

### vue-ckeditor5 → CKEditor.vue

**Archivos que importan `vue-ckeditor5`:**

1. `resources/js/views/tenant/sale_notes/partials/item.vue`
2. `resources/js/views/tenant/quotations/partials/item.vue`
3. `resources/js/views/tenant/purchases/partials/item.vue`
4. ... (muchos más)

**Solución:**
```javascript
// Antes
import VueCkeditor from "vue-ckeditor5"
components: { 'vue-ckeditor': VueCkeditor }

// Después
import CKEditor from '@/components/CKEditor.vue'
components: { 'vue-ckeditor': CKEditor }
```

### vue-content-loading → Element Plus Skeleton

**Archivos que importan `vue-content-loading`:**

1. `modules/Dashboard/Resources/assets/js/views/partials/dashboard_inventory.vue`
2. `modules/Dashboard/Resources/assets/js/views/partials/dashboard_stock.vue`
3. `modules/Dashboard/Resources/assets/js/components/loaders/l-graph.vue`

**Solución:** Migrar a `<el-skeleton>` de Element Plus

---

## 🛠️ Próximos Pasos

### 1. Verificar que Vite Compila

```bash
npm run dev
```

Debería compilar sin errores (aunque los componentes con stubs mostrarán placeholders).

### 2. Migrar Gradualmente

Priorizar la migración de componentes más usados:

1. **Vuex → Pinia** (alta prioridad - muchos archivos)
2. **vue-ckeditor5 → CKEditor.vue** (alta prioridad - muchos archivos)
3. **vue-keypress → eventos nativos** (media prioridad)
4. **vue-data-tables → Element Plus Table** (baja prioridad - pocos archivos)
5. **vue2-dropzone → Element Plus Upload** (baja prioridad - pocos archivos)
6. **vue-content-loading → Element Plus Skeleton** (baja prioridad - pocos archivos)

### 3. Remover Stubs

Una vez migrados todos los componentes, eliminar:
- Los archivos en `resources/js/stubs/`
- Los alias en `vite.config.mjs`

---

## ⚠️ Notas Importantes

- Los stubs son **temporales** y solo permiten que Vite compile
- Los componentes que usan stubs **no funcionarán correctamente** hasta migrarlos
- Priorizar la migración de componentes críticos primero
- Los stubs muestran mensajes de advertencia en la UI

---

## 📚 Referencias

- [Vue 3 Migration Guide](https://v3-migration.vuejs.org/)
- [Pinia Documentation](https://pinia.vuejs.org/)
- [Element Plus Components](https://element-plus.org/en-US/component/table.html)

