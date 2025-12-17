<template>
  <aside 
    id="sidebar-left"
    :class="[
      'fixed left-0 top-0 h-screen bg-white text-gray-900 border-r border-gray-200 flex flex-col transition-all duration-300 z-40 overflow-y-auto',
      isCollapsed ? 'md:w-16' : 'md:w-64',
      isMobileOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'
    ]"
  >
    <!-- Logo Section -->
    <div class="flex items-center justify-between px-4 py-3">
      <Link 
        :href="route('tenant.dashboard.inicio')" 
        class="hidden md:inline-flex items-center"
      >
        <img 
          class="sidebar-logo-full h-10 md:h-12 w-auto max-w-[180px] object-contain"
          src="/logo/Tukifac-large-ver-2.webp" 
          alt="Logo" 
        />
        <img 
          class="sidebar-logo-mini hidden h-8 w-8 object-contain"
          src="/logo/logo.jpg" 
          alt="Logo mini" 
        />
      </Link>
      <button
        @click="$emit('close-mobile')"
        class="md:hidden inline-flex items-center justify-center text-gray-400 hover:text-white transition-colors"
        type="button"
      >
        <i class="fas fa-times"></i>
      </button>
    </div>
    
    <!-- Company Name -->
    <span class="px-4 py-2 text-xs font-semibold tracking-wide uppercase text-gray-300 sidebar-text">
      {{ companyName }}
    </span>
    
    <!-- Menu Navigation -->
    <div class="flex-1 overflow-y-auto">
      <div class="px-2">
        <nav id="menu" class="space-y-1 [&_a]:transition-colors [&_a]:duration-150 [&_a]:text-sm" role="navigation">
          <ul class="space-y-1">
            <!-- Dashboard -->
            <template v-if="hasModule('dashboard')">
              <li>
                <Link 
                  :href="route('tenant.dashboard.inicio')"
                  :class="[
                    'flex items-center gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm',
                    isActive('inicio') ? 'bg-green-600 text-white hover:bg-green-700' : 'text-gray-700 hover:bg-gray-100'
                  ]"
                >
                  <i class="fas fa-home sidebar-icon text-[20px]"></i>
                  <span class="sidebar-text">Inicio</span>
                </Link>
              </li>
              <li>
                <Link 
                  :href="route('tenant.dashboard.index')"
                  :class="[
                    'flex items-center gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm',
                    isActive('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100'
                  ]"
                >
                  <i class="fas fa-tachometer-alt sidebar-icon text-[20px]"></i>
                  <span class="sidebar-text">Admin dashboard</span>
                </Link>
              </li>
            </template>

            <!-- Preventa -->
            <li v-if="hasModule('preventa')">
              <a 
                @click.prevent="toggleSection('preventa')"
                :class="[
                  'flex items-center justify-between gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                  isSectionActive(['sale-opportunities', 'quotations', 'contracts', 'order-notes', 'technical-services']) 
                    ? 'bg-gray-800 text-white' 
                    : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <div class="flex items-center gap-2">
                  <i class="fas fa-edit sidebar-icon text-[20px]"></i>
                  <span class="sidebar-text">Preventa</span>
                </div>
                <i 
                  :class="[
                    'fas fa-chevron-down ml-auto text-gray-500 text-xs transition-transform',
                    expandedSections.preventa ? 'rotate-180' : ''
                  ]"
                ></i>
              </a>
              <ul 
                :class="[
                  'ml-4 mt-1 space-y-1',
                  expandedSections.preventa || isSectionActive(['sale-opportunities', 'quotations', 'contracts', 'order-notes', 'technical-services']) ? 'block' : 'hidden'
                ]"
              >
                <li v-if="hasModuleLevel('sale-opportunity')">
                  <Link 
                    :href="route('tenant.sale_opportunities.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('sale-opportunities') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100'
                    ]"
                  >
                    Oportunidad de venta
                  </Link>
                </li>
                <li v-if="hasModuleLevel('quotations')">
                  <Link 
                    :href="route('tenant.quotations.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('quotations') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100'
                    ]"
                  >
                    Cotizaciones
                  </Link>
                </li>
                <li v-if="hasModuleLevel('contracts')">
                  <Link 
                    :href="route('tenant.contracts.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('contracts') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100'
                    ]"
                  >
                    Contratos
                  </Link>
                </li>
                <li v-if="hasModuleLevel('order-note')">
                  <Link 
                    :href="route('tenant.order_notes.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('order-notes') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Pedidos
                  </Link>
                </li>
                <li v-if="hasModuleLevel('technical-service')">
                  <Link 
                    :href="route('tenant.technical_services.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('technical-services') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Servicio de soporte técnico
                  </Link>
                </li>
              </ul>
            </li>

            <!-- Ventas -->
            <li v-if="hasModule('documents')">
              <a 
                @click.prevent="toggleSection('ventas')"
                :class="[
                  'flex items-center justify-between gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                  isVentasActive() 
                    ? 'bg-gray-800 text-white' 
                    : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <div class="flex items-center gap-2">
                  <i class="fas fa-file-alt sidebar-icon text-[20px]"></i>
                  <span class="sidebar-text">Ventas</span>
                </div>
                <i 
                  :class="[
                    'fas fa-chevron-down ml-auto text-gray-500 text-xs transition-transform',
                    expandedSections.ventas || isVentasActive() ? 'rotate-180' : ''
                  ]"
                ></i>
              </a>
              <ul 
                :class="[
                  'ml-4 mt-1 space-y-1',
                  expandedSections.ventas || isVentasActive() ? 'block' : 'hidden'
                ]"
              >
                <li v-if="userType !== 'integrator' && companySoapTypeId !== '03' && hasModuleLevel('new_document')">
                  <Link 
                    :href="route('tenant.documents.create')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('documents', 'create') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Nuevo Comprobante
                  </Link>
                </li>
                <li v-if="hasModule('documents') && companySoapTypeId !== '03' && hasModuleLevel('list_document')">
                  <Link 
                    :href="route('tenant.documents.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('documents') && !isActive('documents', 'create') && !isActive('documents', 'not-sent') && !isActive('documents', 'regularize-shipping') 
                        ? 'bg-gray-800 text-white' 
                        : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Consulta de comprobantes
                  </Link>
                </li>
                <li v-if="hasModuleLevel('sale_notes')">
                  <Link 
                    :href="route('tenant.sale_notes.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('sale-notes') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Notas de Venta
                  </Link>
                </li>
                <li v-if="hasModuleLevel('pos')">
                  <Link 
                    :href="route('tenant.pos.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('pos') && !isActive('pos', 'garage') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Punto de venta
                  </Link>
                </li>
                <li v-if="hasModuleLevel('pos_garage')">
                  <Link 
                    :href="route('tenant.pos.garage')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('pos', 'garage') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Venta rápida <span style="font-size:.65rem;">(Grifos y Markets)</span>
                  </Link>
                </li>
              </ul>
            </li>

            <!-- Compras -->
            <li v-if="userType !== 'integrator' && hasModule('purchases')">
              <a 
                @click.prevent="toggleSection('compras')"
                :class="[
                  'flex items-center justify-between gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                  isSectionActive(['purchases', 'persons', 'expenses', 'purchase-quotations', 'purchase-orders', 'fixed-asset'], 'suppliers') || 
                  isSectionActive(['purchases', 'expenses', 'purchase-quotations', 'purchase-orders', 'fixed-asset'])
                    ? 'bg-gray-800 text-white' 
                    : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <div class="flex items-center gap-2">
                  <i class="fas fa-shopping-bag sidebar-icon text-[20px]"></i>
                  <span class="sidebar-text">Compras</span>
                </div>
                <i 
                  :class="[
                    'fas fa-chevron-down ml-auto text-gray-500 text-xs transition-transform',
                    expandedSections.compras || isSectionActive(['purchases', 'persons', 'expenses', 'purchase-quotations', 'purchase-orders', 'fixed-asset'], 'suppliers') ? 'rotate-180' : ''
                  ]"
                ></i>
              </a>
              <ul 
                :class="[
                  'ml-4 mt-1 space-y-1',
                  expandedSections.compras || isSectionActive(['purchases', 'persons', 'expenses', 'purchase-quotations', 'purchase-orders', 'fixed-asset'], 'suppliers') || 
                  isSectionActive(['purchases', 'expenses', 'purchase-quotations', 'purchase-orders', 'fixed-asset']) ? 'block' : 'hidden'
                ]"
              >
                <li v-if="hasModuleLevel('purchases_create')">
                  <Link 
                    :href="route('tenant.purchases.create')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('purchases', 'create') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Nuevo
                  </Link>
                </li>
                <li v-if="hasModuleLevel('purchases_list')">
                  <Link 
                    :href="route('tenant.purchases.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('purchases') && !isActive('purchases', 'create') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Listado
                  </Link>
                </li>
                <li v-if="hasModuleLevel('purchases_orders')">
                  <Link 
                    :href="route('tenant.purchase-orders.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('purchase-orders') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Ordenes de compra
                  </Link>
                </li>
                <li v-if="hasModuleLevel('purchases_expenses')">
                  <Link 
                    :href="route('tenant.expenses.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('expenses') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Gastos diversos
                  </Link>
                </li>
                <li v-if="hasModuleLevel('purchases_suppliers')">
                  <Link 
                    :href="route('tenant.persons.index', { type: 'suppliers' })"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('persons', 'suppliers') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Proveedores
                  </Link>
                </li>
                <li v-if="hasModuleLevel('purchases_quotations')">
                  <Link 
                    :href="route('tenant.purchase-quotations.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('purchase-quotations') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Solicitar cotización
                  </Link>
                </li>
                <li v-if="hasModuleLevel('purchases_fixed_assets_items')">
                  <Link 
                    :href="route('tenant.fixed_asset_items.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('fixed-asset', 'items') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Activos fijos
                  </Link>
                </li>
                <li v-if="hasModuleLevel('purchases_fixed_assets_purchases')">
                  <Link 
                    :href="route('tenant.fixed_asset_purchases.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('fixed-asset', 'purchases') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Comprar activo fijo
                  </Link>
                </li>
              </ul>
            </li>

            <!-- Clientes -->
            <li v-if="userType !== 'integrator' && hasModule('persons')">
              <a 
                @click.prevent="toggleSection('clientes')"
                :class="[
                  'flex items-center justify-between gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                  isSectionActive(['persons', 'person-types', 'agents'], 'customers')
                    ? 'bg-gray-800 text-white' 
                    : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <div class="flex items-center gap-2">
                  <i class="fas fa-user sidebar-icon text-[20px]"></i>
                  <span class="sidebar-text">Clientes</span>
                </div>
                <i 
                  :class="[
                    'fas fa-chevron-down ml-auto text-gray-500 text-xs transition-transform',
                    expandedSections.clientes || isSectionActive(['persons', 'person-types', 'agents'], 'customers') ? 'rotate-180' : ''
                  ]"
                ></i>
              </a>
              <ul 
                :class="[
                  'ml-4 mt-1 space-y-1',
                  expandedSections.clientes || isSectionActive(['persons', 'person-types', 'agents'], 'customers') ? 'block' : 'hidden'
                ]"
              >
                <li v-if="hasModuleLevel('clients')">
                  <Link 
                    :href="route('tenant.persons.index', { type: 'customers' })"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('persons', 'customers') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Clientes
                  </Link>
                </li>
                <li v-if="hasModuleLevel('clients_types')">
                  <Link 
                    :href="route('tenant.person_types.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('person-types') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Tipos de clientes
                  </Link>
                </li>
                <li v-if="configuration?.enabled_sales_agents">
                  <Link 
                    :href="route('tenant.agents.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('agents') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Agentes
                  </Link>
                </li>
              </ul>
            </li>

            <!-- Productos/Servicios -->
            <li v-if="userType !== 'integrator' && hasModule('items')">
              <a 
                @click.prevent="toggleSection('productos')"
                :class="[
                  'flex items-center justify-between gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                  isSectionActive(['items', 'services', 'categories', 'brands', 'item-lots', 'item-sets'])
                    ? 'bg-gray-800 text-white' 
                    : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <div class="flex items-center gap-2">
                  <i class="fas fa-th-large sidebar-icon text-[20px]"></i>
                  <span class="sidebar-text">Productos/Servicios</span>
                </div>
                <i 
                  :class="[
                    'fas fa-chevron-down ml-auto text-gray-500 text-xs transition-transform',
                    expandedSections.productos || isSectionActive(['items', 'services', 'categories', 'brands', 'item-lots', 'item-sets']) ? 'rotate-180' : ''
                  ]"
                ></i>
              </a>
              <ul 
                :class="[
                  'ml-4 mt-1 space-y-1',
                  expandedSections.productos || isSectionActive(['items', 'services', 'categories', 'brands', 'item-lots', 'item-sets']) ? 'block' : 'hidden'
                ]"
              >
                <li v-if="hasModuleLevel('items')">
                  <Link 
                    :href="route('tenant.items.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('items') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Productos
                  </Link>
                </li>
                <li v-if="hasModuleLevel('items_packs')">
                  <Link 
                    :href="route('tenant.item_sets.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('item-sets') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Conjuntos/Packs/Promociones
                  </Link>
                </li>
                <li v-if="hasModuleLevel('items_services')">
                  <Link 
                    :href="route('tenant.services')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('services') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Servicios
                  </Link>
                </li>
                <li v-if="hasModuleLevel('items_categories')">
                  <Link 
                    :href="route('tenant.categories.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('categories') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Categorías
                  </Link>
                </li>
                <li v-if="hasModuleLevel('items_brands')">
                  <Link 
                    :href="route('tenant.brands.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('brands') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Marcas
                  </Link>
                </li>
                <li v-if="hasModuleLevel('items_lots')">
                  <Link 
                    :href="route('tenant.item-lots.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('item-lots') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Series
                  </Link>
                </li>
              </ul>
            </li>

            <!-- Inventario -->
            <li v-if="userType !== 'integrator' && hasModule('inventory')">
              <a 
                @click.prevent="toggleSection('inventario')"
                :class="[
                  'flex items-center justify-between gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                  isSectionActive(['inventory', 'moves', 'transfers', 'devolutions', 'extra_info_items', 'inventory-review']) || 
                  isReportsActive(['kardex', 'inventory', 'valued-kardex'])
                    ? 'bg-gray-800 text-white' 
                    : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <div class="flex items-center gap-2">
                  <i class="fas fa-warehouse sidebar-icon text-[20px]"></i>
                  <span class="sidebar-text">Inventario</span>
                </div>
                <i 
                  :class="[
                    'fas fa-chevron-down ml-auto text-gray-500 text-xs transition-transform',
                    expandedSections.inventario || isSectionActive(['inventory', 'moves', 'transfers', 'devolutions', 'extra_info_items', 'inventory-review']) || 
                    isReportsActive(['kardex', 'inventory', 'valued-kardex']) ? 'rotate-180' : ''
                  ]"
                ></i>
              </a>
              <ul 
                :class="[
                  'ml-4 mt-1 space-y-1',
                  expandedSections.inventario || isSectionActive(['inventory', 'moves', 'transfers', 'devolutions', 'extra_info_items', 'inventory-review']) || 
                  isReportsActive(['kardex', 'inventory', 'valued-kardex']) ? 'block' : 'hidden'
                ]"
              >
                <li v-if="hasModuleLevel('inventory')">
                  <Link 
                    href="/inventory"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('inventory') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Movimientos
                  </Link>
                </li>
                <li v-if="hasModuleLevel('inventory_transfers')">
                  <Link 
                    href="/transfers"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('transfers') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Traslados
                  </Link>
                </li>
                <li v-if="hasModuleLevel('inventory_devolutions')">
                  <Link 
                    href="/devolutions"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('devolutions') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Devolucion a proveedor
                  </Link>
                </li>
                <li v-if="hasModuleLevel('inventory_report_kardex')">
                  <Link 
                    href="/reports/kardex"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('reports', 'kardex') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Reporte Kardex
                  </Link>
                </li>
                <li v-if="hasModuleLevel('inventory_report')">
                  <Link 
                    href="/reports/inventory"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('reports', 'inventory') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Reporte Inventario
                  </Link>
                </li>
                <li v-if="hasModuleLevel('inventory_report_valued_kardex')">
                  <Link 
                    href="/reports/valued-kardex"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('reports', 'valued-kardex') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Kardex valorizado
                  </Link>
                </li>
                <li v-if="hasModule('production_app') && configuration?.isShowExtraInfoToItem?.()">
                  <Link 
                    href="/extra_info_items"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('extra_info_items') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Datos extra de items
                  </Link>
                </li>
                <li v-if="inventoryConfiguration.inventory_review">
                  <Link 
                    :href="route('tenant.inventory-review.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('inventory-review') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Revisión de inventario
                  </Link>
                </li>
              </ul>
            </li>

            <!-- Finanzas -->
            <li v-if="hasModule('finance')">
              <a 
                @click.prevent="toggleSection('finanzas')"
                :class="[
                  'flex items-center justify-between gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                  isSectionActive(['finances', 'cash', 'bank_loan'], ['global-payments', 'balance', 'payment-method-types', 'unpaid', 'to-pay', 'income', 'transactions', 'movements'])
                    ? 'bg-gray-800 text-white' 
                    : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <div class="flex items-center gap-2">
                  <i class="fas fa-wallet sidebar-icon text-[20px]"></i>
                  <span class="sidebar-text">Finanzas</span>
                </div>
                <i 
                  :class="[
                    'fas fa-chevron-down ml-auto text-gray-500 text-xs transition-transform',
                    expandedSections.finanzas || isSectionActive(['finances', 'cash', 'bank_loan'], ['global-payments', 'balance', 'payment-method-types', 'unpaid', 'to-pay', 'income', 'transactions', 'movements']) ? 'rotate-180' : ''
                  ]"
                ></i>
              </a>
              <ul 
                :class="[
                  'ml-4 mt-1 space-y-1',
                  expandedSections.finanzas || isSectionActive(['finances', 'cash', 'bank_loan'], ['global-payments', 'balance', 'payment-method-types', 'unpaid', 'to-pay', 'income', 'transactions', 'movements']) ? 'block' : 'hidden'
                ]"
              >
                <li v-if="hasModuleLevel('cash')">
                  <Link 
                    :href="route('tenant.cash.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('cash') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Caja chica
                  </Link>
                </li>
                <li v-if="hasModuleLevel('finances_movements')">
                  <Link 
                    :href="route('tenant.finances.movements.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('finances', 'movements') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Movimientos
                  </Link>
                </li>
                <li v-if="hasModuleLevel('finances_movements')">
                  <Link 
                    :href="route('tenant.finances.transactions.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('finances', 'transactions') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Transacciones
                  </Link>
                </li>
                <li v-if="hasModuleLevel('finances_incomes')">
                  <Link 
                    :href="route('tenant.finances.income.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('finances', 'income') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Ingresos
                  </Link>
                </li>
                <li v-if="hasModuleLevel('finances_unpaid')">
                  <Link 
                    :href="route('tenant.finances.unpaid.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('finances', 'unpaid') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Cuentas por cobrar
                  </Link>
                </li>
                <li v-if="hasModuleLevel('finances_to_pay')">
                  <Link 
                    :href="route('tenant.finances.to_pay.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('finances', 'to-pay') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Cuentas por pagar
                  </Link>
                </li>
                <li v-if="hasModuleLevel('finances_payments')">
                  <Link 
                    :href="route('tenant.finances.global_payments.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('finances', 'global-payments') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Pagos
                  </Link>
                </li>
                <li v-if="hasModuleLevel('finances_balance')">
                  <Link 
                    :href="route('tenant.finances.balance.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('finances', 'balance') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Balance
                  </Link>
                </li>
                <li v-if="hasModuleLevel('finances_payment_method_types')">
                  <Link 
                    :href="route('tenant.finances.payment_method_types.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('finances', 'payment-method-types') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Ingresos y Egresos - M. Pago
                  </Link>
                </li>
                <li v-if="hasModuleLevel('purchases_expenses')">
                  <Link 
                    :href="route('tenant.bank_loan.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('bank_loan') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Credito Bancario
                  </Link>
                </li>
              </ul>
            </li>

            <!-- Guías de remisión -->
            <li v-if="hasModule('guia') && companySoapTypeId !== '03'">
              <a 
                @click.prevent="toggleSection('guias')"
                :class="[
                  'flex items-center justify-between gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                  isSectionActive(['dispatches', 'drivers', 'dispatchers', 'transports', 'dispatch_carrier', 'dispatch_addresses'])
                    ? 'bg-gray-800 text-white' 
                    : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <div class="flex items-center gap-2">
                  <i class="fas fa-truck sidebar-icon text-[20px]"></i>
                  <span class="sidebar-text">Guías de remisión</span>
                </div>
                <i 
                  :class="[
                    'fas fa-chevron-down ml-auto text-gray-500 text-xs transition-transform',
                    expandedSections.guias || isSectionActive(['dispatches', 'drivers', 'dispatchers', 'transports', 'dispatch_carrier', 'dispatch_addresses']) ? 'rotate-180' : ''
                  ]"
                ></i>
              </a>
              <ul 
                :class="[
                  'ml-4 mt-1 space-y-1',
                  expandedSections.guias || isSectionActive(['dispatches', 'drivers', 'dispatchers', 'transports', 'dispatch_carrier', 'dispatch_addresses']) ? 'block' : 'hidden'
                ]"
              >
                <li v-if="hasModuleLevel('dispatches')">
                  <Link 
                    :href="route('tenant.dispatches.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('dispatches') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    G.R. Remitente
                  </Link>
                </li>
                <li v-if="hasModuleLevel('dispatch_carrier')">
                  <Link 
                    :href="route('tenant.dispatch_carrier.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('dispatch_carrier') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    G.R. Transportista
                  </Link>
                </li>
                <li v-if="hasModuleLevel('dispatchers')">
                  <Link 
                    :href="route('tenant.dispatchers.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('dispatchers') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Transportistas
                  </Link>
                </li>
                <li v-if="hasModuleLevel('drivers')">
                  <Link 
                    :href="route('tenant.drivers.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('drivers') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Conductores
                  </Link>
                </li>
                <li v-if="hasModuleLevel('transports')">
                  <Link 
                    :href="route('tenant.transports.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('transports') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Vehículos
                  </Link>
                </li>
              </ul>
            </li>

            <!-- Comprobantes pendientes -->
            <li v-if="hasModule('comprobante')">
              <a 
                @click.prevent="toggleSection('comprobantes')"
                :class="[
                  'flex items-center justify-between gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                  isActive('documents', 'not-sent') || isActive('documents', 'regularize-shipping') || isActive('summaries') || isActive('voided')
                    ? 'bg-gray-800 text-white' 
                    : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <div class="flex items-center gap-2">
                  <i class="fas fa-file-alt sidebar-icon text-[20px]"></i>
                  <span class="sidebar-text">Comprobantes pendientes</span>
                </div>
                <i 
                  :class="[
                    'fas fa-chevron-down ml-auto text-gray-500 text-xs transition-transform',
                    expandedSections.comprobantes || isActive('documents', 'not-sent') || isActive('documents', 'regularize-shipping') || isActive('summaries') || isActive('voided') ? 'rotate-180' : ''
                  ]"
                ></i>
              </a>
              <ul 
                :class="[
                  'ml-4 mt-1 space-y-1',
                  expandedSections.comprobantes || isActive('documents', 'not-sent') || isActive('documents', 'regularize-shipping') || isActive('summaries') || isActive('voided') ? 'block' : 'hidden'
                ]"
              >
                <template v-if="hasModule('comprobante') && companySoapTypeId !== '03'">
                  <li v-if="hasModuleLevel('document_not_sent')">
                    <Link 
                      :href="route('tenant.documents.not_sent')"
                      :class="[
                        'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                        isActive('documents', 'not-sent') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                      ]"
                    >
                      Comprobantes no enviados
                    </Link>
                  </li>
                  <li v-if="hasModuleLevel('regularize_shipping')">
                    <Link 
                      :href="route('tenant.documents.regularize_shipping')"
                      :class="[
                        'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                        isActive('documents', 'regularize-shipping') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                      ]"
                    >
                      CPE pendientes de rectificación
                    </Link>
                  </li>
                </template>
                <template v-if="hasModuleLevel('summary_voided') && companySoapTypeId !== '03'">
                  <li>
                    <Link 
                      :href="route('tenant.summaries.index')"
                      :class="[
                        'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                        isActive('summaries') ? 'bg-gray-800 text-white' : 'text-red-400 hover:bg-gray-800'
                      ]"
                    >
                      Resúmenes
                    </Link>
                  </li>
                  <li>
                    <Link 
                      :href="route('tenant.voided.index')"
                      :class="[
                        'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                        isActive('voided') ? 'bg-gray-800 text-white' : 'text-red-400 hover:bg-gray-800'
                      ]"
                    >
                      Anulaciones
                    </Link>
                  </li>
                </template>
              </ul>
            </li>

            <!-- Comprobantes avanzados -->
            <li v-if="hasModule('advanced') && companySoapTypeId !== '03'">
              <a 
                @click.prevent="toggleSection('avanzados')"
                :class="[
                  'flex items-center justify-between gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                  isSectionActive(['retentions', 'perceptions', 'order-forms', 'contingencies', 'purchase-settlements'])
                    ? 'bg-gray-800 text-white' 
                    : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <div class="flex items-center gap-2">
                  <i class="fas fa-clipboard-list sidebar-icon text-[20px]"></i>
                  <span class="sidebar-text">Comprobantes avanzados</span>
                </div>
                <i 
                  :class="[
                    'fas fa-chevron-down ml-auto text-gray-500 text-xs transition-transform',
                    expandedSections.avanzados || isSectionActive(['retentions', 'perceptions', 'order-forms', 'contingencies', 'purchase-settlements']) ? 'rotate-180' : ''
                  ]"
                ></i>
              </a>
              <ul 
                :class="[
                  'ml-4 mt-1 space-y-1',
                  expandedSections.avanzados || isSectionActive(['retentions', 'perceptions', 'order-forms', 'contingencies', 'purchase-settlements']) ? 'block' : 'hidden'
                ]"
              >
                <li v-if="hasModuleLevel('advanced_retentions')">
                  <Link 
                    :href="route('tenant.retentions.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('retentions') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Retenciones
                  </Link>
                </li>
                <li v-if="hasModuleLevel('advanced_perceptions')">
                  <Link 
                    :href="route('tenant.perceptions.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('perceptions') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Percepciones
                  </Link>
                </li>
                <li v-if="hasModuleLevel('advanced_purchase_settlements')">
                  <Link 
                    :href="route('tenant.purchase-settlements.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('purchase-settlements') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Liquidaciones de compra
                  </Link>
                </li>
                <li v-if="hasModuleLevel('advanced_order_forms')">
                  <Link 
                    :href="route('tenant.order_forms.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('order-forms') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Ordenes de pedido
                  </Link>
                </li>
                <li v-if="userType !== 'integrator' && hasModule('documents') && hasModuleLevel('document_contingengy') && companySoapTypeId !== '03'">
                  <Link 
                    :href="route('tenant.contingencies.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('contingencies') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Documentos de contingencia
                  </Link>
                </li>
              </ul>
            </li>

            <!-- Contabilidad -->
            <li v-if="hasModule('accounting')">
              <a 
                @click.prevent="toggleSection('contabilidad')"
                :class="[
                  'flex items-center justify-between gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                  isSectionActive(['account', 'accounting_ledger', 'sire'])
                    ? 'bg-gray-800 text-white' 
                    : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <div class="flex items-center gap-2">
                  <i class="fas fa-chart-line sidebar-icon text-[20px]"></i>
                  <span class="sidebar-text">Contabilidad</span>
                </div>
                <i 
                  :class="[
                    'fas fa-chevron-down ml-auto text-gray-500 text-xs transition-transform',
                    expandedSections.contabilidad || isSectionActive(['account', 'accounting_ledger', 'sire']) ? 'rotate-180' : ''
                  ]"
                ></i>
              </a>
              <ul 
                :class="[
                  'ml-4 mt-1 space-y-1',
                  expandedSections.contabilidad || isSectionActive(['account', 'accounting_ledger', 'sire']) ? 'block' : 'hidden'
                ]"
              >
                <li v-if="hasModuleLevel('account_report')">
                  <Link 
                    :href="route('tenant.account_format.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('account', 'format') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Exportar reporte
                  </Link>
                </li>
                <li v-if="hasModuleLevel('account_formats')">
                  <Link 
                    :href="route('tenant.account.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('account') && !isActive('account', 'format') && !isActive('account', 'summary-report') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Exportar formatos - Sis. Contable
                  </Link>
                </li>
                <li v-if="hasModuleLevel('account_summary')">
                  <Link 
                    :href="route('tenant.account_summary_report.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('account', 'summary-report') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Reporte resumido - Ventas
                  </Link>
                </li>
                <li>
                  <Link 
                    :href="route('tenant.accounting_ledger.create')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('accounting_ledger') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Libro Mayor
                  </Link>
                </li>
                <li>
                  <a 
                    @click.prevent="toggleSection('sire')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                      isActive('sire') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    <span>SIRE</span>
                  </a>
                  <ul 
                    :class="[
                      'ml-4 mt-1 space-y-1',
                      expandedSections.sire || isActive('sire') ? 'block' : 'hidden'
                    ]"
                  >
                    <li>
                      <Link 
                        :href="route('tenant.sire.sale')"
                        :class="[
                          'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                          isActive('sire', 'sale') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                        ]"
                      >
                        Ventas
                      </Link>
                    </li>
                    <li>
                      <Link 
                        :href="route('tenant.sire.purchase')"
                        :class="[
                          'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                          isActive('sire', 'purchase') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                        ]"
                      >
                        Compras
                      </Link>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>

            <!-- Reportes -->
            <li v-if="hasModule('reports')">
              <Link 
                href="/list-reports"
                :class="[
                  'flex items-center gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm',
                  isReportsActive(['purchases', 'search', 'sales', 'customers', 'items', 'general-items', 'consistency-documents', 'quotations', 'sale-notes', 'cash', 'commissions', 'document-hotels', 'validate-documents', 'document-detractions', 'commercial-analysis', 'order-notes-consolidated', 'order-notes-general', 'sales-consolidated', 'user-commissions', 'fixed-asset-purchases', 'massive-downloads', 'tips']) || 
                  isSectionActive(['list-reports', 'system-activity-logs'])
                    ? 'bg-gray-800 text-white' 
                    : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <i class="fas fa-chart-bar sidebar-icon text-[20px]"></i>
                <span class="sidebar-text">Reportes</span>
              </Link>
            </li>

            <!-- Ecommerce -->
            <li v-if="hasModule('ecommerce')">
              <a 
                @click.prevent="toggleSection('ecommerce')"
                :class="[
                  'flex items-center justify-between gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                  isSectionActive(['ecommerce', 'items_ecommerce', 'tags', 'promotions', 'orders', 'configuration'])
                    ? 'bg-gray-800 text-white' 
                    : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <div class="flex items-center gap-2">
                  <i class="fas fa-shopping-cart sidebar-icon text-[20px]"></i>
                  <span class="sidebar-text">Tienda Virtual</span>
                </div>
                <i 
                  :class="[
                    'fas fa-chevron-down ml-auto text-gray-500 text-xs transition-transform',
                    expandedSections.ecommerce || isSectionActive(['ecommerce', 'items_ecommerce', 'tags', 'promotions', 'orders', 'configuration']) ? 'rotate-180' : ''
                  ]"
                ></i>
              </a>
              <ul 
                :class="[
                  'ml-4 mt-1 space-y-1',
                  expandedSections.ecommerce || isSectionActive(['ecommerce', 'items_ecommerce', 'tags', 'promotions', 'orders', 'configuration']) ? 'block' : 'hidden'
                ]"
              >
                <li v-if="hasModuleLevel('ecommerce')">
                  <a 
                    :href="route('tenant.ecommerce.index')"
                    target="_blank"
                    class="block px-3 py-2 rounded transition-colors duration-150 text-sm text-gray-300 hover:bg-gray-800"
                  >
                    Ir a Tienda
                  </a>
                </li>
                <li v-if="hasModuleLevel('ecommerce_orders')">
                  <Link 
                    :href="route('tenant_orders_index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('orders') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Pedidos
                  </Link>
                </li>
                <li v-if="hasModuleLevel('ecommerce_items')">
                  <Link 
                    :href="route('tenant.items_ecommerce.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('items_ecommerce') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Productos Tienda Virtual
                  </Link>
                </li>
                <li>
                  <Link 
                    :href="route('tenant.ecommerce.item_sets.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('ecommerce', 'item-sets') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Conjuntos/Packs/Promociones
                  </Link>
                </li>
                <li v-if="hasModuleLevel('ecommerce_tags')">
                  <Link 
                    :href="route('tenant.tags.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('tags') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Tags - Categorias(Etiquetas)
                  </Link>
                </li>
                <li v-if="hasModuleLevel('ecommerce_promotions')">
                  <Link 
                    :href="route('tenant.promotion.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('promotions') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Promociones(Banners)
                  </Link>
                </li>
              </ul>
            </li>

            <!-- Restaurante -->
            <li v-if="hasModule('restaurant_app')">
              <a 
                @click.prevent="toggleSection('restaurant')"
                :class="[
                  'flex items-center justify-between gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                  isActive('restaurant')
                    ? 'bg-gray-800 text-white' 
                    : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <div class="flex items-center gap-2">
                  <i class="fas fa-utensils sidebar-icon text-[20px]"></i>
                  <span class="sidebar-text">Restaurante</span>
                </div>
                <i 
                  :class="[
                    'fas fa-chevron-down ml-auto text-gray-500 text-xs transition-transform',
                    expandedSections.restaurant || isActive('restaurant') ? 'rotate-180' : ''
                  ]"
                ></i>
              </a>
              <ul 
                :class="[
                  'ml-4 mt-1 space-y-1',
                  expandedSections.restaurant || isActive('restaurant') ? 'block' : 'hidden'
                ]"
              >
                <li>
                  <Link 
                    :href="route('tenant.restaurant.list_items')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('restaurant', 'list') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Productos
                  </Link>
                </li>
                <li>
                  <a 
                    @click.prevent="toggleSection('restaurant-delivery')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                      isActive('restaurant', 'promotions') || isActive('restaurant', 'orders') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Pedidos Delivery
                  </a>
                  <ul 
                    :class="[
                      'ml-4 mt-1 space-y-1',
                      expandedSections['restaurant-delivery'] || isActive('restaurant', 'promotions') || isActive('restaurant', 'orders') ? 'block' : 'hidden'
                    ]"
                  >
                    <li>
                      <a 
                        :href="route('tenant.restaurant.menu')"
                        target="_blank"
                        class="block px-3 py-2 rounded transition-colors duration-150 text-sm text-gray-300 hover:bg-gray-800"
                      >
                        Ver pedidos en linea
                      </a>
                    </li>
                    <li>
                      <Link 
                        :href="route('tenant.restaurant.order.index')"
                        :class="[
                          'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                          isActive('restaurant', 'orders') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                        ]"
                      >
                        Listado de pedidos
                      </Link>
                    </li>
                    <li>
                      <Link 
                        :href="route('tenant.restaurant.promotion.index')"
                        :class="[
                          'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                          isActive('restaurant', 'promotions') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                        ]"
                      >
                        Promociones(Banners)
                      </Link>
                    </li>
                  </ul>
                </li>
                <li>
                  <Link 
                    :href="route('tenant.restaurant.configuration')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('restaurant', 'configuration') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Config. Mesas/Cocina
                  </Link>
                </li>
              </ul>
            </li>

            <!-- DIGEMID / Farmacia -->
            <li v-if="hasModule('digemid') && configuration?.isPharmacy?.()">
              <a 
                @click.prevent="toggleSection('digemid')"
                :class="[
                  'flex items-center justify-between gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                  isActive('digemid')
                    ? 'bg-gray-800 text-white' 
                    : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <div class="flex items-center gap-2">
                  <i class="fas fa-pills sidebar-icon text-[20px]"></i>
                  <span class="sidebar-text">Farmacia</span>
                </div>
                <i 
                  :class="[
                    'fas fa-chevron-down ml-auto text-gray-500 text-xs transition-transform',
                    expandedSections.digemid || isActive('digemid') ? 'rotate-180' : ''
                  ]"
                ></i>
              </a>
              <ul 
                :class="[
                  'ml-4 mt-1 space-y-1',
                  expandedSections.digemid || isActive('digemid') ? 'block' : 'hidden'
                ]"
              >
                <li v-if="hasModuleLevel('digemid')">
                  <Link 
                    :href="route('tenant.digemid.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('digemid', 'digemid') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Productos
                  </Link>
                </li>
              </ul>
            </li>

            <!-- Hoteles -->
            <li v-if="hasModule('hotels')">
              <a 
                @click.prevent="toggleSection('hotels')"
                :class="[
                  'flex items-center justify-between gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                  isActive('hotels')
                    ? 'bg-gray-800 text-white' 
                    : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <div class="flex items-center gap-2">
                  <i class="fas fa-hotel sidebar-icon text-[20px]"></i>
                  <span class="sidebar-text">Hoteles</span>
                </div>
                <i 
                  :class="[
                    'fas fa-chevron-down ml-auto text-gray-500 text-xs transition-transform',
                    expandedSections.hotels || isActive('hotels') ? 'rotate-180' : ''
                  ]"
                ></i>
              </a>
              <ul 
                :class="[
                  'ml-4 mt-1 space-y-1',
                  expandedSections.hotels || isActive('hotels') ? 'block' : 'hidden'
                ]"
              >
                <li v-if="hasModuleLevel('hotels_reception')">
                  <Link 
                    href="/hotels/reception"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('hotels', 'reception') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Recepción
                  </Link>
                </li>
                <li v-if="hasModuleLevel('hotels_rates')">
                  <Link 
                    href="/hotels/rates"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('hotels', 'rates') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Tarifas
                  </Link>
                </li>
                <li v-if="hasModuleLevel('hotels_floors')">
                  <Link 
                    href="/hotels/floors"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('hotels', 'floors') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Ubicaciones
                  </Link>
                </li>
                <li v-if="hasModuleLevel('hotels_cats')">
                  <Link 
                    href="/hotels/categories"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('hotels', 'categories') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Categorías
                  </Link>
                </li>
                <li v-if="hasModuleLevel('hotels_rooms')">
                  <Link 
                    href="/hotels/rooms"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('hotels', 'rooms') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Habitaciones
                  </Link>
                </li>
              </ul>
            </li>

            <!-- Suscripción -->
            <li v-if="hasModule('suscription_app')">
              <a 
                @click.prevent="toggleSection('suscription')"
                :class="[
                  'flex items-center justify-between gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                  isActive('full_suscription')
                    ? 'bg-gray-800 text-white' 
                    : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <div class="flex items-center gap-2">
                  <i class="fas fa-calendar-alt sidebar-icon text-[20px]"></i>
                  <span class="sidebar-text">
                    Suscripción <sup style="background: #ffc300;padding: 0px 3px;border-radius: 4px;">Beta</sup>
                  </span>
                </div>
                <i 
                  :class="[
                    'fas fa-chevron-down ml-auto text-gray-500 text-xs transition-transform',
                    expandedSections.suscription || isActive('full_suscription') ? 'rotate-180' : ''
                  ]"
                ></i>
              </a>
              <ul 
                :class="[
                  'ml-4 mt-1 space-y-1',
                  expandedSections.suscription || isActive('full_suscription') ? 'block' : 'hidden'
                ]"
              >
                <li>
                  <Link 
                    :href="route('tenant.fullsuscription.client.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('full_suscription', 'client') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Clientes
                  </Link>
                </li>
                <li>
                  <Link 
                    :href="route('tenant.fullsuscription.plans.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('full_suscription', 'plans') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Planes
                  </Link>
                </li>
                <li>
                  <Link 
                    :href="route('tenant.fullsuscription.payments.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('full_suscription', 'payments') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Suscripciones
                  </Link>
                </li>
                <li>
                  <Link 
                    :href="route('tenant.fullsuscription.payment_receipt.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('full_suscription', 'payment_receipt') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Recibos de pago
                  </Link>
                </li>
              </ul>
            </li>

            <!-- Suscripción Escolar -->
            <li v-if="hasModule('full_suscription_app')">
              <a 
                @click.prevent="toggleSection('fullSuscription')"
                :class="[
                  'flex items-center justify-between gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                  isActive('suscription')
                    ? 'bg-gray-800 text-white' 
                    : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <div class="flex items-center gap-2">
                  <i class="fas fa-user-graduate sidebar-icon text-[20px]"></i>
                  <span class="sidebar-text">
                    Suscripción Escolar <sup style="background: #ffc300;padding: 0px 3px;border-radius: 4px;">Beta</sup>
                  </span>
                </div>
                <i 
                  :class="[
                    'fas fa-chevron-down ml-auto text-gray-500 text-xs transition-transform',
                    expandedSections.fullSuscription || isActive('suscription') ? 'rotate-180' : ''
                  ]"
                ></i>
              </a>
              <ul 
                :class="[
                  'ml-4 mt-1 space-y-1',
                  expandedSections.fullSuscription || isActive('suscription') ? 'block' : 'hidden'
                ]"
              >
                <li>
                  <a 
                    @click.prevent="toggleSection('suscription-client')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                      isActive('suscription', 'client') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Clientes
                  </a>
                  <ul 
                    :class="[
                      'ml-4 mt-1 space-y-1',
                      expandedSections['suscription-client'] || isActive('suscription', 'client') ? 'block' : 'hidden'
                    ]"
                  >
                    <li>
                      <Link 
                        :href="route('tenant.suscription.client.index')"
                        :class="[
                          'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                          isActive('suscription', 'client') && !isActive('suscription', 'client', 'childrens') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                        ]"
                      >
                        Padres
                      </Link>
                    </li>
                    <li>
                      <Link 
                        :href="route('tenant.suscription.client_children.index')"
                        :class="[
                          'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                          isActive('suscription', 'client', 'childrens') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                        ]"
                      >
                        Hijos
                      </Link>
                    </li>
                  </ul>
                </li>
                <li>
                  <Link 
                    :href="route('tenant.suscription.plans.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('suscription', 'plans') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Planes
                  </Link>
                </li>
                <li>
                  <Link 
                    :href="route('tenant.suscription.payments.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('suscription', 'payments') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Matrículas
                  </Link>
                </li>
                <li>
                  <Link 
                    :href="route('tenant.suscription.payment_receipt.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('suscription', 'payment_receipt') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Recibos de pago
                  </Link>
                </li>
                <li>
                  <Link 
                    :href="route('tenant.suscription.grade_section.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('suscription', 'grade_section') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Grados y Secciones
                  </Link>
                </li>
              </ul>
            </li>

            <!-- Trámite documentario -->
            <li v-if="hasModule('documentary-procedure')">
              <a 
                @click.prevent="toggleSection('documentary')"
                :class="[
                  'flex items-center justify-between gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                  isActive('documentary-procedure')
                    ? 'bg-gray-800 text-white' 
                    : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <div class="flex items-center gap-2">
                  <i class="fas fa-folder sidebar-icon text-[20px]"></i>
                  <span class="sidebar-text">Trámite documentario</span>
                </div>
                <i 
                  :class="[
                    'fas fa-chevron-down ml-auto text-gray-500 text-xs transition-transform',
                    expandedSections.documentary || isActive('documentary-procedure') ? 'rotate-180' : ''
                  ]"
                ></i>
              </a>
              <ul 
                :class="[
                  'ml-4 mt-1 space-y-1',
                  expandedSections.documentary || isActive('documentary-procedure') ? 'block' : 'hidden'
                ]"
              >
                <li v-if="hasModuleLevel('documentary_offices')">
                  <Link 
                    :href="route('documentary.offices')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('documentary-procedure', 'offices') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Listado de Etapas
                  </Link>
                </li>
                <li v-if="hasModuleLevel('documentary_offices')">
                  <Link 
                    :href="route('documentary.status')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('documentary-procedure', 'status') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Listado de Estados
                  </Link>
                </li>
                <li v-if="hasModuleLevel('documentary_process')">
                  <Link 
                    :href="route('documentary.requirements')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('documentary-procedure', 'requirements') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Listado de requisitos
                  </Link>
                </li>
                <li v-if="hasModuleLevel('documentary_process')">
                  <Link 
                    :href="route('documentary.processes')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('documentary-procedure', 'processes') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Tipos de Trámites
                  </Link>
                </li>
                <li v-if="hasModuleLevel('documentary_files')">
                  <Link 
                    :href="route('documentary.files_simplify')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('documentary-procedure', 'files_simplify') || isActive('documentary-procedure', 'files') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Listado de Trámites
                  </Link>
                </li>
                <li v-if="hasModuleLevel('documentary_files')">
                  <Link 
                    :href="route('documentary.stadistic')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('documentary-procedure', 'stadistic') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Estadisticas de Trámites
                  </Link>
                </li>
              </ul>
            </li>

            <!-- Producción -->
            <li v-if="hasModule('production_app')">
              <a 
                @click.prevent="toggleSection('production')"
                :class="[
                  'flex items-center justify-between gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm cursor-pointer',
                  isSectionActive(['production', 'machine-production', 'packaging', 'machine-type-production', 'workers', 'mill-production'])
                    ? 'bg-gray-800 text-white' 
                    : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <div class="flex items-center gap-2">
                  <i class="fas fa-industry sidebar-icon text-[20px]"></i>
                  <span class="sidebar-text">Producción</span>
                </div>
                <i 
                  :class="[
                    'fas fa-chevron-down ml-auto text-gray-500 text-xs transition-transform',
                    expandedSections.production || isSectionActive(['production', 'machine-production', 'packaging', 'machine-type-production', 'workers', 'mill-production']) ? 'rotate-180' : ''
                  ]"
                ></i>
              </a>
              <ul 
                :class="[
                  'ml-4 mt-1 space-y-1',
                  expandedSections.production || isSectionActive(['production', 'machine-production', 'packaging', 'machine-type-production', 'workers', 'mill-production']) ? 'block' : 'hidden'
                ]"
              >
                <li>
                  <Link 
                    :href="route('tenant.production.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('production') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Productos Fabricados
                  </Link>
                </li>
                <li>
                  <Link 
                    :href="route('tenant.mill_production.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('mill-production') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Ingreso de Insumos
                  </Link>
                </li>
                <li>
                  <Link 
                    :href="route('tenant.machine_type_production.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('machine-type-production') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Tipos de maquinaria
                  </Link>
                </li>
                <li>
                  <Link 
                    :href="route('tenant.machine_production.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('machine-production') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Maquinaria
                  </Link>
                </li>
                <li>
                  <Link 
                    :href="route('tenant.packaging.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('packaging') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Zona de embalaje
                  </Link>
                </li>
                <li>
                  <Link 
                    :href="route('tenant.workers.index')"
                    :class="[
                      'block px-3 py-2 rounded transition-colors duration-150 text-sm',
                      isActive('workers') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                    ]"
                  >
                    Empleados
                  </Link>
                </li>
              </ul>
            </li>
            
            <!-- Mis Pagos -->
            <li>
              <Link 
                :href="route('tenant.payment.index')"
                :class="[
                  'flex items-center gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm',
                  isActive('payment_index') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <i class="fas fa-file-invoice-dollar sidebar-icon text-[20px]"></i>
                <span class="sidebar-text">Mis Pagos</span>
              </Link>
            </li>
            
            <!-- Tutoriales -->
            <li>
              <Link 
                :href="route('tenant.dashboard.soporte')"
                :class="[
                  'flex items-center gap-2 px-3 py-2 rounded transition-colors duration-150 text-sm',
                  isActive('soporte') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800'
                ]"
              >
                <i class="fas fa-graduation-cap sidebar-icon text-[20px]"></i>
                <span class="sidebar-text">Tutoriales</span>
              </Link>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </aside>
