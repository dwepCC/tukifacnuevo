<template>
  <aside 
    id="sidebar-left" 
    class="fixed left-0 top-16 w-64 h-[calc(100vh-4rem)] bg-white text-gray-900 border-r border-gray-200 overflow-y-auto z-40"
  >
    <div class="p-4">
      <div>
        <nav id="menu" class="pt-1 space-y-1" role="navigation">
          <ul class="space-y-1">
            <li>
              <Link 
                :href="route('system.dashboard')" 
                :class="[
                  'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors',
                  isActive(['clients', 'dashboard']) 
                    ? 'bg-blue-50 text-blue-700 font-medium' 
                    : 'text-gray-700 hover:bg-gray-100'
                ]"
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M5 4h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                  <path d="M5 16h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                  <path d="M15 12h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                  <path d="M15 4h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                </svg>
                <span>Dashboard</span>
              </Link>
            </li>
          </ul>
        </nav>
        <nav id="menu" class="space-y-1" role="navigation">
          <ul class="space-y-1">
            <li>
              <Link 
                :href="route('system.payments.index')" 
                :class="[
                  'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors',
                  isActive(['payment-orders']) 
                    ? 'bg-blue-50 text-blue-700 font-medium' 
                    : 'text-gray-700 hover:bg-gray-100'
                ]"
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M3 5m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                  <path d="M3 10l18 0" />
                  <path d="M7 15l.01 0" />
                  <path d="M11 15l2 0" />
                </svg>
                <span>Pagos</span>
              </Link>
            </li>
          </ul>
        </nav>
        <nav v-if="multiUserEnabled" id="menu" class="space-y-1" role="navigation">
          <ul class="space-y-1">
            <li>
              <Link 
                href="/multi-users" 
                :class="[
                  'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors',
                  isActive(['multi-users']) 
                    ? 'bg-blue-50 text-blue-700 font-medium' 
                    : 'text-gray-700 hover:bg-gray-100'
                ]"
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                  <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                  <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                  <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                  <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                  <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                </svg>
                <span>Multi Usuarios</span>
              </Link>
            </li>
          </ul>
        </nav>
        <nav id="menu" class="space-y-1" role="navigation">
          <ul class="space-y-1">
            <li>
              <Link 
                href="/plans" 
                :class="[
                  'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors',
                  isActive(['plans']) 
                    ? 'bg-blue-50 text-blue-700 font-medium' 
                    : 'text-gray-700 hover:bg-gray-100'
                ]"
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                  <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                  <path d="M17 17h-11v-14h-2" />
                  <path d="M6 5l14 1l-1 7h-13" />
                </svg>
                <span>Planes</span>
              </Link>
            </li>
          </ul>
        </nav>
        <nav id="menu" class="space-y-1" role="navigation">
          <ul class="space-y-1">
            <li>
              <Link 
                href="/massive-invoice" 
                :class="[
                  'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors',
                  isActive(['massive-invoice']) 
                    ? 'bg-blue-50 text-blue-700 font-medium' 
                    : 'text-gray-700 hover:bg-gray-100'
                ]"
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M15 3v4a1 1 0 0 0 1 1h4" />
                  <path d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2z" />
                  <path d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2" />
                </svg>
                <span>Facturación Masiva</span>
              </Link>
            </li>
          </ul>
        </nav>
        <nav id="menu" class="space-y-1" role="navigation">
          <ul class="space-y-1">
            <li>
              <Link 
                href="/accounting" 
                :class="[
                  'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors',
                  isActive(['accounting']) 
                    ? 'bg-blue-50 text-blue-700 font-medium' 
                    : 'text-gray-700 hover:bg-gray-100'
                ]"
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M4 3m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                  <path d="M8 7m0 1a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-6a1 1 0 0 1 -1 -1z" />
                  <path d="M8 14l0 .01" />
                  <path d="M12 14l0 .01" />
                  <path d="M16 14l0 .01" />
                  <path d="M8 17l0 .01" />
                  <path d="M12 17l0 .01" />
                  <path d="M16 17l0 .01" />
                </svg>
                <span>Contabilidad</span>
              </Link>
            </li>
          </ul>
        </nav>
        <nav id="menu" class="space-y-1" role="navigation">
          <ul class="space-y-1">
            <li>
              <Link 
                href="/auto-update" 
                :class="[
                  'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors',
                  isActive(['auto-update']) 
                    ? 'bg-blue-50 text-blue-700 font-medium' 
                    : 'text-gray-700 hover:bg-gray-100'
                ]"
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M7 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                  <path d="M7 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                  <path d="M17 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                  <path d="M7 8l0 8" />
                  <path d="M9 18h6a2 2 0 0 0 2 -2v-5" />
                  <path d="M14 14l3 -3l3 3" />
                </svg>
                <span>Actualización</span>
              </Link>
            </li>
          </ul>
        </nav>
        <nav id="menu" class="space-y-1" role="navigation">
          <ul class="space-y-1">
            <li>
              <Link 
                href="/backup" 
                :class="[
                  'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors',
                  isActive(['backup']) 
                    ? 'bg-blue-50 text-blue-700 font-medium' 
                    : 'text-gray-700 hover:bg-gray-100'
                ]"
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M12 18.004h-5.343c-2.572 -.004 -4.657 -2.011 -4.657 -4.487c0 -2.475 2.085 -4.482 4.657 -4.482c.393 -1.762 1.794 -3.2 3.675 -3.773c1.88 -.572 3.956 -.193 5.444 1c1.488 1.19 2.162 3.007 1.77 4.769h.99c1.38 0 2.573 .813 3.13 1.99" />
                  <path d="M19 16v6" />
                  <path d="M22 19l-3 3l-3 -3" />
                </svg>
                <span>Backup</span>
              </Link>
            </li>
          </ul>
        </nav>
        <nav id="menu" class="space-y-1" role="navigation">
          <ul class="space-y-1">
            <li>
              <Link 
                href="/information" 
                :class="[
                  'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors',
                  isActive(['information']) 
                    ? 'bg-blue-50 text-blue-700 font-medium' 
                    : 'text-gray-700 hover:bg-gray-100'
                ]"
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" />
                  <path d="M12 9h.01" />
                  <path d="M11 12h1v4h1" />
                </svg>
                <span>Información</span>
              </Link>
            </li>
          </ul>
        </nav>
        <nav id="menu" class="space-y-1" role="navigation">
          <ul class="space-y-1">
            <li>
              <a href="/logs" target="_BLANK" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors text-gray-700 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M9 9v-1a3 3 0 0 1 6 0v1" />
                  <path d="M8 9h8a6 6 0 0 1 1 3v3a5 5 0 0 1 -10 0v-3a6 6 0 0 1 1 -3" />
                  <path d="M3 13l4 0" />
                  <path d="M17 13l4 0" />
                  <path d="M12 20l0 -6" />
                  <path d="M4 19l3.35 -2" />
                  <path d="M20 19l-3.35 -2" />
                  <path d="M4 7l3.75 2.4" />
                  <path d="M20 7l-3.75 2.4" />
                </svg>
                <span>Logs</span>
              </a>
            </li>
          </ul>
        </nav>
        <nav id="menu" class="pb-2 space-y-1" role="navigation">
          <ul class="space-y-1">
        <li>
          <Link 
            href="/reports" 
            :class="[
              'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors',
              isActive(['reports']) 
                ? 'bg-blue-50 text-blue-700 font-medium' 
                : 'text-gray-700 hover:bg-gray-100'
            ]"
          >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                  <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                  <path d="M9 17v-5" />
                  <path d="M12 17v-1" />
                  <path d="M15 17v-3" />
                </svg>
                <span>Reportes</span>
              </Link>
            </li>
          </ul>
        </nav>
      </div>
    </div>
    <nav id="menu" class="configuration-nav pt-0 px-2 space-y-1" role="navigation">
      <ul class="space-y-1">
        <li>
          <Link 
            href="/configurations" 
            :class="[
              'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors',
              isActive(['configurations']) 
                ? 'bg-blue-50 text-blue-700 font-medium' 
                : 'text-gray-700 hover:bg-gray-100'
            ]"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
              <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
            </svg>
            <span>Configuración</span>
          </Link>
        </li>
      </ul>
    </nav>
  </aside>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { onMounted } from 'vue'
