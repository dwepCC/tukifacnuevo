<template>
    <div>
        <header class="flex items-center justify-between mb-4">
            <h2>
                <a href="/dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-layout-dashboard"
                        style="margin-top: -5px;">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 4h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                        <path d="M5 16h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                        <path d="M15 12h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                        <path d="M15 4h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                    </svg>
                </a>
            </h2>
            <ol class="text-sm text-gray-500">
                <li class="active">
                    <span>Dashboard</span>
                </li>
            </ol>
        </header>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 px-2 mb-3">
            <div class="lg:col-span-2">
                <div class="bg-white rounded shadow">
                    <div class="p-0 m-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="chart-data-selector ready ps-3 pe-4 pt-4">
                                    <div class="chart-data-selector-items">
                                        <chart-line v-if="chartDataLoaded && dataChartLine.labels.length > 0"
                                            :data="dataChartLine"></chart-line>
                                        <div v-else class="flex items-center justify-center"
                                            style="height: 200px;">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="sr-only">Cargando gráfico...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 px-4 mt-2 pb-3">
                            <div class="col-span-2 font-semibold text-blue-600">{{ year }}</div>
                            <div class="col-span-10 font-semibold text-right">Comprobantes generados por mes</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-1">
                <div class="grid grid-cols-1 gap-4">
                    <div class="col-span-1">
                        <section class="bg-white rounded shadow mb-4">
                            <header class="bg-green-600 text-white p-4 rounded-t">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-users-group">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                                        <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                                        <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                                    </svg>
                                </div>
                            </header>
                            <div class="p-4 text-center">
                                <p class="font-semibold mb-0 mx-4">Total Clientes</p>
                                <h2 class="font-semibold mt-0">{{ records.length }}</h2>
                                <div>
                                    <a class="text-gray-500 uppercase text-xs" href="#client-list">Ver todos</a>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-span-1 mb-0">
                        <section class="bg-white rounded shadow">
                            <header class="bg-blue-500 text-white p-4 rounded-t">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-file-text">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path
                                            d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                        <path d="M9 9l1 0" />
                                        <path d="M9 13l6 0" />
                                        <path d="M9 17l6 0" />
                                    </svg>
                                </div>
                            </header>
                            <div class="p-4 text-center">
                                <p class="font-semibold mb-0 mt-3">Total Comprobantes</p>
                                <h2 class="font-semibold mt-0 mb-3">{{ total_documents }}</h2>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 px-2">
            <div class="col-span-1">
                <section class="bg-white rounded shadow mb-4">
                    <div class="p-0">
                        <div class="widget-summary widget-summary-md">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon text-secondary">
                                    <div :data-value='discUsed' class="progress1 mx-auto">
                                        <span class="progress1-left">
                                            <span class="progress1-bar border-primary"></span>
                                        </span>
                                        <span class="progress1-right">
                                            <span class="progress1-bar border-primary"></span>
                                        </span>
                                        <div
                                            class="progress1-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                            <div class="font-weight-bold">{{ discUsed }}<small class="small"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title"><!-- Disco <br> Duro --></h4>
                                    <div class="info">
                                        <strong class="amount">Disco Duro</strong><br>
                                        <!-- <span class="text-warning" v-if="discUsed == 0">no se pudo obtener</span> -->
                                    </div>
                                </div>
                                <div class="d-block">
                                    <a class="text-gray-500 uppercase text-xs"
                                        href="https://docs.google.com/document/d/1hpEQUs9OFha_35yyLb1cMKeluD-dEku5lQsQ3TJFib8/edit"
                                        target="BLANK">Incrementar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-span-1">
                <section class="bg-white rounded shadow mb-4">
                    <div class="p-0">
                        <div class="widget-summary widget-summary-md">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon text-secondary">
                                    <div :data-value='iUsed' class="progress1 mx-auto">
                                        <span class="progress1-left">
                                            <span class="progress1-bar border-primary"></span>
                                        </span>
                                        <span class="progress1-right">
                                            <span class="progress1-bar border-primary"></span>
                                        </span>
                                        <div
                                            class="progress1-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                            <div class="font-weight-bold">{{ iUsed }}<small class="small"></small></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title"><!-- Disco <br> Duro --></h4>
                                    <div class="info">
                                        <strong class="amount">Inodes</strong>
                                        <!-- <span class="text-primary">(14 unread)</span> -->
                                    </div>
                                </div>
                                <div class="d-block">
                                    <a class="text-gray-500 uppercase text-xs"
                                        href="https://drive.google.com/open?id=1foPKDI3V3Z9uKTjRc2SPSoztVSOBevPAluT2BqFbfxA"
                                        target="BLANK">Limpiar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-span-1">
                <section class="bg-white rounded shadow mb-4">
                    <div class="p-0">
                        <div class="widget-summary widget-summary-md">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon text-secondary">
                                    <div class="progress1 mx-auto" data-value='100'>
                                        <span class="progress1-left">
                                            <span class="progress1-bar border-tertiary"></span>
                                        </span>
                                        <span class="progress1-right">
                                            <span class="progress1-bar border-tertiary"></span>
                                        </span>
                                        <div
                                            class="progress1-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                            <div class="font-weight-bold">{{ storageSize }}<small class="small"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title"><!-- Disco <br> Duro --></h4>
                                    <div class="info">
                                        <strong class="amount">Archivos <br> Generados</strong>
                                        <!-- <span class="text-primary">(14 unread)</span> -->
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <!-- <a class="text-muted text-uppercase">(view all)</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-span-1">
                <section class="bg-white rounded shadow mb-4">
                    <div class="p-0">
                        <div class="widget-summary widget-summary-md">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon" style="background-color: #292961">
                                    <i class="fab fa-gitlab"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title"><!-- Disco <br> Duro --></h4>
                                    <div class="info">
                                        <strong class="amount">Versión</strong><br>
                                        <span class="text-primary">{{ version }}</span>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <!-- <a class="text-muted text-uppercase">(view all)</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="mt-3">
            <div class="col-12">
                <header class="flex items-center justify-between">
                    <h2>
                        <a href="/dashboard">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users"
                                style="margin-top: -5px;">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                            </svg>
                        </a>
                    </h2>
                    <ol class="text-sm text-gray-500">
                        <li class="active">
                            <span>Listado de Clientes</span>
                        </li>
                    </ol>
                    <div class="ml-auto">
                        <div class="flex flex-wrap">
                            <button class="inline-flex items-center px-3 py-2 text-sm rounded bg-blue-600 text-white hover:bg-blue-700 mt-2 mr-2 mb-3" type="button"
                                @click.prevent="clickCreate()">
                                <i class="fa fa-plus-circle"></i> Nuevo
                            </button>
                        </div>
                    </div>
                </header>
            </div>
        </div>

        <div id="client-list" class="bg-white rounded shadow">
            <div class="p-4">
                <!-- Botón para mostrar/ocultar filtros -->
                <div class="mb-3 flex items-center gap-2">
                    <el-button type="secondary" class="btn-show-filter" :class="{ shift: isFiltersVisible }"
                        @click="toggleFilters">
                        {{ isFiltersVisible ? "Ocultar filtros" : "Mostrar filtros" }}
                    </el-button>
                    <el-button v-if="hasActiveFilters" type="secondary" @click="clearFilters">
                        Limpiar Filtros
                    </el-button>
                </div>

                <!-- Filtros (ahora incluyen el buscador) -->
                <div v-if="isFiltersVisible" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="col-span-1 space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Buscar:</label>
                            <el-input v-model="searchQuery" placeholder="Buscar por hostname, nombre, ruc o correo"
                                class="w-full" prefix-icon="el-icon-search" @input="applyFilters">
                            </el-input>
                        </div>
                        <div class="col-span-1 space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Filtrar por Entorno:</label>
                            <el-select v-model="filters.entorno" placeholder="Todos los entornos" class="w-full"
                                @change="applyFilters">
                                <el-option label="Todos" value=""></el-option>
                                <el-option label="Demo" value="01"></el-option>
                                <el-option label="Producción" value="02"></el-option>
                                <el-option label="Interno" value="03"></el-option>
                            </el-select>
                        </div>
                        <div class="col-span-1 space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Filtrar por Plan:</label>
                            <el-select v-model="filters.plan" placeholder="Todos los planes" class="w-full"
                                @change="applyFilters">
                                <el-option label="Todos" value=""></el-option>
                                <el-option v-for="plan in availablePlans" :key="plan" :label="plan" :value="plan">
                                </el-option>
                            </el-select>
                        </div>
                        <div class="col-span-1 space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Estado de Cuenta:</label>
                            <el-select v-model="filters.bloqueo" placeholder="Todos los estados" class="w-full"
                                @change="applyFilters">
                                <el-option label="Todos" value=""></el-option>
                                <el-option label="Activos" value="0"></el-option>
                                <el-option label="Bloqueados" value="1"></el-option>
                            </el-select>
                        </div>
                    </div>

                    <!-- Filtro de Rango de Fechas -->
                    <div class="mt-3">
                        <div class="col-12">
                            <div class="p-3 border rounded bg-white">
                                <h6 class="mb-3">
                                    <i class="fa fa-calendar"></i> Filtro por Rango de Fechas
                                    <!----<small class="text-muted">(Aplicado a nivel servidor)</small>-->
                                </h6>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="col-span-1 space-y-1">
                                        <label class="block text-sm font-medium text-gray-700">Fecha Inicio:</label>
                                        <el-date-picker v-model="dateFilters.startDate" type="date"
                                            placeholder="Seleccionar fecha inicio" class="w-full"
                                            format="dd/MM/yyyy" value-format="yyyy-MM-dd" @change="onDateFilterChange">
                                        </el-date-picker>
                                    </div>
                                    <div class="col-span-1 space-y-1">
                                        <label class="block text-sm font-medium text-gray-700">Fecha Fin:</label>
                                        <el-date-picker v-model="dateFilters.endDate" type="date"
                                            placeholder="Seleccionar fecha fin" class="w-full" format="dd/MM/yyyy"
                                            value-format="yyyy-MM-dd" @change="onDateFilterChange">
                                        </el-date-picker>
                                    </div>
                                    <div class="col-span-1 mb-2 flex items-end">
                                        <el-button type="primary" @click="applyDateFilter"
                                            :disabled="!dateFilters.startDate || !dateFilters.endDate"
                                            class="mr-2">
                                            <i class="fa fa-filter"></i> Aplicar Filtro
                                        </el-button>
                                        <el-button v-if="hasActiveDateFilter" type="secondary" @click="clearDateFilter">
                                            <i class="fa fa-times"></i> Limpiar
                                        </el-button>
                                    </div>
                                </div>
                                <div v-if="hasActiveDateFilter" class="mt-2 rounded bg-blue-50 text-blue-700 p-2 flex items-center gap-2">
                                    <i class="fa fa-info-circle"></i>
                                    Filtro activo: {{ formatDate(dateFilters.appliedStartDate) }} - {{
                                    formatDate(dateFilters.appliedEndDate) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columnas mostrar/ocultar -->
                <div>
                    <div class="col-lg-12">
                        <div class="text-right mt-2 mr-2 data-table-visible-columns">
                            <el-dropdown :hide-on-click="false">
                                <template #default>
                                    <el-button type="secondary">
                                        Mostrar/Ocultar columnas<i class="el-icon-arrow-down el-icon--right"></i>
                                    </el-button>
                                </template>
                                <template #dropdown>
                                    <el-dropdown-menu>
                                        <el-dropdown-item v-for="(column, index) in columnsComputed" :key="index">
                                            <el-checkbox
                                                v-if="column.title !== undefined && column.visible !== undefined"
                                                v-model="column.visible" @change="saveColumnVisibility">{{ column.title
                                                }}
                                            </el-checkbox>
                                        </el-dropdown-item>
                                    </el-dropdown-menu>
                                </template>
                            </el-dropdown>
                        </div>
                    </div>
                </div>
                <div class="relative mt-4">
                    <div class="scroll-shadow shadow-left" v-show="showLeftShadow"></div>
                    <div class="scroll-shadow shadow-right" v-show="showRightShadow"></div>
                    <div class="overflow-x-auto" ref="scrollContainer">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="sticky-column">Hostname</th>
                                    <th v-if="columns.bloquear_cuenta.visible" class="text-center">Bloquear <br>cuenta
                                    </th>
                                    <th v-if="columns.nombre.visible" class="column-name">Nombre</th>
                                    <th v-if="columns.ruc.visible">RUC</th>
                                    <th v-if="columns.plan.visible">Plan</th>
                                    <th v-if="columns.correo.visible">Correo</th>
                                    <th v-if="columns.entorno.visible">Entorno</th>
                                    <th v-if="columns.total_comprobantes.visible" class="text-center sortable-header"
                                        @click="sortBy('total_comprobantes')">
                                        Total de<br>Comprobantes
                                        <span class="sort-icons">
                                            <i class="fas fa-sort" v-if="sorting.column !== 'total_comprobantes'"></i>
                                            <i class="fas fa-sort-up"
                                                v-if="sorting.column === 'total_comprobantes' && sorting.direction === 'asc'"></i>
                                            <i class="fas fa-sort-down"
                                                v-if="sorting.column === 'total_comprobantes' && sorting.direction === 'desc'"></i>
                                        </span>
                                    </th>
                                    <th v-if="columns.notificaciones.visible" class="text-center sortable-header"
                                        @click="sortBy('notificaciones')">
                                        Notificaciones
                                        <span class="sort-icons">
                                            <i class="fas fa-sort" v-if="sorting.column !== 'notificaciones'"></i>
                                            <i class="fas fa-sort-up"
                                                v-if="sorting.column === 'notificaciones' && sorting.direction === 'asc'"></i>
                                            <i class="fas fa-sort-down"
                                                v-if="sorting.column === 'notificaciones' && sorting.direction === 'desc'"></i>
                                        </span>
                                    </th>
                                    <th v-if="columns.inicio_ciclo.visible" class="text-end">Inicio <br>Ciclo
                                        Facturacion</th>
                                    <th v-if="columns.comprobantes_ciclo.visible" class="text-center sortable-header"
                                        @click="sortBy('comprobantes_ciclo')">
                                        Comprobantes<br>Ciclo Facturacion
                                        <span class="sort-icons">
                                            <i class="fas fa-sort" v-if="sorting.column !== 'comprobantes_ciclo'"></i>
                                            <i class="fas fa-sort-up"
                                                v-if="sorting.column === 'comprobantes_ciclo' && sorting.direction === 'asc'"></i>
                                            <i class="fas fa-sort-down"
                                                v-if="sorting.column === 'comprobantes_ciclo' && sorting.direction === 'desc'"></i>
                                        </span>
                                    </th>
                                    <th v-if="columns.usuarios.visible" class="text-center sortable-header"
                                        @click="sortBy('usuarios')">
                                        Usuarios
                                        <span class="sort-icons">
                                            <i class="fas fa-sort" v-if="sorting.column !== 'usuarios'"></i>
                                            <i class="fas fa-sort-up"
                                                v-if="sorting.column === 'usuarios' && sorting.direction === 'asc'"></i>
                                            <i class="fas fa-sort-down"
                                                v-if="sorting.column === 'usuarios' && sorting.direction === 'desc'"></i>
                                        </span>
                                    </th>
                                    <th v-if="columns.sucursales.visible" class="text-center sortable-header"
                                        @click="sortBy('sucursales')">
                                        Sucursales
                                        <span class="sort-icons">
                                            <i class="fas fa-sort" v-if="sorting.column !== 'sucursales'"></i>
                                            <i class="fas fa-sort-up"
                                                v-if="sorting.column === 'sucursales' && sorting.direction === 'asc'"></i>
                                            <i class="fas fa-sort-down"
                                                v-if="sorting.column === 'sucursales' && sorting.direction === 'desc'"></i>
                                        </span>
                                    </th>
                                    <th v-if="columns.ventas_mes.visible" class="text-center sortable-header"
                                        @click="sortBy('ventas_mes')">
                                        Ventas (Mes)
                                        <span class="sort-icons">
                                            <i class="fas fa-sort" v-if="sorting.column !== 'ventas_mes'"></i>
                                            <i class="fas fa-sort-up"
                                                v-if="sorting.column === 'ventas_mes' && sorting.direction === 'asc'"></i>
                                            <i class="fas fa-sort-down"
                                                v-if="sorting.column === 'ventas_mes' && sorting.direction === 'desc'"></i>
                                        </span>
                                    </th>
                                    <th v-if="columns.fecha_creacion.visible" class="text-center">F.Creación</th>
                                    <th v-if="columns.consultas_api.visible" class="text-center">Consultas <br>API Peru
                                        <br>(mes)</th>
                                    <th v-if="columns.notas_venta.visible" class="text-center">Cant. <br>Notas de venta
                                    </th>
                                    <th v-if="columns.total_mes.visible" class="text-center">
                                        Total<br><small>(Comprobantes <br>por
                                            mes)</small></th>
                                    <th v-if="columns.total_pse.visible" class="text-center">
                                        Total<br><small>(Comprobantes <br>a
                                            PSE-GIOR)</small></th>
                                    <th v-if="columns.total_notas.visible" class="text-center">
                                        Total<br><small>(Comprobantes <br>notas
                                            de venta)</small></th>
                                    <th v-if="columns.limitar_doc.visible" class="text-end">Limitar Doc.</th>
                                    <th v-if="columns.limitar_usuarios.visible" class="text-center">Limitar <br>Usuarios
                                    </th>
                                    <th v-if="columns.limitar_sucursales.visible" class="text-center">Limitar
                                        <br>Sucursales</th>
                                    <th v-if="columns.limitar_ventas.visible" class="text-center">
                                        <el-tooltip class="item"
                                            content="Límite de ventas mensual asociado al ciclo de facturación"
                                            effect="dark" placement="top">
                                            <label>Limitar <br>Ventas (Mes)</label>
                                        </el-tooltip>
                                    </th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row, index) in paginatedRecords" :key="index">
                                    <td>{{ ((pagination.currentPage - 1) * pagination.itemsPerPage) + index + 1 }}</td>
                                    <td class="sticky-column">
                                        <!-- {{ row.hostname }} -->
                                        <a :href="`http://${row.hostname}`" style="color:black" target="_blank">{{
                                            row.hostname }}</a>
                                    </td>
                                    <td v-if="columns.bloquear_cuenta.visible" class="text-center">
                                        <template v-if="!row.locked">
                                            <el-switch v-model="row.locked_tenant" style="display: block"
                                                @change="changeLockedTenant(row)"></el-switch>
                                        </template>
                                    </td>
                                    <td v-if="columns.nombre.visible" class="column-name table-cell">{{ row.name }}</td>
                                    <td v-if="columns.ruc.visible">{{ row.number }}</td>
                                    <td v-if="columns.plan.visible">{{ row.plan }}</td>
                                    <td v-if="columns.correo.visible">{{ row.email }}</td>
                                    <td v-if="columns.entorno.visible">
                                        <span v-if="row.soap_type == '01'" class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-100 text-gray-800">Demo</span>
                                        <span v-if="row.soap_type == '02'" class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-green-100 text-green-700">Producción</span>
                                        <span v-if="row.soap_type == '03'" class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-blue-100 text-blue-700">Interno</span>
                                    </td>
                                    <td v-if="columns.total_comprobantes.visible" class="text-center">
                                        <label>
                                            <strong>{{ row.count_doc }}</strong>
                                        </label>
                                    </td>

                                    <td v-if="columns.notificaciones.visible" class="d-flex justify-content-center">
                                        <template
                                            v-if="row.document_not_sent > 0 || row.document_to_be_regularized > 0 || row.document_to_be_canceled > 0">
                                            <el-tooltip class="item" content="Comprobantes enviados / por enviar"
                                                effect="dark" placement="top-start">
                                                <el-badge v-if="row.document_not_sent > 0"
                                                    :value="row.document_not_sent" class="item mx-2"
                                                    :type="row.document_not_sent == 0 ? 'primary' : 'danger'">
                                                    <i class="far fa-bell text-secondary"></i>
                                                </el-badge>
                                            </el-tooltip>

                                            <el-tooltip class="item" content="Comprobantes pendientes de rectificación"
                                                effect="dark" placement="top-start">
                                                <el-badge v-if="row.document_to_be_regularized > 0"
                                                    :value="row.document_regularize_shipping" class="item mx-2"
                                                    :type="row.document_regularize_shipping == 0 ? 'primary' : 'danger'">
                                                    <i class="fas fa-exclamation-triangle text-secondary"></i>
                                                </el-badge>
                                            </el-tooltip>

                                            <el-tooltip class="item" content="Comprobantes por anular" effect="dark"
                                                placement="top-start">
                                                <el-badge v-if="row.document_to_be_canceled > 0"
                                                    :value="row.document_to_be_canceled" class="item mx-2"
                                                    :type="row.document_to_be_canceled == 0 ? 'primary' : 'danger'">
                                                    <i class="fas fa-exclamation-circle text-secondary"></i>
                                                </el-badge>
                                            </el-tooltip>

                                        </template>

                                        <template v-else>
                                            <span class="text-gray-500 text-xs flex items-center">
                                                Todo OK
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check ml-1 text-green-600">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                    <path d="M9 12l2 2l4 -4" />
                                                </svg>
                                            </span>
                                        </template>
                                    </td>
                                    <td v-if="columns.inicio_ciclo.visible">
                                        <template v-if="row.start_billing_cycle">
                                            <span></span>
                                            <span>{{ row.start_billing_cycle }}</span>
                                        </template>
                                        <template v-else>
                                            <el-date-picker v-model="row.select_date_billing" placeholder="..."
                                                type="date" value-format="yyyy-MM-dd"
                                                @change="setStartBillingCycle($event, row.id)"></el-date-picker>
                                        </template>
                                    </td>

                                    <td v-if="columns.comprobantes_ciclo.visible" class="text-center">
                                        <strong>
                                            <template v-if="row.sale_notes_quantity_if_include > 0">
                                                {{ row.count_doc_month ? (row.count_doc_month +
                                                row.sale_notes_quantity_if_include) : 0 }} /
                                            </template>
                                            <template v-else>
                                                {{ row.count_doc_month ? row.count_doc_month : 0 }} /
                                            </template>

                                            <template v-if="row.max_documents == 0">
                                                <i class="fas fa-infinity"></i>
                                            </template>
                                            <template v-else>
                                                <strong>{{ row.max_documents }}</strong>
                                            </template>
                                        </strong>
                                    </td>

                                    <td v-if="columns.usuarios.visible" class="text-center">
                                        <template v-if="row.max_users !== 0 && row.count_user > row.max_users">
                                            <el-popover :content="text_limit_users" placement="top-start"
                                                trigger="hover" width="220">
                                                <template #reference>
                                                    <label class="text-danger">
                                                        <strong>{{ row.count_user }}</strong>
                                                    </label>
                                                </template>
                                            </el-popover>
                                        </template>
                                        <template v-else>
                                            <label>
                                                <strong>{{ row.count_user }}</strong>
                                            </label>
                                        </template>
                                        /
                                        <template v-if="row.max_users == 0">
                                            <i class="fas fa-infinity"></i>
                                        </template>
                                        <template v-else>
                                            <strong>{{ row.max_users }}</strong>
                                        </template>
                                    </td>

                                    <td v-if="columns.sucursales.visible" class="text-center">

                                        <data-limit-notification entity_description="sucursales"
                                            :unlimited="row.establishments_unlimited"
                                            :quantity="row.quantity_establishments"
                                            :max_quantity="row.max_quantity_establishments">
                                        </data-limit-notification>

                                    </td>

                                    <td v-if="columns.ventas_mes.visible" class="text-center">

                                        <data-limit-notification entity_description="ventas"
                                            style_div="width: 150px !important" :unlimited="row.sales_unlimited"
                                            :quantity="row.monthly_sales_total" :max_quantity="row.max_sales_limit">
                                        </data-limit-notification>

                                    </td>


                                    <td v-if="columns.fecha_creacion.visible" class="text-center">{{ row.created_at }}
                                    </td>
                                    <td v-if="columns.consultas_api.visible">{{ row.queries_to_apiperu }}</td>

                                    <td v-if="columns.notas_venta.visible" class="text-center"><strong>{{
                                            row.count_sales_notes
                                            }}</strong></td>
                                    <td v-if="columns.total_mes.visible" class="text-center"><strong>{{
                                            row.current_count_doc_month
                                            }}</strong></td>
                                    <td v-if="columns.total_pse.visible" class="text-center"><strong>{{
                                            row.count_doc_pse }}</strong>
                                    </td>
                                    <td v-if="columns.total_notas.visible" class="text-center"><strong>{{
                                        row.count_doc_month +
                                            row.count_sales_notes_month }}</strong></td>

                                    <td v-if="columns.limitar_doc.visible" class="text-center">
                                        <el-switch v-model="row.locked_emission" style="display: block"
                                            @change="changeLockedEmission(row)"></el-switch>
                                    </td>

                                    <td v-if="columns.limitar_usuarios.visible" class="text-center">
                                        <el-switch v-model="row.locked_users" style="display: block"
                                            @change="changeLockedUser(row)"></el-switch>
                                    </td>

                                    <td v-if="columns.limitar_sucursales.visible" class="text-center">
                                        <el-switch v-model="row.locked_create_establishments" style="display: block"
                                            @change="changeLockedByColumn(row, 'locked_create_establishments')"></el-switch>
                                    </td>

                                    <td v-if="columns.limitar_ventas.visible" class="text-center">
                                        <el-switch v-model="row.restrict_sales_limit" style="display: block"
                                            @change="changeLockedByColumn(row, 'restrict_sales_limit')"></el-switch>
                                    </td>

                                    <td class="text-end">
                                        <el-dropdown trigger="click" @command="handleCommand" placement="bottom-end">
                                            <template #default>
                                                <el-button type="text" size="small" class="dropdown-trigger">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </el-button>
                                            </template>
                                            <template #dropdown>
                                                <el-dropdown-menu>
                                                    <template v-if="!row.locked">
                                                        <el-dropdown-item :command="{ action: 'password', id: row.id }">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-key me-2">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path
                                                                    d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" />
                                                                <path d="M15 9h.01" />
                                                            </svg>
                                                            Restablecer contraseña
                                                        </el-dropdown-item>
                                                        <el-dropdown-item class="text-danger option-delete"
                                                            v-if="deletePermission == true"
                                                            :command="{ action: 'delete', row: row }" divided>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-trash me-2">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M4 7l16 0" />
                                                                <path d="M10 11l0 6" />
                                                                <path d="M14 11l0 6" />
                                                                <path
                                                                    d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                            </svg>
                                                            Eliminar Cliente
                                                        </el-dropdown-item>
                                                    </template>
                                                    <el-dropdown-item :command="{ action: 'edit', id: row.id }"
                                                        :divided="!row.locked">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-edit me-2">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                            <path
                                                                d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                            <path d="M16 5l3 3" />
                                                        </svg>
                                                        Editar
                                                    </el-dropdown-item>
                                                    <el-dropdown-item v-if="row.soap_type == '01'"
                                                        :command="{ action: 'demoConfig', id: row.id }">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-settings me-2">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                                                            <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                                        </svg>
                                                        Configurar Demo
                                                    </el-dropdown-item>
                                                    <el-dropdown-item :command="{ action: 'secretLogin', id: row.id }">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-dual-screen me-2">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M5 4l8 3v15l-8 -3z" />
                                                            <path d="M13 19h6v-15h-14" />
                                                        </svg>
                                                        Acceso Maestro
                                                    </el-dropdown-item>
                                                    <el-dropdown-item :command="{ action: 'payments', id: row.id }"
                                                        divided>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-cash-banknote me-2">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                                            <path
                                                                d="M3 8a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                                            <path d="M18 12h.01" />
                                                            <path d="M6 12h.01" />
                                                        </svg>
                                                        Pagos
                                                    </el-dropdown-item>
                                                    <el-dropdown-item :command="{ action: 'accountStatus', id: row.id }">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-chart-line me-2">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M4 19l16 0" />
                                                            <path d="M4 15l4 -6l4 2l4 -5l4 4" />
                                                        </svg>
                                                        Estado de cuenta
                                                    </el-dropdown-item>
                                                </el-dropdown-menu>
                                            </template>
                                        </el-dropdown>
                                    </td>
                                    <!-- <td class="text-right">
                                <button
                                    class="btn waves-effect waves-light btn-xs btn-warning m-1__2"
                                    type="button"
                                    @click.prevent="clickPayments(row.id)"
                                >Pagos
                                </button>
                            </td>
                            <td class="text-right">
                                <button
                                    class="btn waves-effect waves-light btn-xs btn-primary m-1__2"
                                    type="button"
                                    @click.prevent="clickAccountStatus(row.id)"
                                >E. Cuenta
                                </button>
                            </td>
                            <td class="text-right">
                                <button
                                    class="btn waves-effect waves-light btn-xs btn-primary m-1__2"
                                    type="button"
                                    @click.prevent="clickEdit(row.id)"
                                >Editar
                                </button>
                            </td> -->

                                </tr>

                                <!-- Fila cuando no hay resultados -->
                                <tr v-if="filteredRecords.length === 0 && records.length > 0">
                                    <td colspan="20" class="text-center py-4">
                                        <div class="text-muted">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                style="opacity: 0.5;" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                <path d="M21 21l-6 -6" />
                                            </svg>
                                            <p class="mb-0">No se encontraron clientes que coincidan con los filtros
                                                aplicados.</p>
                                            <small>
                                                <template v-if="searchQuery">
                                                    Búsqueda: "{{ searchQuery }}"
                                                </template>
                                                <template v-if="filters.entorno">
                                                    | Entorno: {{ getEntornoLabel(filters.entorno) }}
                                                </template>
                                                <template v-if="filters.plan">
                                                    | Plan: {{ filters.plan }}
                                                </template>
                                                <template v-if="filters.bloqueo !== ''">
                                                    | Estado: {{ filters.bloqueo === '1' ? 'Bloqueados' : 'Activos' }}
                                                </template>
                                            </small>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Controles de paginación -->
                <div class="grid grid-cols-1 md:grid-cols-2 mt-3">
                    <div class="flex items-center">
                        <div class="pagination-info">
                            <span class="text-gray-500">
                                Mostrando {{ paginationInfo.start }} a {{ paginationInfo.end }} de {{
                                paginationInfo.total }} registros
                            </span>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-end items-center">
                            <!-- Selector de elementos por página -->
                            <div class="mr-3">
                                <label class="mr-2 text-gray-500">Mostrar:</label>
                                <el-select v-model="pagination.itemsPerPage" @change="changeItemsPerPage" size="small"
                                    class="w-20">
                                    <el-option v-for="option in pagination.itemsPerPageOptions" :key="option"
                                        :label="option" :value="option">
                                    </el-option>
                                </el-select>
                            </div>

                            <!-- Navegación de páginas -->
                            <div class="pagination-controls">
                                <el-pagination @current-change="changePage" :current-page="pagination.currentPage"
                                    :page-size="pagination.itemsPerPage" :total="filteredRecords.length"
                                    layout="prev, pager, next" :hide-on-single-page="false" small>
                                </el-pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <system-clients-form :recordId="recordId" v-model:showDialog="showDialog"></system-clients-form>

        <!--<system-clients-form-edit :showDialog.sync="showDialogEdit"
        :recordId="recordId"></system-clients-form-edit>-->

        <client-payments :clientId="recordId" v-model:showDialog="showDialogPayments"></client-payments>

        <account-status :clientId="recordId" v-model:showDialog="showDialogAccountStatus"></account-status>

        <client-delete :record="record" v-model:showDialog="showDialogDelete"></client-delete>

        <demo-configuration :clientId="recordId" v-model:showDialog="showDemoConfiguration"></demo-configuration>
    </div>
</template>
<style>
.table th,
.table td {
    white-space: nowrap;
}

th.sticky-column,
td.sticky-column {
    position: sticky;
    left: 0;
    background-color: #fff !important;
    z-index: 1;
}

th.sticky-column.scroll-active::after,
td.sticky-column.scroll-active::after {
    opacity: 1;
    transition: opacity 0.2s ease;
}

th.sticky-column::after,
td.sticky-column::after {
    content: "";
    position: absolute;
    top: 0;
    right: -6px;
    width: 6px;
    height: 100%;
    background: linear-gradient(to right, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0));
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.2s ease;
}

