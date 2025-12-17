# Ejemplos Prácticos de Migración Vue 2 → Vue 3

## 📚 Índice de Ejemplos
1. [Componente Simple](#componente-simple)
2. [Componente con Store](#componente-con-store)
3. [Componente con Mixins](#componente-con-mixins)
4. [Componente con Event Bus](#componente-con-event-bus)
5. [Componente con Filters](#componente-con-filters)
6. [Store Vuex → Pinia](#store-vuex--pinia)

---

## 1. Componente Simple

### Antes (Vue 2 Options API)
```vue
<template>
  <div class="dashboard">
    <h1>{{ title }}</h1>
    <el-button @click="increment">Contador: {{ count }}</el-button>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      default: 'Dashboard'
    }
  },
  data() {
    return {
      count: 0
    }
  },
  methods: {
    increment() {
      this.count++
    }
  }
}
</script>
```

### Después (Vue 3 Composition API)
```vue
<template>
  <div class="dashboard">
    <h1>{{ title }}</h1>
    <el-button @click="increment">Contador: {{ count }}</el-button>
  </div>
</template>

<script setup>
import { ref } from 'vue'

// Props
const props = defineProps({
  title: {
    type: String,
    default: 'Dashboard'
  }
})

// State
const count = ref(0)

// Methods
const increment = () => {
  count.value++
}
</script>
```

---

## 2. Componente con Store

### Antes (Vue 2 + Vuex)
```vue
<template>
  <div>
    <p>Usuario: {{ userName }}</p>
    <el-button @click="loadUser">Cargar Usuario</el-button>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
  computed: {
    ...mapState(['user']),
    userName() {
      return this.user?.name || 'Sin usuario'
    }
  },
  methods: {
    ...mapActions(['fetchUser']),
    async loadUser() {
      await this.fetchUser()
    }
  }
}
</script>
```

### Después (Vue 3 + Pinia)
```vue
<template>
  <div>
    <p>Usuario: {{ userName }}</p>
    <el-button @click="loadUser">Cargar Usuario</el-button>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useMainStore } from '@/stores/main'

// Store
const store = useMainStore()

// Computed
const userName = computed(() => {
  return store.user?.name || 'Sin usuario'
})

// Methods
const loadUser = async () => {
  await store.fetchUser()
}
</script>
```

---

## 3. Componente con Mixins

### Antes (Vue 2 con Mixin)
```vue
<template>
  <div>
    <el-button @click="deleteItem(item.id)">Eliminar</el-button>
  </div>
</template>

<script>
import deletable from '@/mixins/deletable'

export default {
  mixins: [deletable],
  props: {
    item: Object
  },
  methods: {
    async deleteItem(id) {
      await this.deleteRecord(id)
      this.$message.success('Eliminado correctamente')
    }
  }
}
</script>
```

### Después (Vue 3 con Composable)
```vue
<template>
  <div>
    <el-button @click="deleteItem(item.id)" :loading="loading">
      Eliminar
    </el-button>
  </div>
</template>

<script setup>
import { useDeletable } from '@/composables/useDeletable'
import { useMessage } from '@/helpers/compat'

// Props
const props = defineProps({
  item: Object
})

// Composables
const { loading, deleteRecord } = useDeletable('items')
const message = useMessage()

// Methods
const deleteItem = async (id) => {
  await deleteRecord(id)
  message.success('Eliminado correctamente')
}
</script>
```

**Composable (`resources/js/composables/useDeletable.js`):**
```javascript
import { ref } from 'vue'
import axios from 'axios'

export function useDeletable(resource) {
  const loading = ref(false)
  const error = ref(null)

  const deleteRecord = async (id) => {
    loading.value = true
    error.value = null
    
    try {
      await axios.delete(`/${resource}/${id}`)
      return { success: true }
    } catch (err) {
      error.value = err
      throw err
    } finally {
      loading.value = false
    }
  }

  return {
    loading,
    error,
    deleteRecord
  }
}
```

---

## 4. Componente con Event Bus

### Antes (Vue 2)
```vue
<template>
  <div>
    <el-button @click="sendEvent">Enviar Evento</el-button>
  </div>
</template>

<script>
export default {
  mounted() {
    this.$eventHub.$on('custom-event', this.handleEvent)
  },
  beforeDestroy() {
    this.$eventHub.$off('custom-event', this.handleEvent)
  },
  methods: {
    sendEvent() {
      this.$eventHub.$emit('custom-event', { data: 'test' })
    },
    handleEvent(data) {
      console.log('Evento recibido:', data)
    }
  }
}
</script>
```

### Después (Vue 3)
```vue
<template>
  <div>
    <el-button @click="sendEvent">Enviar Evento</el-button>
  </div>
</template>

<script setup>
import { onMounted, onBeforeUnmount } from 'vue'
import { eventBus } from '@/helpers/compat'

// Methods
const sendEvent = () => {
  eventBus.emit('custom-event', { data: 'test' })
}

const handleEvent = (data) => {
  console.log('Evento recibido:', data)
}

// Lifecycle
onMounted(() => {
  eventBus.on('custom-event', handleEvent)
})

onBeforeUnmount(() => {
  eventBus.off('custom-event', handleEvent)
})
</script>
```

---

## 5. Componente con Filters

### Antes (Vue 2)
```vue
<template>
  <div>
    <p>Fecha: {{ date | toDate }}</p>
    <p>Precio: {{ price | toDecimals(2) }}</p>
  </div>
</template>

<script>
export default {
  props: {
    date: String,
    price: Number
  },
  filters: {
    toDate(date) {
      if (!date) return ''
      return moment(date).format('DD/MM/YYYY')
    },
    toDecimals(value, decimals = 2) {
      return Number(value).toFixed(decimals)
    }
  }
}
</script>
```

### Después (Vue 3)
```vue
<template>
  <div>
    <p>Fecha: {{ formattedDate }}</p>
    <p>Precio: {{ formattedPrice }}</p>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useGlobalFilters } from '@/composables/useGlobalFilters'
import moment from 'moment'

// Props
const props = defineProps({
  date: String,
  price: Number
})

// Composables
const filters = useGlobalFilters()

// Computed (reemplaza filters)
const formattedDate = computed(() => {
  return filters.toDate(props.date)
})

const formattedPrice = computed(() => {
  return filters.toDecimals(props.price, 2)
})
</script>
```

---

## 6. Store Vuex → Pinia

### Antes (Vuex)
```javascript
// store/state.js
export default {
  user: null,
  items: [],
  loading: false
}

// store/mutations.js
export default {
  SET_USER(state, user) {
    state.user = user
  },
  SET_ITEMS(state, items) {
    state.items = items
  },
  SET_LOADING(state, loading) {
    state.loading = loading
  }
}

// store/actions.js
export default {
  async fetchUser({ commit }) {
    commit('SET_LOADING', true)
    try {
      const response = await axios.get('/api/user')
      commit('SET_USER', response.data)
    } finally {
      commit('SET_LOADING', false)
    }
  },
  async fetchItems({ commit }) {
    commit('SET_LOADING', true)
    try {
      const response = await axios.get('/api/items')
      commit('SET_ITEMS', response.data)
    } finally {
      commit('SET_LOADING', false)
    }
  }
}

// store/index.js
import Vue from 'vue'
import Vuex from 'vuex'
import state from './state'
import mutations from './mutations'
import actions from './actions'

Vue.use(Vuex)

export default new Vuex.Store({
  state,
  mutations,
  actions
})
```

### Después (Pinia)
```javascript
// stores/main.js
import { defineStore } from 'pinia'
import axios from 'axios'

export const useMainStore = defineStore('main', {
  // State (similar a Vuex state)
  state: () => ({
    user: null,
    items: [],
    loading: false
  }),

  // Getters (similar a Vuex getters)
  getters: {
    userName: (state) => state.user?.name || 'Sin nombre',
    itemsCount: (state) => state.items.length
  },

  // Actions (reemplaza mutations + actions de Vuex)
  actions: {
    // En Pinia, puedes mutar el state directamente
    setUser(user) {
      this.user = user
    },
    
    setItems(items) {
      this.items = items
    },
    
    setLoading(loading) {
      this.loading = loading
    },

    // Actions asíncronas
    async fetchUser() {
      this.loading = true
      try {
        const response = await axios.get('/api/user')
        this.user = response.data
      } finally {
        this.loading = false
      }
    },

    async fetchItems() {
      this.loading = true
      try {
        const response = await axios.get('/api/items')
        this.items = response.data
      } finally {
        this.loading = false
      }
    }
  }
})
```

### Uso en Componente

**Antes (Vuex):**
```javascript
import { mapState, mapActions } from 'vuex'

export default {
  computed: {
    ...mapState(['user', 'items', 'loading'])
  },
  methods: {
    ...mapActions(['fetchUser', 'fetchItems'])
  }
}
```

**Después (Pinia):**
```javascript
import { useMainStore } from '@/stores/main'

export default {
  setup() {
    const store = useMainStore()
    
    // Acceder a state
    const user = computed(() => store.user)
    const items = computed(() => store.items)
    const loading = computed(() => store.loading)
    
    // Llamar actions
    store.fetchUser()
    store.fetchItems()
    
    return { user, items, loading }
  }
}
```

O con `<script setup>`:
```vue
<script setup>
import { storeToRefs } from 'pinia'
import { useMainStore } from '@/stores/main'

const store = useMainStore()

// Para reactividad, usar storeToRefs
const { user, items, loading } = storeToRefs(store)

// O acceder directamente (también reactivo)
// const user = computed(() => store.user)

// Llamar actions
store.fetchUser()
store.fetchItems()
</script>
```

---

## 7. Componente Complejo (Ejemplo Real)

### Antes (Vue 2 - Dashboard)
```vue
<template>
  <div class="dashboard">
    <el-card>
      <h2>{{ config.company.name }}</h2>
      <p>Fecha: {{ formattedDate }}</p>
      <el-button @click="refreshData" :loading="loading">
        Actualizar
      </el-button>
    </el-card>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import moment from 'moment'

export default {
  props: {
    typeUser: String,
    configuration: Object
  },
  data() {
    return {
      loading: false,
      data: []
    }
  },
  computed: {
    ...mapState(['config']),
    formattedDate() {
      return moment().format('DD/MM/YYYY')
    }
  },
  methods: {
    async refreshData() {
      this.loading = true
      try {
        const response = await this.$http.get('/api/dashboard')
        this.data = response.data
      } catch (error) {
        this.axiosError(error)
      } finally {
        this.loading = false
      }
    }
  },
  mounted() {
    this.refreshData()
  }
}
</script>
```

### Después (Vue 3)
```vue
<template>
  <div class="dashboard">
    <el-card>
      <h2>{{ config.company.name }}</h2>
      <p>Fecha: {{ formattedDate }}</p>
      <el-button @click="refreshData" :loading="loading">
        Actualizar
      </el-button>
    </el-card>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { storeToRefs } from 'pinia'
import { useMainStore } from '@/stores/main'
import { useGlobalMethods } from '@/composables/useGlobalMethods'
import moment from 'moment'
import axios from 'axios'

// Props
const props = defineProps({
  typeUser: String,
  configuration: Object
})

// Store
const store = useMainStore()
const { config } = storeToRefs(store)

// Composables
const { axiosError } = useGlobalMethods()

// State
const loading = ref(false)
const data = ref([])

// Computed
const formattedDate = computed(() => {
  return moment().format('DD/MM/YYYY')
})

// Methods
const refreshData = async () => {
  loading.value = true
  try {
    const response = await axios.get('/api/dashboard')
    data.value = response.data
  } catch (error) {
    axiosError(error)
  } finally {
    loading.value = false
  }
}

// Lifecycle
onMounted(() => {
  refreshData()
})
</script>
```

---

## 8. Migración de Mixins Comunes

### Mixin: `deletable.js`

**Antes:**
```javascript
export default {
  methods: {
    async deleteRecord(id) {
      try {
        await this.$http.delete(`/${this.resource}/${id}`)
        this.$message.success('Eliminado correctamente')
        this.loadRecords()
      } catch (error) {
        this.axiosError(error)
      }
    }
  }
}
```

**Después (Composable):**
```javascript
// composables/useDeletable.js
import { ref } from 'vue'
import axios from 'axios'
import { useMessage } from '@/helpers/compat'

export function useDeletable(resource, onSuccess) {
  const loading = ref(false)
  const error = ref(null)
  const message = useMessage()

  const deleteRecord = async (id) => {
    loading.value = true
    error.value = null
    
    try {
      await axios.delete(`/${resource}/${id}`)
      message.success('Eliminado correctamente')
      
      if (onSuccess) {
        onSuccess()
      }
    } catch (err) {
      error.value = err
      throw err
    } finally {
      loading.value = false
    }
  }

  return {
    loading,
    error,
    deleteRecord
  }
}
```

**Uso:**
```vue
<script setup>
import { useDeletable } from '@/composables/useDeletable'

const props = defineProps({
  resource: String
})

const { loading, deleteRecord } = useDeletable(
  props.resource,
  () => {
    // Callback después de eliminar
    loadRecords()
  }
)
</script>
```

---

## 📝 Notas Importantes

1. **`ref()` vs `reactive()`**: 
   - Usa `ref()` para valores primitivos
   - Usa `reactive()` para objetos (pero `ref()` también funciona)

2. **`.value`**: 
   - En Composition API, siempre accede a `ref` con `.value`
   - En template, Vue lo hace automáticamente

3. **Store en Pinia**:
   - No necesitas `commit` para mutar state
   - Puedes mutar directamente en actions
   - Usa `storeToRefs()` para mantener reactividad

4. **Event Bus**:
   - Vue 3 no tiene `new Vue()` para event bus
   - Usa `mitt` o similar

5. **Filters**:
   - Vue 3 no tiene filters
   - Convierte a computed o funciones

---

## 🔄 Checklist de Migración por Componente

- [ ] Convertir `data()` → `ref()` / `reactive()`
- [ ] Convertir `computed` → `computed()`
- [ ] Convertir `methods` → funciones
- [ ] Reemplazar `this.$` → composables/helpers
- [ ] Migrar `filters` → funciones/computed
- [ ] Actualizar `$emit` → `defineEmits`
- [ ] Migrar mixins → composables
- [ ] Actualizar acceso a store (Vuex → Pinia)
- [ ] Actualizar lifecycle hooks
- [ ] Probar funcionalidad completa

