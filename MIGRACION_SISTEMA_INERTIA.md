# Migración del Sistema a Inertia.js

## ✅ Archivos Creados

### 1. Layout de Inertia para Sistema
- **`resources/views/system-app.blade.php`** - Layout principal para rutas del sistema

### 2. Componentes Vue del Sistema
- **`resources/js/Layouts/SystemLayout.vue`** - Layout wrapper para páginas del sistema
- **`resources/js/components/system/SystemHeader.vue`** - Header del sistema
- **`resources/js/components/system/SystemSidebar.vue`** - Sidebar con menú completo

### 3. Páginas Inertia
- **`resources/js/Pages/System/Dashboard.vue`** - Dashboard migrado a Inertia

## 🔧 Configuración Realizada

### 1. Middleware de Inertia
- **`app/Http/Middleware/HandleInertiaRequests.php`** actualizado para:
  - Detectar rutas del sistema y usar `system-app.blade.php`
  - Compartir datos globales (auth, configuration)

### 2. Controlador Actualizado
- **`app/Http/Controllers/System/HomeController.php`** ahora usa `Inertia::render()`

## 📝 Cómo Funciona

### Detección Automática de Layout

El middleware detecta automáticamente si la ruta es del sistema:

```php
protected function rootView(Request $request): string
{
    if ($request->routeIs('system.*') || $request->is('*system*')) {
        return 'system-app';
    }
    return parent::rootView($request);
}
```

### Estructura de Páginas

Las páginas del sistema usan el layout `SystemLayout`:

```vue
<template>
  <SystemLayout title="Dashboard">
    <!-- Contenido de la página -->
  </SystemLayout>
</template>
```

## 🚀 Próximos Pasos

### 1. Migrar Más Vistas del Sistema

Para migrar otras vistas, sigue estos pasos:

**a) Actualizar el controlador:**
```php
use Inertia\Inertia;

return Inertia::render('System/Clients/Index', [
    'clients' => $clients,
    // ... otros datos
]);
```

**b) Crear la página Vue:**
```vue
<!-- resources/js/Pages/System/Clients/Index.vue -->
<template>
  <SystemLayout title="Clientes">
    <!-- Contenido -->
  </SystemLayout>
</template>

<script setup>
import SystemLayout from '@/Layouts/SystemLayout.vue'
// ...
</script>
```

### 2. Vistas a Migrar

- [ ] `resources/views/system/clients/index.blade.php`
- [ ] `resources/views/system/clients/form.blade.php`
- [ ] `resources/views/system/users/form.blade.php`
- [ ] `resources/views/system/plans/index.blade.php`
- [ ] `resources/views/system/payments/index.blade.php`
- [ ] `resources/views/system/configuration/index.blade.php`
- [ ] Y más...

## ⚠️ Notas Importantes

1. **El layout `system-app.blade.php` es específico para rutas del sistema**
2. **Los componentes Vue existentes funcionan** - Puedes importarlos en las páginas Inertia
3. **El sidebar y header están en componentes Vue** - Fácil de mantener y actualizar
4. **Los datos se pasan automáticamente** - No necesitas montar componentes manualmente

## 🎯 Ventajas de Esta Migración

1. ✅ **Vue 3 Composition API nativo** - Sin problemas de montaje
2. ✅ **Componentes reutilizables** - Header y Sidebar en Vue
3. ✅ **Navegación fluida** - Como SPA sin API REST
4. ✅ **Props automáticos** - Los datos del controlador se pasan como props
5. ✅ **Fácil de mantener** - Todo en Vue, nada de Blade mezclado

## 📚 Recursos

- Ver `GUIA_MIGRACION_INERTIA.md` para más detalles sobre Inertia
- Ver `resources/js/Pages/System/Dashboard.vue` como ejemplo

