# Corrección: Sintaxis `v-for` en Vue 3

## ⚠️ Cambio de Sintaxis en Vue 3

En Vue 3, cuando usas `v-for` en un `<template>`, el atributo `:key` **DEBE** estar en el `<template>`, no en los elementos hijos.

---

## ❌ Sintaxis Incorrecta (Vue 2)

```vue
<template v-for="(item, index) in items">
    <div :key="index">...</div>
</template>
```

**Error en Vue 3:**
```
<template v-for> key should be placed on the <template> tag.
```

---

## ✅ Sintaxis Correcta (Vue 3)

```vue
<template v-for="(item, index) in items" :key="index">
    <div>...</div>
</template>
```

---

## 📝 Archivos Corregidos

### 1. `resources/js/views/system/plans/index.vue`
- ✅ Corregido: `:key` movido al `<template>`

### 2. `modules/MultiUser/Resources/assets/js/views/system/multi-users/form.vue`
- ✅ Corregido: `:key` movido al `<template>`
- ✅ Eliminado `:key` duplicado en `<el-option>`

---

## 🔍 Archivos que Pueden Tener el Mismo Problema

Estos archivos usan `<template v-for>` y pueden necesitar corrección:

1. `modules/Suscription/Resources/assets/js/payments/form.vue`
2. `modules/Suscription/Resources/assets/js/payment_receipt/index.vue`
3. `modules/Report/Resources/assets/js/views/sale_notes/index.vue`
4. `modules/Report/Resources/assets/js/views/quotations/index.vue`
5. `modules/OrderNote/Resources/assets/js/components/ChangeStateType.vue`
6. `modules/Order/Resources/assets/js/views/order_notes/index.vue`
7. `modules/FullSuscription/Resources/assets/js/payments/form.vue`
8. `modules/FullSuscription/Resources/assets/js/payment_receipt/index.vue`
9. `modules/Finance/Resources/assets/js/views/to_pay/index.vue`
10. `modules/Finance/Resources/assets/js/views/movements/index.vue`
11. `modules/Dashboard/Resources/assets/js/views/index.vue`
12. `modules/Dashboard/Resources/assets/js/views/items/SalesByProduct.vue`

---

## 🛠️ Cómo Corregir

### Patrón a Buscar:
```vue
<template v-for="...">
    <elemento :key="...">
```

### Reemplazar por:
```vue
<template v-for="..." :key="...">
    <elemento>
```

---

## ⚠️ Nota Importante

Si el `<template v-for>` tiene múltiples elementos hijos con `:key`, solo necesitas **UN** `:key` en el `<template>`. Elimina los `:key` de los elementos hijos.

**Ejemplo:**
```vue
<!-- ❌ Incorrecto -->
<template v-for="option in users">
    <el-tooltip :key="option.id">
        <el-option :key="option.id">...</el-option>
    </el-tooltip>
</template>

<!-- ✅ Correcto -->
<template v-for="option in users" :key="option.id">
    <el-tooltip>
        <el-option>...</el-option>
    </el-tooltip>
</template>
```

---

## ✅ Estado Actual

- ✅ 2 archivos corregidos
- ⚠️ ~12 archivos más pueden necesitar corrección (se corregirán cuando causen errores)

