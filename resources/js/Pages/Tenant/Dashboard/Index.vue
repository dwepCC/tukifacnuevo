<template>
  <TenantLayout title="Admin Dashboard">
    <div class="dashboard-container">
      <!-- Aquí va el contenido del dashboard -->
      <tenant-dashboard-index
        :type-user="type_user"
        :soap-company="soap_company"
        :configuration="configuration"
      />
    </div>
  </TenantLayout>
</template>

<script setup>
import TenantLayout from '@/Layouts/TenantLayout.vue'

defineProps({
  soap_company: {
    type: String,
    default: null
  },
  configuration: {
    type: Object,
    default: () => ({})
  },
  type_user: {
    type: String,
    default: ''
  }
})
</script>

<style scoped>
.dashboard-container {
  width: 100%;
}
</style>

