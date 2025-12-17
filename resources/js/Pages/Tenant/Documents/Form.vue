<template>
  <TenantLayout :title="isUpdate ? 'Editar comprobante' : 'Nuevo comprobante'">
    <tenant-documents-invoice
      :configuration="configuration"
      :documentId="document_id"
      :isUpdate="is_update"
    />
  </TenantLayout>
</template>

<script setup>
import TenantLayout from '@/Layouts/TenantLayout.vue'

defineProps({
  is_contingency: {
    type: Number,
    default: 0
  },
  configuration: {
    type: Object,
    default: () => ({})
  },
  is_update: {
    type: Boolean,
    default: false
  },
  document_id: {
    type: [String, Number],
    default: null
  }
})
</script>