th.sticky-column {
    z-index: 2;
}

.dropdown-trigger {
    color: #6c757d;
    border: none !important;
    background: none !important;
    box-shadow: none !important;
    padding: 4px 8px;
}

.dropdown-trigger:hover {
    color: #495057;
    background-color: #f8f9fa !important;
}

.shadow-right {
    right: 0px;
}

.shadow-left {
    left: 0px;
    z-index: 3;
}

.page-header {
    position: relative;
}

.page-header-actions {
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
}

@media (max-width: 768px) {
    .page-header-actions {
        position: static;
        transform: none;
        margin-top: 1rem;
    }
}

/* Estilos para paginación */
.pagination-info {
    font-size: 14px;
}

.pagination-controls .el-pagination {
    padding: 0;
}

.pagination-controls .el-pagination .el-pager li {
    min-width: 30px;
    height: 30px;
    line-height: 30px;
    font-size: 13px;
}

.pagination-controls .el-pagination .btn-prev,
.pagination-controls .el-pagination .btn-next {
    height: 30px;
    line-height: 30px;
    font-size: 13px;
}

@media (max-width: 768px) {

    .pagination-info,
    .pagination-controls {
        text-align: center;
        margin-bottom: 10px;
    }

    .col-md-6 .d-flex {
        justify-content: center !important;
    }
}
</style>
<script setup>
import { ref, reactive, computed, onMounted, nextTick, getCurrentInstance } from 'vue'
import ChartLine from "./charts/Line.vue"
import SystemClientsForm from "./form.vue"
import ClientPayments from "./partials/payments.vue"
import DemoConfiguration from "./partials/demo_configuration.vue"
import AccountStatus from "./partials/account_status.vue"
import ClientDelete from "./partials/delete.vue"
import DataLimitNotification from "./partials/DataLimitNotification.vue"

