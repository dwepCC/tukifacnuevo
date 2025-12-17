# Dependencias Pendientes de Migración

## ⚠️ Dependencias Temporalmente Eliminadas

Estas dependencias fueron eliminadas del `package.json` porque no son compatibles con Vue 3. Necesitan ser reemplazadas o migradas:

### 1. `@riophae/vue-treeselect` (Vue 2)
**Estado**: ❌ No compatible con Vue 3
**Alternativas**:
- `@vuejs/treeselect` (si existe)
- Crear componente propio basado en Element Plus
- Usar `el-tree-select` de Element Plus (si está disponible)

**Acción**: Buscar alternativa o crear wrapper

### 2. `vue-ckeditor5` (Verificar)
**Estado**: ⚠️ Verificar compatibilidad
**Alternativa**: 
- Usar CKEditor 5 directamente con Vue 3
- Verificar si hay versión Vue 3

**Acción**: Probar si funciona con Vue 3, si no, usar CKEditor directamente

### 3. `vue-content-loading` (Verificar)
**Estado**: ⚠️ Verificar compatibilidad
**Alternativa**:
- `vue3-content-loading` (si existe)
- Crear componente propio de skeleton loading

**Acción**: Probar compatibilidad o buscar alternativa

### 4. `vue-jstree` (Verificar)
**Estado**: ⚠️ Verificar compatibilidad
**Alternativa**:
- `vue3-jstree` (si existe)
- Usar `el-tree` de Element Plus

**Acción**: Probar compatibilidad o usar Element Plus tree

### 5. `vue-keypress` (Verificar)
**Estado**: ⚠️ Verificar compatibilidad
**Alternativa**:
- Usar eventos nativos de Vue 3
- `@vueuse/core` tiene `useKeyPress`

**Acción**: Migrar a `@vueuse/core` o eventos nativos

### 6. `vue-wysiwyg` (Verificar)
**Estado**: ⚠️ Verificar compatibilidad
**Alternativa**:
- CKEditor 5 (ya incluido)
- Quill.js con wrapper Vue 3
- TinyMCE

**Acción**: Usar CKEditor 5 que ya está instalado

### 7. `vue-dropzone-next` (Verificar)
**Estado**: ⚠️ Verificar compatibilidad
**Alternativa**:
- `vue3-dropzone` (si existe)
- Crear componente propio con Element Plus upload

**Acción**: Probar o usar Element Plus upload component

## 📝 Plan de Acción

1. **Instalar dependencias base** con `--legacy-peer-deps`
2. **Probar cada dependencia** una por una
3. **Reemplazar o crear wrappers** para las incompatibles
4. **Documentar cambios** en código

## 🔄 Instalación Temporal

Para instalar con dependencias que pueden tener conflictos:

```bash
npm install --legacy-peer-deps
```

Esto permitirá instalar aunque haya conflictos de peer dependencies.