import { route as ziggyRoute } from 'ziggy-js'

const page = usePage()

// Función route protegida
const route = (name, params = {}) => {
  try {
    return ziggyRoute(name, params)
  } catch (e) {
    console.warn(`Ruta "${name}" no encontrada:`, e)
    return '#'
  }
}

const multiUserEnabled = computed(() => {
  try {
    return page.props?.configuration?.multi_user_enabled || false
  } catch (e) {
    console.warn('Error al acceder a multiUserEnabled:', e)
    return false
  }
})

const isActive = (paths) => {
  try {
    const currentPath = page.url?.split('/').filter(Boolean) || []
    return paths.some(path => currentPath.includes(path))
  } catch (e) {
    console.warn('Error en isActive:', e)
    return false
  }
}

onMounted(() => {
  // Inicializar menú colapsable
  document.querySelectorAll('#sidebar-left nav ul > li > a').forEach(function(anchor) {
    const next = anchor.nextElementSibling
    if (next && next.tagName === 'UL') {
      anchor.classList.add('menu-collapse')
      anchor.setAttribute('aria-expanded', 'false')
      next.classList.add('submenu', 'hidden')
      const chevron = document.createElement('i')
      chevron.className = 'fas fa-chevron-down ml-auto text-gray-500 text-xs'
      anchor.appendChild(chevron)
      const hasActive = next.querySelector('li.nav-active')
      if (hasActive) {
        next.classList.remove('hidden')
        anchor.setAttribute('aria-expanded', 'true')
        chevron.classList.add('rotate-180')
      }
      anchor.addEventListener('click', function(e) {
        e.preventDefault()
        const isOpen = next.classList.toggle('hidden') === false
        anchor.setAttribute('aria-expanded', isOpen ? 'true' : 'false')
        chevron.classList.toggle('rotate-180', isOpen)
      })
    }
  })
})
</script>

<style scoped>
/* Scrollbar personalizado para el sidebar */
#sidebar-left::-webkit-scrollbar {
  width: 6px;
}

#sidebar-left::-webkit-scrollbar-track {
  background: transparent;
}

#sidebar-left::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 3px;
}

#sidebar-left::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}

/* Estilos para navegación activa */
.nav-active {
  background-color: #eff6ff;
  color: #1d4ed8;
  font-weight: 500;
}
</style>