// Props
const props = defineProps({
    deletePermission: Boolean,
    discUsed: [String, Number],
    iUsed: [String, Number],
    storageSize: [String, Number],
    version: String
})

// Obtener instancia de Vue para acceder a propiedades globales
const instance = getCurrentInstance()
const $http = instance?.appContext.config.globalProperties.$http
const $eventHub = instance?.appContext.config.globalProperties.$eventHub
const $message = instance?.appContext.config.globalProperties.$message
const $confirm = instance?.appContext.config.globalProperties.$confirm

// Estado reactivo
const searchQuery = ref("")
const selectBillingDate = ref("")
const showDialogEdit = ref(false)
const showDialog = ref(false)
const showDialogPayments = ref(false)
const showDialogAccountStatus = ref(false)
const resource = ref("clients")
const recordId = ref(null)
const records = ref([])
const text_limit_doc = ref(null)
const text_limit_users = ref(null)
const loaded = ref(false)
const chartDataLoaded = ref(false)
const year = ref(window.moment ? window.moment().format('YYYY') : new Date().getFullYear().toString())
const total_documents = ref(0)
const showDialogDelete = ref(false)
const record = ref({})
const showDemoConfiguration = ref(false)
const showLeftShadow = ref(false)
const showRightShadow = ref(false)
const isFiltersVisible = ref(false)
const scrollContainer = ref(null)

