<template>
  <TenantLayout title="Listado de comprobantes">
    <tenant-documents-index
      :isClient="is_client"
      :import_documents="import_documents"
      :import_documents_second="import_documents_second"
      :document_import_excel="document_import_excel"
      :configuration="configuration"
      :view_apiperudev_validator_cpe="view_apiperudev_validator_cpe"
      :view_validator_cpe="view_validator_cpe"
    />
  </TenantLayout>
</template>

<script setup>
import TenantLayout from '@/Layouts/TenantLayout.vue'

defineProps({
  is_client: {
    type: Boolean,
    default: false
  },
  import_documents: {
    type: Boolean,
    default: false
  },
  import_documents_second: {
    type: Boolean,
    default: false
  },
  document_import_excel: {
    type: Boolean,
    default: false
  },
  configuration: {
    type: Object,
    default: () => ({})
  },
  view_apiperudev_validator_cpe: {
    type: Boolean,
    default: false
  },
  view_validator_cpe: {
    type: Boolean,
    default: false
  }
})
</script>

