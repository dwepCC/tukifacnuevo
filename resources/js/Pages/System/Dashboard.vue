<template>
  <SystemLayout title="Dashboard">
    <!-- Componente de clientes -->
    <SystemClientsIndex
      :delete-permission="deletePermission"
      :disc-used="discUsed"
      :i-used="iUsed"
      :storage-size="storageSize"
      :version="version"
    />
    
    <!-- Resto del contenido del dashboard -->
    <div class="card mt-4">
      <div class="card-header bg-info bg-info-customer-admin">
        <span>Listado de Pagos Pendientes de Aprobación</span>
        <span class="badge badge-light" id="pending-count">{{ pendingCount }} pendientes</span>
      </div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-6">
            <h5 class="card-title">Pagos en espera de confirmación</h5>
            <p class="text-muted">Estos pagos requieren tu revisión y aprobación</p>
          </div>
        </div>
        <!-- Tabla de pagos pendientes -->
        <div id="pending-payments-container">
          <!-- Se cargará dinámicamente -->
        </div>
      </div>
    </div>
  </SystemLayout>
</template>

<script setup>
import SystemLayout from '@/Layouts/SystemLayout.vue'
import SystemClientsIndex from '@/views/system/clients/index.vue'
import { ref, onMounted } from 'vue'

defineProps({
  clients: Number,
  deletePermission: Boolean,
  discUsed: [String, Number],
  iUsed: [String, Number],
  storageSize: [String, Number],
  version: String,
})

const pendingCount = ref(0)

onMounted(() => {
  // Cargar pagos pendientes
  loadPendingPayments()
})

const loadPendingPayments = () => {
  // Lógica para cargar pagos pendientes
  // Similar a la función en dashboard.blade.php
  if (window.$ && window.jQuery) {
    const $ = window.$ || window.jQuery
    // Tu código jQuery aquí si es necesario
  }
}
</script>