// Objetos reactivos
const filters = reactive({
    entorno: "",
    plan: "",
    bloqueo: ""
})

const pagination = reactive({
    currentPage: 1,
    itemsPerPage: 20,
    itemsPerPageOptions: [5, 10, 20, 50, 100]
})

const sorting = reactive({
    column: null,
    direction: 'asc'
})

const dateFilters = reactive({
    startDate: null,
    endDate: null,
    appliedStartDate: null,
    appliedEndDate: null
})

const dataChartLine = reactive({
    labels: [],
    datasets: [
        {
            data: []
        }
    ]
})

const columns = reactive({
    nombre: {
        title: 'Nombre',
        visible: true
    },
    ruc: {
        title: 'RUC',
        visible: true
    },
    plan: {
        title: 'Plan',
        visible: true
    },
    correo: {
        title: 'Correo',
        visible: true
    },
    entorno: {
        title: 'Entorno',
        visible: true
    },
    total_comprobantes: {
        title: 'Total de Comprobantes',
        visible: false
    },
    notificaciones: {
        title: 'Notificaciones',
        visible: true
    },
    inicio_ciclo: {
        title: 'Inicio Ciclo Facturación',
        visible: false
    },
    comprobantes_ciclo: {
        title: 'Comprobantes Ciclo Facturación',
        visible: true
    },
    usuarios: {
        title: 'Usuarios',
        visible: true
    },
    sucursales: {
        title: 'Sucursales',
        visible: false
    },
    ventas_mes: {
        title: 'Ventas (Mes)',
        visible: false
    },
    fecha_creacion: {
        title: 'F.Creación',
        visible: true
    },
    consultas_api: {
        title: 'Consultas API Peru (mes)',
        visible: false
    },
    notas_venta: {
        title: 'Cant.Notas de venta',
        visible: false
    },
    total_mes: {
        title: 'Total (Comprobantes por mes)',
        visible: false
    },
    total_pse: {
        title: 'Total (Comprobantes a PSE-GIOR)',
        visible: false
    },
    total_notas: {
        title: 'Total (Comprobantes notas de venta)',
        visible: false
    },
    bloquear_cuenta: {
        title: 'Bloquear cuenta',
        visible: true
    },
    limitar_doc: {
        title: 'Limitar Doc.',
        visible: false
    },
    limitar_usuarios: {
        title: 'Limitar Usuarios',
        visible: false
    },
    limitar_sucursales: {
        title: 'Limitar Sucursales',
        visible: false
    },
    limitar_ventas: {
        title: 'Limitar Ventas (Mes)',
        visible: false
    }
})

