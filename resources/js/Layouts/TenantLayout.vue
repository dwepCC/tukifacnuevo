<template>
  <div class="min-h-screen bg-gray-100">
    <Head :title="title" />
    
    <!-- Sidebar -->
    <TenantSidebar 
      :is-collapsed="isSidebarCollapsed"
      :is-mobile-open="isMobileSidebarOpen"
      @toggle="toggleSidebar"
      @close-mobile="closeMobileSidebar"
    />
    
    <!-- Sidebar Overlay (Mobile) -->
    <div 
      v-if="isMobileSidebarOpen"
      class="fixed inset-0 bg-black/40 z-30 md:hidden"
      @click="closeMobileSidebar"
    ></div>
    
    <!-- Header -->
    <TenantHeader 
      :is-sidebar-collapsed="isSidebarCollapsed"
      @toggle-sidebar="toggleSidebar"
    />
    
    <!-- Main Content -->
    <main 
      :class="[
        'flex-1 overflow-auto transition-all duration-300 pt-16',
        isSidebarCollapsed ? 'md:ml-16' : 'md:ml-64'
      ]"
      id="main-content"
    >
      <div class="content-body p-4 min-h-[calc(100vh-4rem)]">
        <slot />
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import TenantHeader from '@/components/tenant/TenantHeader.vue'
import TenantSidebar from '@/components/tenant/TenantSidebar.vue'

defineProps({
  title: {
    type: String,
    default: 'TUKIFAC - Facturación Electrónica'
  }
})

// Estado del sidebar
const isSidebarCollapsed = ref(false)
const isMobileSidebarOpen = ref(false)

// Aplicar tooltips cuando el sidebar está colapsado
const applyTooltips = (collapsed) => {
  // Usar setTimeout para asegurar que el DOM esté actualizado
  setTimeout(() => {
    const sidebar = document.getElementById('sidebar-left')
    if (!sidebar) return
    
    if (collapsed) {
      sidebar.querySelectorAll('a').forEach((a) => {
        const textEl = a.querySelector('.sidebar-text')
        const txt = textEl ? textEl.textContent.trim() : ''
        if (txt) a.setAttribute('title', txt)
      })
    } else {
      sidebar.querySelectorAll('a[title]').forEach((a) => a.removeAttribute('title'))
    }
  }, 100)
}

// Sincronizar clase del HTML con el estado del sidebar
watch(isSidebarCollapsed, (collapsed) => {
  if (window.innerWidth >= 768) {
    if (collapsed) {
      document.documentElement.classList.add('sidebar-collapsed')
    } else {
      document.documentElement.classList.remove('sidebar-collapsed')
    }
    applyTooltips(collapsed)
  }
}, { immediate: true })

// Toggle sidebar (desktop: collapse/expand, mobile: open/close)
const toggleSidebar = () => {
  if (window.innerWidth >= 768) {
    // Desktop: toggle collapse
    isSidebarCollapsed.value = !isSidebarCollapsed.value
    localStorage.setItem('sidebarCollapsed', isSidebarCollapsed.value ? 'true' : 'false')
  } else {
    // Mobile: toggle open
    isMobileSidebarOpen.value = !isMobileSidebarOpen.value
    if (isMobileSidebarOpen.value) {
      document.documentElement.classList.add('sidebar-open')
      document.body.style.overflow = 'hidden'
    } else {
      document.documentElement.classList.remove('sidebar-open')
      document.body.style.overflow = ''
    }
  }
}

// Cerrar sidebar en mobile
const closeMobileSidebar = () => {
  isMobileSidebarOpen.value = false
  document.documentElement.classList.remove('sidebar-open')
  document.body.style.overflow = ''
}

// Verificar si es desktop
const isDesktop = () => window.innerWidth >= 768

// Cargar estado guardado del sidebar
onMounted(() => {
  const savedState = localStorage.getItem('sidebarCollapsed')
  if (savedState === 'true' && isDesktop()) {
    isSidebarCollapsed.value = true
  }
  
  // Manejar resize
  const handleResize = () => {
    if (isDesktop()) {
      isMobileSidebarOpen.value = false
      document.documentElement.classList.remove('sidebar-open')
      document.body.style.overflow = ''
    } else {
      // En mobile, remover la clase de collapsed
      document.documentElement.classList.remove('sidebar-collapsed')
    }
  }
  
  window.addEventListener('resize', handleResize)
  
  // Cleanup
  onUnmounted(() => {
    window.removeEventListener('resize', handleResize)
  })
})
</script>

<style scoped>
/* Estilos para transiciones del sidebar */
@media (min-width: 768px) {
  :deep(#sidebar-left) {
    transition: width 0.3s ease;
  }
}
</style>

