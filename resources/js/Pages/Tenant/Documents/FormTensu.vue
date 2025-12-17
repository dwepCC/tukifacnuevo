<template>
  <TenantLayout title="Nuevo comprobante (Tensu)">
    <tenant-documents-invoicetensu
      :is-contingency="isContingency"
    />
  </TenantLayout>
</template>

<script setup>
import TenantLayout from '@/Layouts/TenantLayout.vue'

defineProps({
  is_contingency: {
    type: Number,
    default: 0
  }
})
</script>

