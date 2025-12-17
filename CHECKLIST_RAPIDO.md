# ✅ Checklist Rápido de Migración Vue 3

## 🚀 Inicio Rápido

### Paso 1: Preparación (30 min)
- [ ] Crear rama: `git checkout -b feature/vue3-migration`
- [ ] Backup: `git commit -am "backup: antes de migración"`
- [ ] Verificar compatibilidad: `node scripts/check-vue3-compatibility.js`

### Paso 2: Actualizar Dependencias (1 hora)
- [ ] Actualizar `package.json` (ver PLAN_MIGRACION_VUE3.md)
- [ ] Ejecutar: `npm install`
- [ ] Verificar: `npm run dev` funciona

### Paso 3: Migrar Core (1 día)
- [ ] Actualizar `vite.config.js`
- [ ] Migrar `app.js` a Vue 3
- [ ] Migrar store (Vuex → Pinia)
- [ ] Crear composables base

### Paso 4: Migrar Primer Componente (2 horas)
- [ ] Elegir componente simple
- [ ] Seguir ejemplo de EJEMPLOS_MIGRACION.md
- [ ] Probar funcionalidad
- [ ] Commit: `git commit -m "feat: migrar componente X a Vue 3"`

---

## 📋 Checklist por Componente

### Antes de Empezar
- [ ] Leer el componente completo
- [ ] Identificar dependencias (mixins, store, etc.)
- [ ] Verificar si hay tests

### Durante la Migración
- [ ] Convertir `data()` → `ref()` / `reactive()`
- [ ] Convertir `computed` → `computed()`
- [ ] Convertir `methods` → funciones
- [ ] Reemplazar `this.$store` → `useMainStore()`
- [ ] Reemplazar `this.$eventHub` → `eventBus`
- [ ] Migrar `filters` → funciones/computed
- [ ] Actualizar lifecycle hooks
- [ ] Migrar mixins → composables
- [ ] Actualizar imports de Element UI → Element Plus

### Después de Migrar
- [ ] Probar funcionalidad básica
- [ ] Verificar en navegador
- [ ] Revisar console por errores
- [ ] Verificar integración con otros componentes
- [ ] Commit con mensaje descriptivo

---

## 🔍 Verificación Rápida

### Comandos Útiles
```bash
# Verificar compatibilidad
node scripts/check-vue3-compatibility.js

# Build y ver errores
npm run build

# Desarrollo
npm run dev

# Ver bundle size
npm run build -- --analyze
```

### Errores Comunes

| Error | Solución |
|-------|----------|
| `Cannot read property '$store'` | Migrar a Pinia: `useMainStore()` |
| `Filters is not defined` | Convertir a computed o función |
| `$eventHub is not defined` | Usar `eventBus` de helpers/compat |
| `Element UI components not found` | Cambiar a Element Plus |
| `beforeDestroy is not a function` | Renombrar a `beforeUnmount` |

---

## 📊 Progreso de Migración

### Fase 1: Core ✅
- [ ] `app.js`
- [ ] `store/` → `stores/`
- [ ] `helpers/`
- [ ] `composables/` (crear)

### Fase 2: Componentes Base
- [ ] `components/DataTable.vue`
- [ ] `components/filters/`
- [ ] Otros componentes compartidos

### Fase 3: Módulos
- [ ] Módulo 1: __________
- [ ] Módulo 2: __________
- [ ] Módulo 3: __________
- [ ] ... (continuar)

---

## 🎯 Metas Diarias/Semanales

### Semana 1
- [ ] Configuración base lista
- [ ] Store migrado a Pinia
- [ ] 3-5 componentes base migrados

### Semana 2-4
- [ ] 1 módulo pequeño migrado
- [ ] Documentación actualizada
- [ ] Testing funcionando

### Mes 2-6
- [ ] Módulos medianos migrados
- [ ] Módulos grandes en progreso
- [ ] Performance mejorado

---

## ⚠️ Señales de Alerta

Si encuentras estos problemas, **detente y revisa**:

- ❌ Muchos errores en consola
- ❌ Funcionalidad rota
- ❌ Performance peor que antes
- ❌ Bundle size aumentó significativamente

**Solución**: Revisar cambios recientes, hacer rollback si es necesario.

---

## 📝 Notas Rápidas

### Atajos de Migración

**Options API → Composition API:**
```javascript
// data() → ref()
data() { return { count: 0 } }  →  const count = ref(0)

// computed → computed()
computed: { name() { return ... } }  →  const name = computed(() => ...)

// methods → funciones
methods: { do() {} }  →  const do = () => {}

// this.$store → store
this.$store.state.x  →  const store = useMainStore(); store.x
```

**Element UI → Element Plus:**
```javascript
// Cambios comunes
el-button → el-button (igual)
el-select → el-select (igual)
// Ver documentación para cambios específicos
```

---

## 🆘 Ayuda Rápida

### Recursos
- 📖 Plan completo: `PLAN_MIGRACION_VUE3.md`
- 💡 Ejemplos: `EJEMPLOS_MIGRACION.md`
- 🔧 Scripts: `scripts/check-vue3-compatibility.js`

### Preguntas Frecuentes

**¿Puedo migrar gradualmente?**
✅ Sí, Vue 3 puede coexistir con Vue 2 durante la migración.

**¿Debo migrar todo a Composition API?**
⚠️ No es obligatorio, pero es recomendado. Options API sigue funcionando.

**¿Qué hago si un componente no funciona?**
1. Revisar console por errores
2. Verificar imports
3. Comparar con ejemplo similar
4. Pedir ayuda al equipo

---

**¡Éxito en la migración! 🚀**