</template>

<script setup>
import { computed, ref, reactive, onMounted } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

defineProps({
  isCollapsed: {
    type: Boolean,
    default: false
  },
  isMobileOpen: {
    type: Boolean,
    default: false
  }
})

defineEmits(['toggle', 'close-mobile'])

const page = usePage()

// Datos del tenant
const modules = computed(() => page.props.vc_modules || [])
const moduleLevels = computed(() => page.props.vc_module_levels || [])
const company = computed(() => page.props.vc_company || {})
const companyName = computed(() => company.value?.name || '')
const configuration = computed(() => page.props.vc_configuration || {})
const userType = computed(() => page.props.auth?.user?.type || '')
const companySoapTypeId = computed(() => company.value?.soap_type_id || '')
const inventoryConfiguration = computed(() => page.props.inventory_configuration || { inventory_review: false })

// Estado de secciones expandidas
const expandedSections = reactive({
  preventa: false,
  ventas: false,
  compras: false,
  clientes: false,
  productos: false,
  inventario: false,
  finanzas: false,
  guias: false,
  comprobantes: false,
  avanzados: false,
  contabilidad: false,
  sire: false,
  ecommerce: false,
  restaurant: false,
  'restaurant-delivery': false,
  digemid: false,
  hotels: false,
  suscription: false,
  'suscription-client': false,
  fullSuscription: false,
  documentary: false,
  production: false
})