// Computed
const filteredRecords = computed(() => {
    let filtered = records.value

    // Filtro por búsqueda de texto
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase()
        filtered = filtered.filter((row) => {
            return (
                (row.name && row.name.toLowerCase().includes(query)) ||
                (row.hostname && row.hostname.toLowerCase().includes(query)) ||
                (row.email && row.email.toLowerCase().includes(query)) ||
                (row.number && row.number.toLowerCase().includes(query))
            )
        })
    }

    // Filtro por entorno
    if (filters.entorno) {
        filtered = filtered.filter((row) => {
            return row.soap_type === filters.entorno
        })
    }

    // Filtro por plan
    if (filters.plan) {
        filtered = filtered.filter((row) => {
            return row.plan === filters.plan
        })
    }

    // Filtro por estado de bloqueo
    if (filters.bloqueo !== "") {
        filtered = filtered.filter((row) => {
            const isBlocked = Boolean(row.locked_tenant)

            if (filters.bloqueo === "1") {
                return isBlocked // Bloqueados
            } else if (filters.bloqueo === "0") {
                return !isBlocked // Activos
            }
            return true
        })
    }

    // Aplicar ordenamiento si hay una columna seleccionada
    if (sorting.column) {
        filtered = sortRecords(filtered, sorting.column, sorting.direction)
    }

    return filtered
})

