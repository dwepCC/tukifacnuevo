# Corrección: Error de Import de Chart.js

## 🔴 Problema

```
Uncaught SyntaxError: The requested module '/node_modules/.vite/deps/chart__js.js?v=8e3b68eb' 
does not provide an export named 'default' (at Line.vue:16:12)
```

**Causa:**
- Chart.js 4.x no exporta un `default export`
- Los archivos estaban usando `import Chart from 'chart.js'` (sintaxis de Chart.js 2.x/3.x)
- Chart.js 4.x requiere named imports y registro de componentes

---

## ✅ Solución Aplicada

### Cambio de Importación

**Antes (Chart.js 2.x/3.x):**
```javascript
import Chart from 'chart.js';
```

**Después (Chart.js 4.x):**
```javascript
import { Chart, registerables } from 'chart.js';

// Registrar componentes de Chart.js
Chart.register(...registerables);
```

---

## 📝 Archivos Corregidos

### 1. `resources/js/views/system/clients/charts/Line.vue`
- ✅ Cambiado `import Chart from 'chart.js'` a `import { Chart, registerables } from 'chart.js'`
- ✅ Agregado `Chart.register(...registerables)`

### 2. `resources/js/components/graph/src/Graph.vue`
- ✅ Cambiado `import Chart from 'chart.js'` a `import { Chart, registerables } from 'chart.js'`
- ✅ Agregado `Chart.register(...registerables)`

### 3. `resources/js/components/graph/src/GraphLine.vue`
- ✅ Cambiado `import Chart from 'chart.js'` a `import { Chart, registerables } from 'chart.js'`
- ✅ Agregado `Chart.register(...registerables)`

### 4. `resources/js/views/system/configuration/charts/Line.vue`
- ✅ **No requiere cambios** - Usa `vue-chartjs` que maneja Chart.js internamente

---

## 🔍 ¿Por qué este cambio?

### Chart.js 4.x - Tree Shaking

Chart.js 4.x introdujo tree shaking para reducir el tamaño del bundle. Esto significa:

1. **No hay default export**: Solo exports nombrados
2. **Registro manual**: Debes registrar los componentes que necesitas
3. **Mejor rendimiento**: Solo se incluyen los componentes que usas

### `registerables`

`registerables` incluye todos los componentes comunes de Chart.js:
- Line
- Bar
- Pie
- Doughnut
- Radar
- PolarArea
- Bubble
- Scatter
- Y más...

Si solo necesitas algunos componentes, puedes importarlos individualmente:

```javascript
import { Chart, LineController, LineElement, PointElement, LinearScale, CategoryScale } from 'chart.js';

Chart.register(LineController, LineElement, PointElement, LinearScale, CategoryScale);
```

---

## ✅ Estado Actual

- ✅ 3 archivos corregidos
- ✅ Chart.js 4.x compatible
- ✅ Cache de Vite limpiado

---

## 🛠️ Próximos Pasos

1. **Reiniciar el servidor Vite** (si está corriendo):
   ```bash
   # Detener (Ctrl+C)
   npm run dev
   ```

2. **Verificar que funcione:**
   - Los gráficos deberían renderizarse correctamente
   - No debería haber errores de import

---

## 📚 Referencias

- [Chart.js 4.x Migration Guide](https://www.chartjs.org/docs/latest/migration/v4-migration.html)
- [Chart.js Tree Shaking](https://www.chartjs.org/docs/latest/getting-started/integration.html#bundlers-webpack-rollup-etc)

