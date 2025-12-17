<template>
  <header class="fixed top-0 left-0 right-0 h-16 bg-white border-b border-gray-200 shadow-sm z-50">
    <div class="h-full flex items-center justify-between px-6">
      <!-- Logo Section -->
      <div class="flex items-center gap-4">
        <Link :href="route('system.dashboard')" class="flex items-center">
          <img 
            v-if="logo" 
            class="h-8 w-auto" 
            :src="logo" 
            alt="Logo" 
          />
          <img 
            v-else-if="logoDefault" 
            class="h-8 w-auto" 
            :src="logoDefault" 
            alt="Logo" 
          />
          <span v-else class="text-xl font-semibold text-gray-900">PANEL RESELLER</span>
        </Link>
        
        <!-- Mobile Menu Toggle -->
        <button 
          class="md:hidden p-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors"
          @click="toggleSidebar"
          aria-label="Toggle sidebar"
        >
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 12h18M3 6h18M3 18h18"/>
          </svg>
        </button>
      </div>

      <!-- Right Section: Links & User Menu -->
      <div class="flex items-center gap-4">
        <!-- Version & Manual Links -->
        <div class="hidden md:flex items-center gap-2">
          <a 
            class="inline-flex items-center gap-1.5 rounded-md border border-blue-600 text-blue-600 hover:bg-blue-50 text-sm px-3 py-1.5 transition-colors font-medium" 
            href="https://manual.uio.la/Pro7/Actualizaciones/2025/7.2" 
            target="_blank"
            rel="noopener noreferrer"
          >
            🎉 Versión 7.2
          </a>
          <a 
            class="inline-flex items-center gap-1.5 rounded-md bg-gray-900 text-white hover:bg-gray-800 text-sm px-3 py-1.5 transition-colors font-medium" 
            href="https://manual.uio.la/Pro7" 
            target="_blank"
            rel="noopener noreferrer"
          >
            <span>Manual</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
              <path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
              <path d="M3 6l0 13" />
              <path d="M12 6l0 13" />
              <path d="M21 6l0 13" />
            </svg>
          </a>
        </div>

        <!-- Divider -->
        <div class="hidden md:block w-px h-6 bg-gray-300"></div>

        <!-- User Menu -->
        <div class="relative" ref="userMenuRef">
          <button
            @click="toggleUserMenu"
            class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors"
            aria-expanded="false"
            aria-haspopup="true"
          >
            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-600">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
              </svg>
            </div>
            <div class="hidden md:block text-left">
              <div class="text-sm font-medium text-gray-900">{{ user?.name }}</div>
              <div class="text-xs text-gray-500">{{ user?.email }}</div>
            </div>
            <svg 
              xmlns="http://www.w3.org/2000/svg" 
              width="16" 
              height="16" 
              viewBox="0 0 24 24" 
              fill="none" 
              stroke="currentColor" 
              stroke-width="2" 
              stroke-linecap="round" 
              stroke-linejoin="round"
              class="text-gray-500 transition-transform"
              :class="{ 'rotate-180': isUserMenuOpen }"
            >
              <path d="M6 9l6 6l6 -6"/>
            </svg>
          </button>

          <!-- Dropdown Menu -->
          <div
            v-show="isUserMenuOpen"
            class="absolute right-0 mt-2 w-56 rounded-lg bg-white shadow-lg border border-gray-200 py-1 z-50"
            @click.stop
          >
            <Link 
              href="/users/create" 
              class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
              </svg>
              <span>Perfil</span>
            </Link>
            <button
              @click="toggleThemeSidebar"
              class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors text-left"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                <path d="M19 6h1a2 2 0 0 1 2 2a5 5 0 0 1 -5 5l-5 0v2" />
                <path d="M10 15m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
              </svg>
              <span>Estilos y Temas</span>
            </button>
            <div class="border-t border-gray-200 my-1"></div>
            <form :action="route('logout')" method="POST" @submit.prevent="handleLogout">
              <button 
                type="submit" 
                class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors text-left"
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                  <path d="M9 12h12l-3 -3" />
                  <path d="M18 15l3 -3" />
                </svg>
                <span>Cerrar Sesión</span>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'
import { computed, ref, onMounted, onUnmounted } from 'vue'
import { route } from 'ziggy-js'

const page = usePage()
const user = computed(() => page.props.auth?.user)
const isUserMenuOpen = ref(false)
const userMenuRef = ref(null)

const logo = computed(() => {
  return page.props.configuration?.login?.logo || null
})

const logoDefault = computed(() => {
  // Verificar si existe logo.svg en public/theme
  return '/theme/logo.svg'
})

const toggleUserMenu = () => {
  isUserMenuOpen.value = !isUserMenuOpen.value
}

const toggleSidebar = () => {
  // Toggle sidebar en mobile
  const html = document.documentElement
  html.classList.toggle('sidebar-left-opened')
  const event = new CustomEvent('sidebar-left-opened')
  html.dispatchEvent(event)
}

const toggleThemeSidebar = () => {
  // Función para toggle del tema
  if (typeof window.toggleThemeSidebar === 'function') {
    window.toggleThemeSidebar()
  }
  isUserMenuOpen.value = false
}

const handleLogout = () => {
  router.post(route('logout'))
}

// Cerrar menú al hacer click fuera
const handleClickOutside = (event) => {
  if (userMenuRef.value && !userMenuRef.value.contains(event.target)) {
    isUserMenuOpen.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