// Funciones de utilidad
const hasModule = (module) => modules.value.includes(module)
const hasModuleLevel = (level) => moduleLevels.value.includes(level)

// Determinar ruta activa
const currentPath = computed(() => {
  const url = page.url || ''
  return url.split('/').filter(Boolean)
})

const isActive = (firstLevel, secondLevel = null, thirdLevel = null) => {
  const path = currentPath.value
  if (thirdLevel) {
    return path[0] === firstLevel && path[1] === secondLevel && path[2] === thirdLevel
  }
  if (secondLevel) {
    return path[0] === firstLevel && path[1] === secondLevel
  }
  return path[0] === firstLevel
}

const isSectionActive = (firstLevels, secondLevel = null) => {
  const path = currentPath.value
  if (secondLevel) {
    return firstLevels.includes(path[0]) && path[1] === secondLevel
  }
  return firstLevels.includes(path[0])
}

const isVentasActive = () => {
  const path = currentPath.value
  return (path[0] === 'documents' && path[1] !== 'create' && path[1] !== 'not-sent' && path[1] !== 'regularize-shipping') ||
         (path[0] === 'documents' && path[1] === 'create') ||
         path[0] === 'sale-notes' ||
         path[0] === 'regularize-shipping' ||
         path[0] === 'pos'
}