const paginatedRecords = computed(() => {
    const start = (pagination.currentPage - 1) * pagination.itemsPerPage
    const end = start + pagination.itemsPerPage
    return filteredRecords.value.slice(start, end)
})

const totalPages = computed(() => {
    return Math.ceil(filteredRecords.value.length / pagination.itemsPerPage)
})

const paginationInfo = computed(() => {
    const start = (pagination.currentPage - 1) * pagination.itemsPerPage + 1
    const end = Math.min(start + pagination.itemsPerPage - 1, filteredRecords.value.length)
    return {
        start: filteredRecords.value.length > 0 ? start : 0,
        end: end,
        total: filteredRecords.value.length
    }
})

const availablePlans = computed(() => {
    const plans = [...new Set(records.value.map(record => record.plan).filter(plan => plan))]
    return plans.sort()
})

const columnsComputed = computed(() => {
    return columns
})

const hasActiveFilters = computed(() => {
    return !!(
        searchQuery.value ||
        filters.entorno ||
        filters.plan ||
        filters.bloqueo !== ""
    )
})

const hasActiveDateFilter = computed(() => {
    return !!(dateFilters.appliedStartDate && dateFilters.appliedEndDate)
})

// Métodos de mixins (deletable y changeable)
const change = (url) => {
    return new Promise((resolve) => {
        $confirm('¿Desea cambiar la clave?', 'Cambiar clave', {
            confirmButtonText: 'Cambiar',
            cancelButtonText: 'Cancelar',
            type: 'warning'
        }).then(() => {
            $http.post(url)
                .then(res => {
                    if (res.data.success) {
                        $message.success('Se cambió correctamente la clave')
                        resolve()
                    }
                })
                .catch(error => {
                    if (error.response?.status === 500) {
                        $message.error('Error al intentar cambiar')
                    } else {
                        console.log(error.response?.data?.message)
                    }
                })
        }).catch(error => {
            console.log(error)
        })
    })
}

