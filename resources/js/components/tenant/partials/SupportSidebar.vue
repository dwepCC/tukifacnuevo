<template>
  <div 
    v-show="isOpen"
    id="supportSidebar" 
    class="fixed inset-y-0 right-0 w-80 bg-white shadow-xl transform transition-transform duration-300 z-50"
    :class="isOpen ? 'translate-x-0' : 'translate-x-full'"
  >
    <div class="h-full flex flex-col">
      <!-- Header -->
      <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white">
        <h3 class="text-lg font-semibold text-gray-800">Soporte al Cliente</h3>
        <button 
          @click="$emit('close')"
          class="text-gray-500 hover:text-gray-700 transition-colors duration-200"
        >
          <i class="fas fa-times text-xl"></i>
        </button>
      </div>

      <!-- Body -->
      <div class="flex-1 overflow-y-auto p-6">
        <div v-if="supportUser?.introduction" class="mb-6 p-4 bg-blue-50 rounded-lg">
          <div class="text-sm text-gray-700" v-html="supportUser.introduction"></div>
        </div>

        <div class="space-y-4">
          <!-- WhatsApp -->
          <div v-if="supportUser?.whatsapp_number" class="flex items-start gap-4 p-4 border border-green-100 rounded-lg bg-green-50">
            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
              <i class="fab fa-whatsapp text-green-600 text-xl"></i>
            </div>
            <div>
              <h4 class="font-semibold text-gray-800 mb-1">WhatsApp</h4>
              <a 
                :href="`https://wa.me/${supportUser.whatsapp_number.replace(/[^0-9]/g, '')}`"
                target="_blank"
                rel="noopener noreferrer"
                class="text-green-600 hover:text-green-700 font-medium text-lg"
              >
                {{ supportUser.whatsapp_number }}
              </a>
              <p class="text-sm text-gray-600 mt-1">Soporte inmediato</p>
            </div>
          </div>

          <!-- Phone -->
          <div v-if="supportUser?.phone" class="flex items-start gap-4 p-4 border border-orange-100 rounded-lg bg-orange-50">
            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center">
              <i class="fas fa-phone text-orange-600 text-xl"></i>
            </div>
            <div>
              <h4 class="font-semibold text-gray-800 mb-1">Teléfono</h4>
              <a :href="`tel:${supportUser.phone}`" class="text-orange-600 hover:text-orange-700 font-medium text-lg">
                {{ supportUser.phone }}
              </a>
              <p class="text-sm text-gray-600 mt-1">Llamada directa</p>
            </div>
          </div>

          <!-- Email/Address -->
          <div v-if="supportUser?.address_contact" class="flex items-start gap-4 p-4 border border-blue-100 rounded-lg bg-blue-50">
            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
              <i class="fas fa-envelope text-blue-600 text-xl"></i>
            </div>
            <div>
              <h4 class="font-semibold text-gray-800 mb-1">Correo Electrónico</h4>
              <a 
                :href="`mailto:${supportUser.address_contact}`"
                target="_blank"
                class="text-blue-600 hover:text-blue-700 font-medium text-lg"
              >
                {{ supportUser.address_contact }}
              </a>
              <p class="text-sm text-gray-600 mt-1">Soporte por correo</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Overlay -->
    <div 
      v-if="isOpen"
      id="supportBackdrop"
      class="fixed inset-0 bg-black bg-opacity-50 z-40 transition-opacity duration-300"
      @click="$emit('close')"
    ></div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

defineProps({
  isOpen: {
    type: Boolean,
    default: false
  }
})

defineEmits(['close'])

const page = usePage()
const supportUser = computed(() => page.props.support_user || null)
</script>

<style scoped>
#supportSidebar {
  box-shadow: -4px 0 6px rgba(0, 0, 0, 0.1);
}
</style>

