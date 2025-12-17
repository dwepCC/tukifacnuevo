# Guía de Migración a Inertia.js con Vue 3

## ✅ Instalación Completada

### Paquetes Instalados

**Backend (Composer):**
- ✅ `inertiajs/inertia-laravel` v1.3.3

**Frontend (NPM):**
- ✅ `@inertiajs/vue3`
- ✅ `@inertiajs/progress`

### Archivos Creados

1. ✅ `app/Http/Middleware/HandleInertiaRequests.php` - Middleware de Inertia
2. ✅ `resources/views/app.blade.php` - Layout principal de Inertia
3. ✅ `resources/js/app-inertia.js` - App principal de Inertia con Vue 3
4. ✅ `resources/js/Pages/System/Dashboard.vue` - Ejemplo de página Inertia

### Configuración Realizada

1. ✅ Middleware agregado a `app/Http/Kernel.php` (grupo 'web')
2. ✅ Vite configurado para incluir `app-inertia.js`

---

## 🚀 Cómo Usar Inertia.js

### 1. Configurar el Layout Principal

El layout `resources/views/app.blade.php` ya está configurado. Este es el único archivo Blade que necesitas.

### 2. Crear Páginas Vue

Las páginas de Inertia se crean en `resources/js/Pages/`:

```
resources/js/Pages/
├── System/
│   └── Dashboard.vue
├── Tenant/
│   └── Documents/
│       └── Index.vue
└── Auth/
    └── Login.vue
```

### 3. Actualizar Controladores

**Antes (Blade):**
```php
return view('system.dashboard', [
    'clients' => $clients,
    'delete_permission' => $delete_permission,
]);
```

**Después (Inertia):**
```php
use Inertia\Inertia;

return Inertia::render('System/Dashboard', [
    'clients' => $clients,
    'delete_permission' => $delete_permission,
]);
```

### 4. Crear Componentes Vue

**Ejemplo: `resources/js/Pages/System/Dashboard.vue`**

```vue
<template>
  <div>
    <Head title="Dashboard" />
    
    <SystemClientsIndex
      :delete-permission="deletePermission"
      :disc-used="discUsed"
      :i-used="iUsed"
      :storage-size="storageSize"
      :version="version"
    />
  </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import SystemClientsIndex from '@/views/system/clients/index.vue'

defineProps({
  deletePermission: Boolean,
  discUsed: Number,
  iUsed: Number,
  storageSize: Number,
  version: String,
})
</script>
```

---

## 📝 Migración Gradual

### Opción 1: Migración Completa (Recomendado)

1. **Cambiar el layout principal:**
   - Actualizar `resources/views/system/layouts/app.blade.php` para usar Inertia
   - O crear un nuevo layout específico para Inertia

2. **Migrar controladores uno por uno:**
   ```php
   // En cada controlador
   use Inertia\Inertia;
   
   return Inertia::render('System/Dashboard', $data);
   ```

3. **Crear páginas Vue:**
   - Convertir vistas Blade a componentes Vue
   - Mover componentes Vue existentes a `Pages/`

### Opción 2: Migración Híbrida (Temporal)

Puedes mantener algunas vistas en Blade y otras en Inertia:

```php
// Vista Blade (sin cambios)
return view('system.dashboard', $data);

// Vista Inertia (nueva)
return Inertia::render('System/Dashboard', $data);
```

---

## 🔧 Configuración Adicional

### Compartir Datos Globales

En `app/Http/Middleware/HandleInertiaRequests.php`:

```php
public function share(Request $request): array
{
    return array_merge(parent::share($request), [
        'auth' => [
            'user' => $request->user(),
        ],
        'flash' => [
            'message' => fn () => $request->session()->get('message'),
        ],
    ]);
}
```

### Rutas con Ziggy

Inertia incluye soporte para Ziggy (rutas de Laravel en JavaScript):

```vue
<script setup>
import { router } from '@inertiajs/vue3'

// Navegar a una ruta
router.visit(route('system.dashboard'))
</script>
```

---

## 🎯 Ventajas de Inertia.js

1. ✅ **No más problemas de montaje** - Vue se monta una sola vez
2. ✅ **Vue 3 Composition API nativo** - Sin necesidad de montar en elementos específicos
3. ✅ **SPA-like sin API** - Navegación fluida sin necesidad de API REST
4. ✅ **Props automáticos** - Los datos del controlador se pasan automáticamente como props
5. ✅ **Progress bar** - Indicador de carga automático
6. ✅ **Preservación de estado** - El estado se mantiene entre navegaciones

---

## 📚 Recursos

- [Documentación de Inertia.js](https://inertiajs.com/)
- [Inertia.js con Vue 3](https://inertiajs.com/client-side-setup#vue-3)
- [Laravel + Inertia](https://inertiajs.com/server-side-setup#laravel)

---

## ⚠️ Notas Importantes

1. **Vite debe compilar `app-inertia.js`** - Verifica que esté en `vite.config.mjs`
2. **El layout `app.blade.php` es único** - Todas las páginas Inertia usan este layout
3. **Los componentes Vue existentes funcionan** - Puedes importarlos en las páginas Inertia
4. **Migración gradual** - Puedes migrar vista por vista sin romper nada

---

## 🚦 Próximos Pasos

1. **Probar Inertia con una vista simple:**
   ```php
   // En un controlador de prueba
   return Inertia::render('System/Dashboard', [
       'test' => 'Hola Inertia!'
   ]);
   ```

2. **Crear la página Vue:**
   ```vue
   <template>
     <div>{{ test }}</div>
   </template>
   <script setup>
   defineProps(['test'])
   </script>
   ```

3. **Ejecutar:**
   ```bash
   npm run dev
   ```

4. **Visitar la ruta** y verificar que funciona

---

## ✅ Estado Actual

- ✅ Inertia.js instalado y configurado
- ✅ Middleware configurado
- ✅ Layout principal creado
- ✅ App.js de Inertia creado
- ✅ Ejemplo de página creado
- ⏳ Listo para migrar vistas

¡Ahora puedes empezar a migrar tus vistas a Inertia! 🎉

