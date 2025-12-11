<?php

use App\Models\Tenant\Configuration;
use Modules\Inventory\Models\InventoryConfiguration;

$configuration = Configuration::first();
$firstLevel = $path[0] ?? null;
$secondLevel = $path[1] ?? null;
$thridLevel = $path[2] ?? null;

$inventory_configuration = InventoryConfiguration::getSidebarPermissions();

?>
    
    <div class="flex items-center justify-between px-4 py-3">
        <a href="{{ route('tenant.dashboard.inicio') }}" class="hidden md:inline-flex items-center">
            <img class="sidebar-logo-full h-10 md:h-12 w-auto max-w-[180px] object-contain"
                src="{{ asset('logo/Tukifac-large-ver-2.webp') }}" alt="Logo" />
            <img class="sidebar-logo-mini hidden h-8 w-8 object-contain"
                src="{{ asset('logo/logo.jpg') }}" alt="Logo mini" />
        </a>
        <button
            class="md:hidden sidebar-close-btn inline-flex items-center justify-center text-gray-400 hover:text-white transition-colors"
            type="button">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <span class="px-4 py-2 text-xs font-semibold tracking-wide uppercase text-gray-300">{{ $vc_company->name }}</span>
    <div class="flex-1 overflow-y-auto">
        <div class="px-2">
            <nav id="menu" class="space-y-1 [&_a]:transition-colors [&_a]:duration-150 [&_a]:text-sm"
                role="navigation">
                <ul class="space-y-1">
                    <!--tukifac-->
                    @if (in_array('dashboard', $vc_modules))
                        <li>
                            <a class="flex items-center gap-2 px-3 py-2 rounded {{ $firstLevel === 'inicio' ? 'bg-green-600 text-white hover:bg-green-700' : 'text-gray-700 hover:bg-gray-100' }}"
                                href="{{ route('tenant.dashboard.inicio') }}">
                                <i class="fas fa-home sidebar-icon text-[20px]"></i>
                                <span class="sidebar-text">Inicio</span>
                            </a>
                        </li>
                        <!--tukifac-->
                        <li>
                            <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 {{ $firstLevel === 'dashboard' ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}"
                                href="{{ route('tenant.dashboard.index') }}">
                                <i class="fas fa-tachometer-alt sidebar-icon text-[20px]"></i>
                                <span class="sidebar-text">Admin dashboard</span>
                            </a>
                        </li>
                    @endif

                    {{-- Preventas --}}
                    @if (in_array('preventa', $vc_modules))
                        <li>
                            <a class="flex items-center justify-between gap-2 px-3 py-2 rounded hover:bg-gray-100 text-gray-700"
                                href="#">
                                <i class="fas fa-edit sidebar-icon text-[20px]"></i>
                                <span class="sidebar-text">Preventa</span>
                            </a>
                            <ul class="ml-4 mt-1 space-y-1">
                                @if (in_array('sale-opportunity', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-100 {{ $firstLevel === 'sale-opportunities' ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}"
                                            href="{{ route('tenant.sale_opportunities.index') }}">
                                            Oportunidad de venta
                                        </a>
                                    </li>
                                @endif

                                @if (in_array('quotations', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-100 {{ $firstLevel === 'quotations' ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}"
                                            href="{{ route('tenant.quotations.index') }}">
                                            Cotizaciones
                                        </a>
                                    </li>
                                @endif

                                @if (in_array('contracts', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-100 {{ $firstLevel === 'contracts' ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}"
                                            href="{{ route('tenant.contracts.index') }}">
                                            Contratos
                                        </a>
                                    </li>
                                @endif

                                @if (in_array('order-note', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'order-notes' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.order_notes.index') }}">
                                            Pedidos
                                        </a>
                                    </li>
                                @endif

                                @if (in_array('technical-service', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'technical-services' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.technical_services.index') }}">
                                            Servicio de soporte técnico
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    {{-- Ventas --}}
                    @if (in_array('documents', $vc_modules))
                        <li>
                            <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 {{ ($firstLevel === 'documents' && $secondLevel !== 'create' && $secondLevel !== 'not-sent' && $secondLevel !== 'regularize-shipping') || ($firstLevel === 'documents' && $secondLevel === 'create') || $firstLevel === 'sale-notes' || $firstLevel === 'regularize-shipping' || $firstLevel === 'pos' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                href="#">
                                <i class="fas fa-file-alt sidebar-icon text-[20px]"></i>
                                <span class="sidebar-text">Ventas</span>
                            </a>
                            <ul
                                class="ml-4 mt-1 space-y-1 {{ ($firstLevel === 'documents' && $secondLevel !== 'create' && $secondLevel !== 'not-sent' && $secondLevel !== 'regularize-shipping') || ($firstLevel === 'documents' && $secondLevel === 'create') || $firstLevel === 'sale-notes' || $firstLevel === 'regularize-shipping' || $firstLevel === 'pos' ? 'block' : 'hidden' }}">
                                @if (auth()->user()->type != 'integrator' && $vc_company->soap_type_id != '03')
                                    @if (in_array('documents', $vc_modules))
                                        @if (in_array('new_document', $vc_module_levels))
                                            <li>
                                                <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'documents' && $secondLevel === 'create' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                    href="{{ route('tenant.documents.create') }}">Nuevo Comprobante</a>
                                            </li>
                                        @endif
                                    @endif
                                @endif

                                @if (in_array('documents', $vc_modules) && $vc_company->soap_type_id != '03')
                                    @if (in_array('list_document', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'documents' && $secondLevel != 'create' && $secondLevel != 'not-sent' && $secondLevel != 'regularize-shipping' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.documents.index') }}">Consulta de
                                                comprobantes</a>
                                        </li>
                                    @endif
                                @endif

                                @if (in_array('sale_notes', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'sale-notes' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.sale_notes.index') }}">Notas de Venta</a>
                                    </li>
                                @endif

                                @if (in_array('pos', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'pos' && !$secondLevel ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.pos.index') }}">Punto de venta</a>
                                    </li>
                                @endif

                                {{-- Venta Rápida --}}
                                @if (in_array('pos_garage', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'pos' && $secondLevel === 'garage' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.pos.garage') }}">Venta rápida <span
                                                style="font-size:.65rem;">(Grifos y Markets)</span></a>
                                    </li>
                                @endif

                            </ul>
                        </li>
                    @endif

                    @if (auth()->user()->type != 'integrator')
                        @if (in_array('purchases', $vc_modules))
                            <li>
                                <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'purchases' ||
                                ($firstLevel === 'persons' && $secondLevel === 'suppliers') ||
                                $firstLevel === 'expenses' ||
                                $firstLevel === 'purchase-quotations' ||
                                $firstLevel === 'purchase-orders' ||
                                $firstLevel === 'fixed-asset'
                                    ? 'bg-gray-800 text-white'
                                    : 'text-gray-300' }}"
                                    href="#">
                                    <i class="fas fa-shopping-bag sidebar-icon text-[20px]"></i>
                                    <span class="sidebar-text">Compras</span>
                                </a>
                                <ul
                                    class="ml-4 mt-1 space-y-1 {{ $firstLevel === 'purchases' ||
                                    ($firstLevel === 'persons' && $secondLevel === 'suppliers') ||
                                    $firstLevel === 'expenses' ||
                                    $firstLevel === 'purchase-quotations' ||
                                    $firstLevel === 'purchase-orders' ||
                                    $firstLevel === 'fixed-asset'
                                        ? 'block'
                                        : 'hidden' }}">
                                    @if (in_array('purchases_create', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'purchases' && $secondLevel === 'create' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.purchases.create') }}">Nuevo</a>
                                        </li>
                                    @endif
                                    @if (in_array('purchases_list', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'purchases' && $secondLevel != 'create' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.purchases.index') }}">Listado</a>
                                        </li>
                                    @endif
                                    @if (in_array('purchases_orders', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'purchase-orders' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.purchase-orders.index') }}">Ordenes de
                                                compra</a>
                                        </li>
                                    @endif

                                    @if (in_array('purchases_expenses', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'expenses' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.expenses.index') }}">Gastos diversos</a>
                                        </li>
                                    @endif
                                    @if (in_array('purchases_suppliers', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'persons' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.persons.index', ['type' => 'suppliers']) }}">
                                                Proveedores
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array('purchases_quotations', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'purchase-quotations' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.purchase-quotations.index') }}">
                                                Solicitar cotización
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array('purchases_fixed_assets_items', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'fixed-asset' && $secondLevel === 'items' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.fixed_asset_items.index') }}">Activos
                                                fijos</a>
                                        </li>
                                    @endif
                                    @if (in_array('purchases_fixed_assets_purchases', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'fixed-asset' && $secondLevel === 'purchases' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.fixed_asset_purchases.index') }}">Comprar
                                                activo fijo</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        {{-- Clientes --}}
                        @if (in_array('persons', $vc_modules))
                            <li>
                                <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 {{ ($firstLevel === 'persons' && $secondLevel === 'customers') || $firstLevel === 'person-types' || $firstLevel === 'agents' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                    href="#">
                                    <i class="fas fa-user sidebar-icon text-[20px]"></i>
                                    <span class="sidebar-text">Clientes</span>
                                </a>
                                <ul
                                    class="ml-4 mt-1 space-y-1 {{ ($firstLevel === 'persons' && $secondLevel === 'customers') || $firstLevel === 'person-types' || $firstLevel === 'agents' ? 'block' : 'hidden' }}">
                                    @if (in_array('clients', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'persons' && $secondLevel === 'customers' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.persons.index', ['type' => 'customers']) }}">Clientes</a>
                                        </li>
                                    @endif
                                    @if (in_array('clients_types', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'person-types' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.person_types.index') }}">Tipos de clientes</a>
                                        </li>
                                    @endif

                                    @if ($configuration->enabled_sales_agents)
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'agents' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.agents.index') }}">Agentes</a>
                                        </li>
                                    @endif

                                </ul>
                            </li>
                        @endif



                        {{-- Productos --}}
                        @if (in_array('items', $vc_modules))
                            <li>
                                <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 {{ in_array($firstLevel, ['items', 'services', 'categories', 'brands', 'item-lots', 'item-sets']) ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                    href="#">
                                    <i class="fas fa-th-large sidebar-icon text-[20px]"></i>
                                    <span class="sidebar-text">Productos/Servicios</span>
                                </a>
                                <ul
                                    class="ml-4 mt-1 space-y-1 {{ in_array($firstLevel, ['items', 'services', 'categories', 'brands', 'item-lots', 'item-sets']) ? 'block' : 'hidden' }}">
                                    @if (in_array('items', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'items' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.items.index') }}">Productos</a>
                                        </li>
                                    @endif
                                    @if (in_array('items_packs', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'item-sets' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.item_sets.index') }}">Conjuntos/Packs/Promociones</a>
                                        </li>
                                    @endif
                                    @if (in_array('items_services', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'services' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.services') }}">Servicios</a>
                                        </li>
                                    @endif
                                    @if (in_array('items_categories', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'categories' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.categories.index') }}">Categorías</a>
                                        </li>
                                    @endif
                                    @if (in_array('items_brands', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'brands' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.brands.index') }}">Marcas</a>
                                        </li>
                                    @endif
                                    @if (in_array('items_lots', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'item-lots' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.item-lots.index') }}">Series</a>
                                        </li>
                                    @endif



                                </ul>
                            </li>
                        @endif


                        {{-- Inventario --}}
                        @if (in_array('inventory', $vc_modules))
                            <li>
                                <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 {{ in_array($firstLevel, ['inventory', 'moves', 'transfers', 'devolutions', 'extra_info_items', 'inventory-review']) || ($firstLevel === 'reports' && in_array($secondLevel, ['kardex', 'inventory', 'valued-kardex'])) ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                    href="#">
                                    <i class="fas fa-warehouse sidebar-icon text-[20px]"></i>
                                    <span class="sidebar-text">Inventario</span>
                                </a>
                                <ul
                                    class="ml-4 mt-1 space-y-1 {{ in_array($firstLevel, ['inventory', 'moves', 'transfers', 'devolutions', 'extra_info_items', 'inventory-review']) || ($firstLevel === 'reports' && in_array($secondLevel, ['kardex', 'inventory', 'valued-kardex'])) ? 'block' : 'hidden' }}">
                                    @if (in_array('inventory', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'inventory' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('inventory.index') }}">Movimientos</a>
                                        </li>
                                    @endif
                                    @if (in_array('inventory_transfers', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'transfers' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('transfers.index') }}">Traslados</a>
                                        </li>
                                    @endif
                                    @if (in_array('inventory_devolutions', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'devolutions' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('devolutions.index') }}">Devolucion a proveedor</a>
                                        </li>
                                    @endif
                                    @if (in_array('inventory_report_kardex', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'reports' && $secondLevel === 'kardex' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('reports.kardex.index') }}">Reporte Kardex</a>
                                        </li>
                                    @endif
                                    @if (in_array('inventory_report', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'reports' && $secondLevel == 'inventory' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('reports.inventory.index') }}">Reporte Inventario</a>
                                        </li>
                                    @endif
                                    @if (in_array('inventory_report_valued_kardex', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'reports' && $secondLevel === 'valued-kardex' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('reports.valued_kardex.index') }}">Kardex
                                                valorizado</a>
                                        </li>
                                    @endif
                                    @if (in_array('production_app', $vc_modules) && $configuration->isShowExtraInfoToItem())
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'extra_info_items' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('extra_info_items.index') }}">Datos extra de items</a>
                                        </li>
                                    @endif
                                    @if ($inventory_configuration->inventory_review)
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'inventory-review' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.inventory-review.index') }}">Revisión de
                                                inventario</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                    @endif

                    @if (in_array('finance', $vc_modules))

                        <li>
                            <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 {{ ($firstLevel === 'finances' &&
                                in_array($secondLevel, [
                                    'global-payments',
                                    'balance',
                                    'payment-method-types',
                                    'unpaid',
                                    'to-pay',
                                    'income',
                                    'transactions',
                                    'movements',
                                ])) ||
                            $firstLevel === 'cash' ||
                            $firstLevel === 'bank_loan'
                                ? 'bg-gray-800 text-white'
                                : 'text-gray-300' }}"
                                href="#">
                                <i class="fas fa-wallet sidebar-icon text-[20px]"></i>
                                <span class="sidebar-text">Finanzas</span>
                            </a>
                            <ul
                                class="ml-4 mt-1 space-y-1 {{ ($firstLevel === 'finances' &&
                                    in_array($secondLevel, [
                                        'global-payments',
                                        'balance',
                                        'payment-method-types',
                                        'unpaid',
                                        'to-pay',
                                        'income',
                                        'transactions',
                                        'movements',
                                    ])) ||
                                $firstLevel === 'cash' ||
                                $firstLevel === 'bank_loan'
                                    ? 'block'
                                    : 'hidden' }}">
                                @if (in_array('cash', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'cash' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.cash.index') }}">Caja chica</a>
                                    </li>
                                @endif
                                @if (in_array('finances_movements', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'finances' && $secondLevel == 'movements' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.finances.movements.index') }}">Movimientos</a>
                                    </li>
                                @endif
                                @if (in_array('finances_movements', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'finances' && $secondLevel == 'transactions' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.finances.transactions.index') }}">Transacciones</a>
                                    </li>
                                @endif
                                @if (in_array('finances_incomes', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'finances' && $secondLevel == 'income' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.finances.income.index') }}">Ingresos</a>
                                    </li>
                                @endif
                                @if (in_array('finances_unpaid', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'finances' && $secondLevel == 'unpaid' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.finances.unpaid.index') }}">Cuentas por
                                            cobrar</a>
                                    </li>
                                @endif
                                @if (in_array('finances_to_pay', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'finances' && $secondLevel == 'to-pay' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.finances.to_pay.index') }}">Cuentas por
                                            pagar</a>
                                    </li>
                                @endif
                                @if (in_array('finances_payments', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'finances' && $secondLevel == 'global-payments' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.finances.global_payments.index') }}">Pagos</a>
                                    </li>
                                @endif
                                @if (in_array('finances_balance', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'finances' && $secondLevel == 'balance' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.finances.balance.index') }}">Balance</a>
                                    </li>
                                @endif
                                @if (in_array('finances_payment_method_types', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'finances' && $secondLevel == 'payment-method-types' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.finances.payment_method_types.index') }}">Ingresos
                                            y
                                            Egresos - M. Pago</a>
                                    </li>
                                @endif
                                @if (in_array('purchases_expenses', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'bank_loan' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.bank_loan.index') }}">Credito Bancario</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (in_array('guia', $vc_modules) && $vc_company->soap_type_id != '03')
                        <li>
                            <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 {{ in_array($firstLevel, ['dispatches', 'drivers', 'dispatchers', 'transports', 'dispatch_carrier', 'dispatch_addresses']) ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                href="#">
                                <i class="fas fa-truck sidebar-icon text-[20px]"></i>
                                <span class="sidebar-text">Guías de remisión</span>
                            </a>
                            <ul
                                class="ml-4 mt-1 space-y-1 {{ in_array($firstLevel, ['dispatches', 'drivers', 'dispatchers', 'transports', 'dispatch_carrier', 'dispatch_addresses']) ? 'block' : 'hidden' }}">
                                @if (in_array('dispatches', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'dispatches' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.dispatches.index') }}">G.R. Remitente</a>
                                    </li>
                                @endif
                                @if (in_array('dispatch_carrier', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'dispatch_carrier' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.dispatch_carrier.index') }}">G.R.
                                            Transportista</a>
                                    </li>
                                @endif
                                @if (in_array('dispatchers', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'dispatchers' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.dispatchers.index') }}">Transportistas</a>
                                    </li>
                                @endif
                                @if (in_array('drivers', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'drivers' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.drivers.index') }}">Conductores</a>
                                    </li>
                                @endif
                                @if (in_array('transports', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'transports' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.transports.index') }}">Vehículos</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (in_array('comprobante', $vc_modules))
                        <li>
                            <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 {{ $secondLevel === 'not-sent' || $secondLevel === 'regularize-shipping' || $firstLevel === 'summaries' || $firstLevel === 'voided' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                href="#">
                                <i class="fas fa-file-alt sidebar-icon text-[20px]"></i>
                                <span class="sidebar-text">Comprobantes pendientes</span>
                            </a>
                            <ul
                                class="ml-4 mt-1 space-y-1 {{ $secondLevel === 'not-sent' || $secondLevel === 'regularize-shipping' || $firstLevel === 'summaries' || $firstLevel === 'voided' ? 'block' : 'hidden' }}">
                                @if (in_array('comprobante', $vc_modules) && $vc_company->soap_type_id != '03')
                                    @if (in_array('document_not_sent', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'documents' && $secondLevel === 'not-sent' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.documents.not_sent') }}">
                                                Comprobantes no enviados
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array('regularize_shipping', $vc_module_levels))
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'documents' && $secondLevel === 'regularize-shipping' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.documents.regularize_shipping') }}">
                                                CPE pendientes de rectificación
                                            </a>
                                        </li>
                                    @endif
                                @endif
                                @if (in_array('summary_voided', $vc_module_levels) && $vc_company->soap_type_id != '03')
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'summaries' ? 'bg-gray-800 text-white' : 'text-red-400' }}"
                                            href="{{ route('tenant.summaries.index') }}">
                                            Resúmenes
                                        </a>
                                    </li>
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'voided' ? 'bg-gray-800 text-white' : 'text-red-400' }}"
                                            href="{{ route('tenant.voided.index') }}">
                                            Anulaciones
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif


                    @if (in_array('advanced', $vc_modules) && $vc_company->soap_type_id != '03')
                        <li>
                            <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 {{ in_array($firstLevel, ['retentions', 'perceptions', 'order-forms', 'contingencies', 'purchase-settlements']) ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                href="#">
                                <i class="fas fa-clipboard-list sidebar-icon text-[20px]"></i>
                                <span class="sidebar-text">Comprobantes avanzados</span>
                            </a>
                            <ul
                                class="ml-4 mt-1 space-y-1 {{ in_array($firstLevel, ['retentions', 'perceptions', 'order-forms', 'contingencies', 'purchase-settlements']) ? 'block' : 'hidden' }}">
                                @if (in_array('advanced_retentions', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'retentions' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.retentions.index') }}">Retenciones</a>
                                    </li>
                                @endif
                                @if (in_array('advanced_perceptions', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'perceptions' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.perceptions.index') }}">Percepciones</a>
                                    </li>
                                @endif
                                @if (in_array('advanced_purchase_settlements', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'purchase-settlements' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.purchase-settlements.index') }}">Liquidaciones
                                            de
                                            compra</a>
                                    </li>
                                @endif
                                @if (in_array('advanced_order_forms', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'order-forms' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.order_forms.index') }}">Ordenes de pedido</a>
                                    </li>
                                @endif
                                @if (auth()->user()->type != 'integrator' && in_array('documents', $vc_modules))
                                    @if (auth()->user()->type != 'integrator' &&
                                            in_array('document_contingengy', $vc_module_levels) &&
                                            $vc_company->soap_type_id != '03')
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'contingencies' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.contingencies.index') }}">
                                                Documentos de contingencia
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (in_array('accounting', $vc_modules))
                        <li>
                            <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'account' || $firstLevel === 'accounting_ledger' || $firstLevel === 'sire' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                href="#">
                                <i class="fas fa-chart-line sidebar-icon text-[20px]"></i>
                                <span class="sidebar-text">Contabilidad</span>
                            </a>
                            <ul
                                class="ml-4 mt-1 space-y-1 {{ $firstLevel === 'account' || $firstLevel === 'accounting_ledger' || $firstLevel === 'sire' ? 'block' : 'hidden' }}">
                                @if (in_array('account_report', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'account' && $secondLevel === 'format' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.account_format.index') }}">Exportar
                                            reporte</a>
                                    </li>
                                @endif
                                @if (in_array('account_formats', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'account' && $secondLevel == '' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.account.index') }}">Exportar formatos - Sis.
                                            Contable</a>
                                    </li>
                                @endif
                                @if (in_array('account_summary', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'account' && $secondLevel == 'summary-report' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.account_summary_report.index') }}">Reporte
                                            resumido -
                                            Ventas</a>
                                    </li>
                                @endif
                                <li>
                                    <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'accounting_ledger' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                        href="{{ route('tenant.accounting_ledger.create') }}">
                                        Libro Mayor
                                    </a>
                                </li>
                                <li>
                                    <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'sire' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                        href="#">
                                        <span>SIRE</span>
                                    </a>
                                    <ul
                                        class="ml-4 mt-1 space-y-1 {{ $firstLevel === 'sire' ? 'block' : 'hidden' }}">
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $secondLevel === 'sale' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.sire.sale') }}">Ventas</a>
                                        </li>
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $secondLevel === 'purchase' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.sire.purchase') }}">Compras</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if (in_array('reports', $vc_modules))
                        <li>
                            <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 {{ ($firstLevel === 'reports' && in_array($secondLevel, ['purchases', 'search', 'sales', 'customers', 'items', 'general-items', 'consistency-documents', 'quotations', 'sale-notes', 'cash', 'commissions', 'document-hotels', 'validate-documents', 'document-detractions', 'commercial-analysis', 'order-notes-consolidated', 'order-notes-general', 'sales-consolidated', 'user-commissions', 'fixed-asset-purchases', 'massive-downloads', 'tips'])) || in_array($firstLevel, ['list-reports', 'system-activity-logs']) ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                href="{{ url('list-reports') }}">
                                <i class="fas fa-chart-bar sidebar-icon text-[20px]"></i>
                                <span class="sidebar-text">Reportes</span>
                            </a>
                        </li>
                    @endif

                    {{-- Tienda virtual --}}
                    @if (in_array('ecommerce', $vc_modules))
                        <li>
                            <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 {{ in_array($firstLevel, ['ecommerce', 'items_ecommerce', 'tags', 'promotions', 'orders', 'configuration']) ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                href="#">
                                <i class="fas fa-shopping-cart sidebar-icon text-[20px]"></i>
                                <span class="sidebar-text">Tienda Virtual</span>
                            </a>
                            <ul
                                class="ml-4 mt-1 space-y-1 {{ in_array($firstLevel, ['ecommerce', 'items_ecommerce', 'tags', 'promotions', 'orders', 'configuration']) ? 'block' : 'hidden' }}">
                                @if (in_array('ecommerce', $vc_module_levels))
                                    <li class="">
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 text-gray-300"
                                            onclick="window.open( '{{ route('tenant.ecommerce.index') }} ')">Ir
                                            a
                                            Tienda</a>
                                    </li>
                                @endif
                                @if (in_array('ecommerce_orders', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'orders' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant_orders_index') }}">Pedidos</a>
                                    </li>
                                @endif
                                @if (in_array('ecommerce_items', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'items_ecommerce' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.items_ecommerce.index') }}">Productos Tienda
                                            Virtual</a>
                                    </li>
                                @endif

                                <li>
                                    <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $secondLevel === 'item-sets' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                        href="{{ route('tenant.ecommerce.item_sets.index') }}">Conjuntos/Packs/Promociones</a>
                                </li>

                                @if (in_array('ecommerce_tags', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'tags' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.tags.index') }}">Tags -
                                            Categorias(Etiquetas)</a>
                                    </li>
                                @endif
                                @if (in_array('ecommerce_promotions', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'promotions' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.promotion.index') }}">Promociones(Banners)</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    {{-- Restaurante --}}
                    @if (in_array('restaurant_app', $vc_modules))
                        <li>
                            <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'restaurant' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                href="#">
                                <i class="fas fa-utensils sidebar-icon text-[20px]"></i>
                                <span class="sidebar-text">Restaurante</span>
                            </a>
                            <ul
                                class="ml-4 mt-1 space-y-1 {{ $firstLevel === 'restaurant' ? 'block' : 'hidden' }}">

                                <li>
                                    <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $secondLevel != null && $secondLevel == 'list' && $firstLevel === 'restaurant' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                        href="{{ route('tenant.restaurant.list_items') }}">
                                        Productos
                                    </a>
                                </li>

                                <li>
                                    <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $secondLevel != null && ($secondLevel == 'promotions' || $secondLevel == 'orders') ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                        href="#">
                                        Pedidos Delivery
                                    </a>
                                    <ul
                                        class="ml-4 mt-1 space-y-1 {{ $secondLevel != null && ($secondLevel == 'promotions' || $secondLevel == 'orders') ? 'block' : 'hidden' }}">
                                        <li class="">
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 text-gray-300"
                                                href="{{ route('tenant.restaurant.menu') }}" target="blank">
                                                Ver pedidos en linea
                                            </a>
                                        </li>
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $secondLevel != null && $secondLevel == 'orders' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.restaurant.order.index') }}">
                                                Listado de pedidos
                                            </a>
                                        </li>
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $secondLevel != null && $secondLevel == 'promotions' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.restaurant.promotion.index') }}">
                                                Promociones(Banners)
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $secondLevel != null && $secondLevel == 'configuration' && $firstLevel === 'restaurant' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                        href="{{ route('tenant.restaurant.configuration') }}">
                                        Config. Mesas/Cocina
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    {{-- DIGEMID --}}
                    @if (in_array('digemid', $vc_modules) && $configuration->isPharmacy())
                        <li>
                            <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'digemid' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                href="#">
                                <i class="fas fa-pills sidebar-icon text-[20px]"></i>
                                <span class="sidebar-text">Farmacia</span>
                            </a>
                            <ul class="ml-4 mt-1 space-y-1 {{ $firstLevel === 'digemid' ? 'block' : 'hidden' }}">
                                @if (in_array('digemid', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'digemid' && $secondLevel === 'digemid' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('tenant.digemid.index') }}">Productos</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (in_array('hotels', $vc_modules))
                        <li>
                            <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'hotels' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                href="#">
                                <i class="fas fa-hotel sidebar-icon text-[20px]"></i>
                                <span class="sidebar-text">Hoteles</span>
                            </a>
                            <ul class="ml-4 mt-1 space-y-1 {{ $firstLevel === 'hotels' ? 'block' : 'hidden' }}">
                                @if (in_array('hotels_reception', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'hotels' && $secondLevel === 'reception' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ url('hotels/reception') }}">Recepción</a>
                                    </li>
                                @endif
                                @if (in_array('hotels_rates', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'hotels' && $secondLevel === 'rates' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ url('hotels/rates') }}">Tarifas</a>
                                    </li>
                                @endif
                                @if (in_array('hotels_floors', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'hotels' && $secondLevel === 'floors' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ url('hotels/floors') }}">Ubicaciones</a>
                                    </li>
                                @endif
                                @if (in_array('hotels_cats', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'hotels' && $secondLevel === 'categories' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ url('hotels/categories') }}">Categorías</a>
                                    </li>
                                @endif
                                @if (in_array('hotels_rooms', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'hotels' && $secondLevel === 'rooms' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ url('hotels/rooms') }}">Habitaciones</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    {{-- Suscription --}}
                    @if (in_array('suscription_app', $vc_modules))
                        <li>
                            <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'full_suscription' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                href="#">
                                <i class="fas fa-calendar-alt sidebar-icon text-[20px]"></i>
                                <span class="sidebar-text">
                                    Suscripción <sup
                                        style="background: #ffc300;padding: 0px 3px;border-radius: 4px;">Beta</sup>
                                </span>
                            </a>
                            <ul
                                class="ml-4 mt-1 space-y-1 {{ $firstLevel === 'full_suscription' ? 'block' : 'hidden' }}">
                                <li class="">
                                    <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'full_suscription' && $secondLevel === 'client' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                        href="{{ route('tenant.fullsuscription.client.index') }}">
                                        Clientes
                                    </a>
                                </li>
                                <li class="">
                                    <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'full_suscription' && $secondLevel === 'plans' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                        href="{{ route('tenant.fullsuscription.plans.index') }}">
                                        Planes
                                    </a>
                                </li>
                                <li class="">
                                    <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'full_suscription' && $secondLevel === 'payments' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                        href="{{ route('tenant.fullsuscription.payments.index') }}">
                                        Suscripciones
                                    </a>
                                </li>
                                <li class="">
                                    <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'full_suscription' && $secondLevel === 'payment_receipt' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                        href="{{ route('tenant.fullsuscription.payment_receipt.index') }}">
                                        Recibos de pago
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    {{-- Suscription Escolar --}}
                    @if (in_array('full_suscription_app', $vc_modules))
                        <li>
                            <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'suscription' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                href="#">
                                <i class="fas fa-user-graduate sidebar-icon text-[20px]"></i>
                                <span class="sidebar-text">Suscripción Escolar <sup
                                        style="background: #ffc300;padding: 0px 3px;border-radius: 4px;">Beta</sup></span>
                            </a>
                            <ul
                                class="ml-4 mt-1 space-y-1 {{ $firstLevel === 'suscription' ? 'block' : 'hidden' }}">
                                {{-- @if (in_array('suscription_app_client', $vc_module_levels)) --}}
                                <li>

                                    <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'suscription' && $secondLevel === 'client' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                        href="#">
                                        Clientes
                                    </a>
                                    <ul
                                        class="ml-4 mt-1 space-y-1 {{ $firstLevel === 'suscription' && $secondLevel === 'client' ? 'block' : 'hidden' }}">
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'suscription' && $secondLevel === 'client' && $thridLevel !== 'childrens' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.suscription.client.index') }}">
                                                Padres
                                            </a>
                                        </li>
                                        <li>
                                            <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'suscription' && $secondLevel === 'client' && $thridLevel === 'childrens' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                                href="{{ route('tenant.suscription.client_children.index') }}">
                                                Hijos
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'suscription' && $secondLevel === 'plans' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                        href="{{ route('tenant.suscription.plans.index') }}">
                                        Planes
                                    </a>
                                </li>
                                {{-- @endif --}}

                                {{-- @if (in_array('suscription_app_payments', $vc_module_levels)) --}}
                                <li>
                                    <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'suscription' && $secondLevel === 'payments' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                        href="{{ route('tenant.suscription.payments.index') }}">
                                        Matrículas
                                    </a>
                                </li>
                                {{-- @endif --}}
                                {{-- @if (in_array('suscription_app_payments', $vc_module_levels)) --}}
                                <li>
                                    <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'suscription' && $secondLevel === 'payment_receipt' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                        href="{{ route('tenant.suscription.payment_receipt.index') }}">
                                        Recibos de pago
                                    </a>
                                </li>
                                {{-- @endif --}}

                                <li>
                                    <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'suscription' && $secondLevel === 'grade_section' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                        href="{{ route('tenant.suscription.grade_section.index') }}">
                                        Grados y Secciones
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if (in_array('documentary-procedure', $vc_modules))
                        <li>
                            <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'documentary-procedure' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                href="#">
                                <i class="fas fa-folder sidebar-icon text-[20px]"></i>
                                <span class="sidebar-text">Trámite documentario</span>
                            </a>
                            <ul
                                class="ml-4 mt-1 space-y-1 {{ $firstLevel === 'documentary-procedure' ? 'block' : 'hidden' }}">
                                @if (in_array('documentary_offices', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'documentary-procedure' && $secondLevel === 'offices' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('documentary.offices') }}">Listado de Etapas</a>
                                    </li>
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'documentary-procedure' && $secondLevel === 'status' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('documentary.status') }}">Listado de Estados</a>
                                    </li>
                                @endif
                                @if (in_array('documentary_process', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'documentary-procedure' && $secondLevel === 'requirements' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('documentary.requirements') }}">Listado de
                                            requisitos</a>
                                    </li>

                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'documentary-procedure' && $secondLevel === 'processes' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('documentary.processes') }}">Tipos de Trámites</a>
                                    </li>
                                @endif

                                @if (in_array('documentary_files', $vc_module_levels))
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'documentary-procedure' && ($secondLevel === 'files_simplify' || $secondLevel === 'files') ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('documentary.files_simplify') }}">Listado de
                                            Trámites</a>
                                    </li>
                                    <li>
                                        <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'documentary-procedure' && $secondLevel === 'stadistic' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                            href="{{ route('documentary.stadistic') }}">Estadisticas de
                                            Trámites</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    {{-- Produccion --}}
                    @if (in_array('production_app', $vc_modules))
                        <li>
                            <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'production' ||
                            $firstLevel === 'machine-production' ||
                            $firstLevel === 'packaging' ||
                            $firstLevel === 'machine-type-production' ||
                            $firstLevel === 'workers' ||
                            $firstLevel === 'mill-production'
                                ? 'bg-gray-800 text-white'
                                : 'text-gray-300' }}"
                                href="#">
                                <i class="fas fa-industry sidebar-icon text-[20px]"></i>
                                <span class="sidebar-text">Producción</span>
                            </a>
                            <ul
                                class="ml-4 mt-1 space-y-1 {{ $firstLevel === 'production' ||
                                $firstLevel === 'machine-production' ||
                                $firstLevel === 'packaging' ||
                                $firstLevel === 'machine-type-production' ||
                                $firstLevel === 'workers' ||
                                $firstLevel === 'mill-production'
                                    ? 'block'
                                    : 'hidden' }}">
                                <li>
                                    <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'production' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                        href="{{ route('tenant.production.index') }}">
                                        Productos Fabricados
                                    </a>
                                </li>
                                <li>
                                    <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'mill-production' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                        href="{{ route('tenant.mill_production.index') }}">
                                        Ingreso de Insumos
                                    </a>
                                </li>

                                <li>
                                    <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'machine-type-production' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                        href="{{ route('tenant.machine_type_production.index') }}">
                                        Tipos de maquinaria
                                    </a>
                                </li>


                                <li>
                                    <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'machine-production' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                        href="{{ route('tenant.machine_production.index') }}">
                                        Maquinaria
                                    </a>
                                </li>
                                <li>
                                    <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'packaging' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                        href="{{ route('tenant.packaging.index') }}">
                                        Zona de embalaje
                                    </a>
                                </li>

                                <li>
                                    <a class="block px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'workers' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                                        href="{{ route('tenant.workers.index') }}">
                                        Empleados
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <li>
                        <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 {{ $secondLevel === 'payment_index' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                            href="{{ route('tenant.payment.index') }}">
                            <i class="fas fa-file-invoice-dollar sidebar-icon text-[20px]"></i>
                            <span class="sidebar-text">Mis Pagos</span>
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-800 {{ $firstLevel === 'soporte' ? 'bg-gray-800 text-white' : 'text-gray-300' }}"
                            href="{{ route('tenant.dashboard.soporte') }}">
                            <i class="fas fa-graduation-cap sidebar-icon text-[20px]"></i>
                            <span class="sidebar-text">Tutoriales</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>