// Métodos
const saveColumnVisibility = () => {
    localStorage.setItem('columnVisibilityClients', JSON.stringify(columns))
}

const loadColumnVisibility = () => {
    const savedColumns = localStorage.getItem('columnVisibilityClients')
    if (savedColumns) {
        Object.assign(columns, JSON.parse(savedColumns))
    }
}

const applyFilters = () => {
    console.log('Filtros aplicados:', filters)

    // Resetear a la primera página cuando se aplican filtros
    pagination.currentPage = 1

    nextTick(() => {
        const totalRecords = records.value.length
        const filteredCount = filteredRecords.value.length

        if (filters.bloqueo !== "" && filteredCount === 0) {
            const filterType = filters.bloqueo === "1" ? "bloqueados" : "activos"
            console.log(`No se encontraron clientes ${filterType} de un total de ${totalRecords} registros`)
        }
    })
}

const changePage = (page) => {
    pagination.currentPage = page
}

const changeItemsPerPage = () => {
    // Resetear a la primera página cuando se cambia el número de elementos por página
    pagination.currentPage = 1
}

const sortBy = (column) => {
    if (sorting.column === column) {
        // Si ya está ordenando por esta columna, cambiar dirección
        sorting.direction = sorting.direction === 'asc' ? 'desc' : 'asc'
    } else {
        // Nueva columna, empezar con ascendente
        sorting.column = column
        sorting.direction = 'asc'
    }
    // Resetear a la primera página cuando se ordena
    pagination.currentPage = 1
}

const sortRecords = (records, column, direction) => {
    return [...records].sort((a, b) => {
        let valueA, valueB

        switch (column) {
            case 'total_comprobantes':
                valueA = parseInt(a.count_doc) || 0
                valueB = parseInt(b.count_doc) || 0
                break
            case 'notificaciones':
                valueA = (parseInt(a.document_not_sent) || 0) +
                    (parseInt(a.document_to_be_regularized) || 0) +
                    (parseInt(a.document_to_be_canceled) || 0)
                valueB = (parseInt(b.document_not_sent) || 0) +
                    (parseInt(b.document_to_be_regularized) || 0) +
                    (parseInt(b.document_to_be_canceled) || 0)
                break
            case 'comprobantes_ciclo':
                valueA = parseInt(a.count_doc_month) || 0
                valueB = parseInt(b.count_doc_month) || 0
                break
            case 'usuarios':
                valueA = parseInt(a.count_user) || 0
                valueB = parseInt(b.count_user) || 0
                break
            case 'sucursales':
                valueA = parseInt(a.quantity_establishments) || 0
                valueB = parseInt(b.quantity_establishments) || 0
                break
            case 'ventas_mes':
                valueA = parseFloat(a.monthly_sales_total) || 0
                valueB = parseFloat(b.monthly_sales_total) || 0
                break
            default:
                return 0
        }

        if (direction === 'asc') {
            return valueA - valueB
        } else {
            return valueB - valueA
        }
    })
}

const clearFilters = () => {
    filters.entorno = ""
    filters.plan = ""
    filters.bloqueo = ""
    searchQuery.value = ""
    // Resetear paginación al limpiar filtros
    pagination.currentPage = 1
}

const onDateFilterChange = () => {
    // Este método se ejecuta cuando cambian las fechas pero no aplica el filtro automáticamente
    console.log('Fechas seleccionadas:', dateFilters.startDate, dateFilters.endDate)
}

const applyDateFilter = () => {
    if (!dateFilters.startDate || !dateFilters.endDate) {
        $message.warning('Por favor selecciona ambas fechas')
        return
    }

    if (new Date(dateFilters.startDate) > new Date(dateFilters.endDate)) {
        $message.error('La fecha de inicio no puede ser mayor que la fecha de fin')
        return
    }

    // Guardar las fechas aplicadas
    dateFilters.appliedStartDate = dateFilters.startDate
    dateFilters.appliedEndDate = dateFilters.endDate

    // Recargar datos con el filtro de fechas
    getData()

    $message.success('Filtro de fechas aplicado correctamente')
}

const clearDateFilter = () => {
    dateFilters.startDate = null
    dateFilters.endDate = null
    dateFilters.appliedStartDate = null
    dateFilters.appliedEndDate = null

    // Recargar datos sin filtro de fechas
    getData()

    $message.success('Filtro de fechas eliminado')
}

const formatDate = (dateString) => {
    if (!dateString) return ''
    const date = new Date(dateString)
    return date.toLocaleDateString('es-ES')
}

const toggleFilters = () => {
    isFiltersVisible.value = !isFiltersVisible.value
}

const getEntornoLabel = (value) => {
    const entornos = {
        '01': 'Demo',
        '02': 'Producción',
        '03': 'Interno'
    }
    return entornos[value] || value
}

const checkScrollShadows = () => {
    const el = scrollContainer.value
    if (!el) return

    const scrollLeft = el.scrollLeft
    const scrollRight = el.scrollWidth - el.clientWidth - scrollLeft

    showLeftShadow.value = scrollLeft > 1
    showRightShadow.value = scrollRight > 1
}

const handleCommand = (command) => {
    switch (command.action) {
        case 'password':
            clickPassword(command.id)
            break
        case 'delete':
            clickDelete(command.row)
            break
        case 'edit':
            clickEdit(command.id)
            break
        case 'demoConfig':
            clickDemoConfiguration(command.id)
            break
        case 'secretLogin':
            clickSecretLogin(command.id)
            break
        case 'payments':
            clickPayments(command.id)
            break
        case 'accountStatus':
            clickAccountStatus(command.id)
            break
    }
}

const initScrollShadow = () => {
    nextTick(() => {
        const container = scrollContainer.value
        if (!container) return

        container.addEventListener('scroll', () => {
            const isScrolled = container.scrollLeft > 0

            const thSticky = container.querySelector('th.sticky-column')
            const tdStickies = container.querySelectorAll('tbody td.sticky-column')

            if (thSticky) {
                if (isScrolled) thSticky.classList.add('scroll-active')
                else thSticky.classList.remove('scroll-active')
            }

            tdStickies.forEach(td => {
                if (isScrolled) td.classList.add('scroll-active')
                else td.classList.remove('scroll-active')
            })
        })

        container.dispatchEvent(new Event('scroll'))
    })
}