const isReportsActive = (secondLevels) => {
  const path = currentPath.value
  return path[0] === 'reports' && secondLevels.includes(path[1])
}

// Toggle de secciones
const toggleSection = (section) => {
  expandedSections[section] = !expandedSections[section]
}

// Inicializar secciones expandidas basadas en la ruta activa
onMounted(() => {
  const path = currentPath.value
  const firstLevel = path[0]
  const secondLevel = path[1]
  
  // Expandir secciones activas
  if (['sale-opportunities', 'quotations', 'contracts', 'order-notes', 'technical-services'].includes(firstLevel)) {
    expandedSections.preventa = true
  }
  if (isVentasActive()) {
    expandedSections.ventas = true
  }
  if (['purchases', 'persons', 'expenses', 'purchase-quotations', 'purchase-orders', 'fixed-asset'].includes(firstLevel) || 
      (firstLevel === 'persons' && secondLevel === 'suppliers')) {
    expandedSections.compras = true
  }
  if ((firstLevel === 'persons' && secondLevel === 'customers') || firstLevel === 'person-types' || firstLevel === 'agents') {
    expandedSections.clientes = true
  }
  if (['items', 'services', 'categories', 'brands', 'item-lots', 'item-sets'].includes(firstLevel)) {
    expandedSections.productos = true
  }
  if (['inventory', 'moves', 'transfers', 'devolutions', 'extra_info_items', 'inventory-review'].includes(firstLevel) ||
      (firstLevel === 'reports' && ['kardex', 'inventory', 'valued-kardex'].includes(secondLevel))) {
    expandedSections.inventario = true
  }
  if ((firstLevel === 'finances' && ['global-payments', 'balance', 'payment-method-types', 'unpaid', 'to-pay', 'income', 'transactions', 'movements'].includes(secondLevel)) ||
      firstLevel === 'cash' || firstLevel === 'bank_loan') {
    expandedSections.finanzas = true
  }
  if (['dispatches', 'drivers', 'dispatchers', 'transports', 'dispatch_carrier', 'dispatch_addresses'].includes(firstLevel)) {
    expandedSections.guias = true
  }
  if (secondLevel === 'not-sent' || secondLevel === 'regularize-shipping' || firstLevel === 'summaries' || firstLevel === 'voided') {
    expandedSections.comprobantes = true
  }
  if (['retentions', 'perceptions', 'order-forms', 'contingencies', 'purchase-settlements'].includes(firstLevel)) {
    expandedSections.avanzados = true
  }
  if (['account', 'accounting_ledger', 'sire'].includes(firstLevel)) {
    expandedSections.contabilidad = true
    if (firstLevel === 'sire') {
      expandedSections.sire = true
    }
  }
  if (['ecommerce', 'items_ecommerce', 'tags', 'promotions', 'orders', 'configuration'].includes(firstLevel)) {
    expandedSections.ecommerce = true
  }
  if (firstLevel === 'restaurant') {
    expandedSections.restaurant = true
    if (['promotions', 'orders'].includes(secondLevel)) {
      expandedSections['restaurant-delivery'] = true
    }
  }
  if (firstLevel === 'digemid') {
    expandedSections.digemid = true
  }
  if (firstLevel === 'hotels') {
    expandedSections.hotels = true
  }
  if (firstLevel === 'full_suscription') {
    expandedSections.suscription = true
  }
  if (firstLevel === 'suscription') {
    expandedSections.fullSuscription = true
    if (secondLevel === 'client') {
      expandedSections['suscription-client'] = true
    }
  }
  if (firstLevel === 'documentary-procedure') {
    expandedSections.documentary = true
  }
  if (['production', 'machine-production', 'packaging', 'machine-type-production', 'workers', 'mill-production'].includes(firstLevel)) {
    expandedSections.production = true
  }
})
</script>

<style scoped>
/* Scrollbar personalizado */
#sidebar-left::-webkit-scrollbar {
  width: 8px;
}

#sidebar-left::-webkit-scrollbar-track {
  background: transparent;
}

#sidebar-left::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 8px;
}

#sidebar-left::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}

#sidebar-left {
  scrollbar-color: #cbd5e1 transparent;
  scrollbar-width: thin;
}

/* Ocultar texto cuando está colapsado */
:deep(.sidebar-text) {
  transition: opacity 0.2s;
}

:deep(.sidebar-logo-mini) {
  display: none;
}

/* Cuando está colapsado en desktop */
@media (min-width: 768px) {
  :global(html.sidebar-collapsed) #sidebar-left .sidebar-text,
  :global(html.sidebar-collapsed) #sidebar-left .sidebar-logo-full {
    display: none;
  }
  
  :global(html.sidebar-collapsed) #sidebar-left .sidebar-logo-mini {
    display: inline-block;
  }
  
  :global(html.sidebar-collapsed) #sidebar-left .sidebar-icon {
    margin-right: 0;
  }
}
</style>
