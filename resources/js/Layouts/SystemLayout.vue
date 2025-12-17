<template>
  <div class="min-h-screen bg-gray-50">
    <Head :title="title" />
    
    <!-- Header -->
    <SystemHeader />
    
    <div class="flex">
      <!-- Sidebar -->
      <SystemSidebar />
      
      <!-- Main Content -->
      <main class="flex-1 ml-64 mt-16 transition-all duration-300" id="main-wrapper">
        <div class="p-6">
          <slot />
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import SystemHeader from '@/components/system/SystemHeader.vue'
import SystemSidebar from '@/components/system/SystemSidebar.vue'

defineProps({
  title: {
    type: String,
    default: 'Sistema'
  }
})
</script>