const changeLockedTenant = (row) => {
    $http
        .post(`${resource.value}/locked_tenant`, row)
        .then(response => {
            if (response.data.success) {
                $message.success(response.data.message)
                $eventHub.$emit("reloadData")
            } else {
                $message.error(response.data.message)
            }
        })
        .catch(error => {
            if (error.response?.status === 500) {
                $message.error(error.response.data.message)
            } else {
                console.log(error.response)
            }
        })
}

const changeLockedUser = (row) => {
    $http
        .post(`${resource.value}/locked_user`, row)
        .then(response => {
            if (response.data.success) {
                $message.success(response.data.message)
                $eventHub.$emit("reloadData")
            } else {
                $message.error(response.data.message)
            }
        })
        .catch(error => {
            if (error.response?.status === 500) {
                $message.error(error.response.data.message)
            } else {
                console.log(error.response)
            }
        })
}

const changeLockedByColumn = (row, column) => {
    const params = { ...row }
    params.column = column

    $http
        .post(`${resource.value}/locked-by-column`, params)
        .then(response => {
            if (response.data.success) {
                $message.success(response.data.message)
                $eventHub.$emit("reloadData")
            } else {
                $message.error(response.data.message)
            }
        })
        .catch(error => {
            if (error.response?.status === 500) {
                $message.error(error.response.data.message)
            } else {
                console.log(error.response)
            }
        })
}

const setStartBillingCycle = (event, id) => {
    $http
        .post(`${resource.value}/set_billing_cycle`, {
            id: id,
            start_billing_cycle: event
        })
        .then(response => {
            if (response.data.success) {
                $message.success(response.data.message)
            } else {
                $message.error(response.data.message)
            }
        })
        .catch(error => {
            if (error.response?.status === 500) {
                $message.error(error.response.data.message)
            } else {
                console.log(error.response)
            }
        })
        .then(() => {
            $eventHub.$emit("reloadData")
        })
}

const changeLockedEmission = (row) => {
    $http
        .post(`${resource.value}/locked_emission`, row)
        .then(response => {
            if (response.data.success) {
                $message.success(response.data.message)
                $eventHub.$emit("reloadData")
            } else {
                $message.error(response.data.message)
            }
        })
        .catch(error => {
            if (error.response?.status === 500) {
                $message.error(error.response.data.message)
            } else {
                console.log(error.response)
            }
        })
}

const getData = () => {
    // Construir parámetros para la petición
    let params = {}

    // Agregar parámetros de fecha si están aplicados
    if (dateFilters.appliedStartDate && dateFilters.appliedEndDate) {
        params.start_date = dateFilters.appliedStartDate
        params.end_date = dateFilters.appliedEndDate
    }

    $http.get(`/${resource.value}/records`, { params }).then(response => {
        records.value = response.data.data
        console.log('Datos recibidos:', records.value)
        console.log('Parámetros enviados:', params)
    }).catch(error => {
        console.error('Error al obtener datos:', error)
        $message.error('Error al cargar los datos')
    })
}

const clickCreate = (recordIdParam = null) => {
    recordId.value = recordIdParam
    showDialog.value = true
}

const clickPayments = (recordIdParam = null) => {
    recordId.value = recordIdParam
    showDialogPayments.value = true
}

const clickAccountStatus = (recordIdParam = null) => {
    recordId.value = recordIdParam
    showDialogAccountStatus.value = true
}

const clickSecretLogin = (clientId) => {
    // Crear un formulario dinámico para enviar la solicitud POST
    const form = document.createElement('form')
    form.method = 'POST'
    form.action = `/secret-login`
    form.style.display = 'none'

    // Agregar el token CSRF
    const csrfToken = document.head.querySelector('meta[name="csrf-token"]')?.content
    if (csrfToken) {
        const csrfInput = document.createElement('input')
        csrfInput.type = 'hidden'
        csrfInput.name = '_token'
        csrfInput.value = csrfToken
        form.appendChild(csrfInput)
    }

    // Agregar el ID del cliente
    const clientIdInput = document.createElement('input')
    clientIdInput.type = 'hidden'
    clientIdInput.name = 'client_id'
    clientIdInput.value = clientId
    form.appendChild(clientIdInput)

    // Agregar el formulario al documento y enviarlo
    document.body.appendChild(form)
    form.submit()
}

const clickPassword = (id) => {
    change(`/${resource.value}/password/${id}`)
}

const clickDelete = (recordParam) => {
    record.value = recordParam
    showDialogDelete.value = true
}

const clickEdit = (recordIdParam) => {
    recordId.value = recordIdParam
    showDialog.value = true
}

const clickDemoConfiguration = (recordIdParam = null) => {
    recordId.value = recordIdParam
    showDemoConfiguration.value = true
}

// Lifecycle hooks
onMounted(async () => {
    loaded.value = false
    chartDataLoaded.value = false

    try {
        const response = await $http.get(`/${resource.value}/charts`)
        let line = response.data.line

        if (line && line.labels && line.data) {
            dataChartLine.labels = line.labels
            dataChartLine.datasets[0].data = line.data
            total_documents.value = response.data.total_documents

            nextTick(() => {
                chartDataLoaded.value = true
            })
        }
    } catch (error) {
        console.error('Error loading chart data:', error)
        dataChartLine.labels = []
        dataChartLine.datasets[0].data = []
    }

    loaded.value = true
    initScrollShadow()
    nextTick(() => {
        const el = scrollContainer.value
        if (el) {
            el.addEventListener('scroll', checkScrollShadows)
            checkScrollShadows()
        }
    })
})

// Inicialización
try {
    // Verificar que $eventHub esté disponible antes de usarlo
    if ($eventHub && typeof $eventHub.$on === 'function') {
        $eventHub.$on("reloadData", () => {
            getData()
        })
    }

    // Llamar a getData
    getData()

    text_limit_doc.value = "El límite de comprobantes fue superado"
    text_limit_users.value = "El límite de usuarios fue superado"

    // Llamar a loadColumnVisibility
    loadColumnVisibility()
} catch (error) {
    console.error('Error en inicialización de SystemClientsIndex:', error)
}
</script>

<style scoped>
/* Estilos para ordenamiento */
.sortable-header {
    cursor: pointer;
    user-select: none;
    position: relative;
    transition: background-color 0.2s ease;
}

.sortable-header:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

.sort-icons {
    margin-left: 5px;
    font-size: 12px;
    color: #999;
    display: inline-block;
    width: 12px;
}

.sortable-header:hover .sort-icons {
    color: #666;
}

.sortable-header .fas.fa-sort-up,
.sortable-header .fas.fa-sort-down {
    color: #004387;
}

/* Estilos responsivos para ordenamiento */
@media (max-width: 768px) {
    .sort-icons {
        font-size: 10px;
        margin-left: 3px;
    }
}
</style>
