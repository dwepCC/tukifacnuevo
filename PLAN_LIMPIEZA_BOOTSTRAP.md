# Plan de Limpieza: Eliminación de Bootstrap

## Archivos a Eliminar

### 1. Carpeta Principal de Bootstrap
- ✅ `resources/sass/porto/vendor/bootstrap/` (CSS y JS de Bootstrap)

### 2. Plugins de Bootstrap (Vendor)
- ✅ `resources/sass/porto/vendor/bootstrap-colorpicker/`
- ✅ `resources/sass/porto/vendor/bootstrap-datepicker/`
- ✅ `resources/sass/porto/vendor/bootstrap-datepicker_bk/` (backup)
- ✅ `resources/sass/porto/vendor/bootstrap-daterangepicker/`
- ✅ `resources/sass/porto/vendor/bootstrap-fileupload/`
- ✅ `resources/sass/porto/vendor/bootstrap-markdown/`
- ✅ `resources/sass/porto/vendor/bootstrap-maxlength/`
- ✅ `resources/sass/porto/vendor/bootstrap-multiselect/`
- ✅ `resources/sass/porto/vendor/bootstrap-tagsinput/`
- ✅ `resources/sass/porto/vendor/bootstrap-timepicker/`
- ✅ `resources/sass/porto/vendor/bootstrap-wizard/`
- ✅ `resources/sass/porto/vendor/select2-bootstrap-theme/` (tema de Bootstrap para Select2)
- ✅ `resources/sass/porto/master/style-switcher/bootstrap-colorpicker/`

### 3. Archivos de Páginas Bootstrap
- ✅ `resources/sass/pages/ui-bootstrap-page.scss`
- ✅ `resources/sass/pages/bootstrap-switch.scss`
- ✅ `resources/sass/pro/pages/ui-bootstrap-page.scss`
- ✅ `resources/sass/pro/pages/bootstrap-switch.scss`

### 4. Referencias en Archivos SCSS
- ✅ `resources/sass/pro/style.scss` - Línea 19: `@import '~bootstrap/scss/bootstrap';`
- ✅ `resources/sass/style.scss` - Línea 19: `@use 'bootstrap/scss/bootstrap' as *;`

### 5. Referencias en DataTables
- ⚠️ `resources/sass/porto/vendor/datatables/media/js/dataTables.bootstrap4.min.js`
- ⚠️ `resources/sass/porto/vendor/datatables/media/css/dataTables.bootstrap4.css`
- ⚠️ `resources/sass/porto/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.bootstrap4.min.js`

**Nota:** Estos archivos de DataTables son específicos para Bootstrap. Si ya no usas Bootstrap, estos también se pueden eliminar (pero verifica si DataTables se está usando).

### 6. Referencias en JavaScript
- ⚠️ `resources/js/bootstrap.js` - **NO ELIMINAR** - Este es el archivo de inicialización de la app, no tiene que ver con Bootstrap CSS

---

## Archivos a Modificar

### 1. `resources/sass/pro/style.scss`
```scss
// ❌ Eliminar esta línea:
@import '~bootstrap/scss/bootstrap';
```

### 2. `resources/sass/style.scss`
```scss
// ❌ Eliminar esta línea:
@use 'bootstrap/scss/bootstrap' as *;
```

---

## Verificación Post-Limpieza

Después de eliminar, verificar:
1. ✅ No hay errores de compilación
2. ✅ Los estilos de Tailwind funcionan correctamente
3. ✅ No hay referencias rotas en Blade templates

---

## Nota Importante

El archivo `resources/js/bootstrap.js` **NO se debe eliminar** porque:
- Es el archivo de inicialización de la aplicación Vue
- No tiene relación con Bootstrap CSS
- Contiene configuración importante (axios, CSRF token, etc.)

