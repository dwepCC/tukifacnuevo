<script setup>
import { ref, reactive, computed, onMounted, watch, getCurrentInstance } from 'vue'
import Vue3Datatable from '@bhplugin/vue3-datatable'
import '@bhplugin/vue3-datatable/dist/style.css'
import { useMainStore } from '@/stores/main'
import _ from 'lodash'
const isOpen = ref(false);

const props = defineProps({
    isClient: {
        type: Boolean,
        required: true
    },
    userId: {
        type: Number,
        required: true
    },
    resource: String,
    typeUser: {
        type: String,
        default: ''
    },
    columns: {
        type: Object,
        default: () => ({})
    },
        configuration: { // ← Añade esto
        type: Object,
        default: () => ({})
    }
})
console.log(props.typeUser+' tipo d usario');
const emit = defineEmits(['reload'])

// Instance para acceder a globalProperties
const instance = getCurrentInstance()
const $http = instance?.appContext.config.globalProperties.$http
const $eventHub = instance?.appContext.config.globalProperties.$eventHub

// Store
const store = useMainStore()
const config = computed(() => store.config || {})

// State
const loading_submit = ref(false)
const loading_search = ref(false)
const loading_search_item = ref(false)
const records = ref([])
const pagination = reactive({
    current_page: 1,
    per_page: 10,
    total: 0
})
const see_more = ref(false)

// Filtros
const search = reactive({
    date_of_issue: null,
    document_type_id: null,
    customer_id: null,
    item_id: null,
    category_id: null,
    state_type_id: null,
    series: null,
    number: null,
    d_start: null,
    d_end: null,
    pending_payment: false,
    observations: null,
    establishment_id: null
})

// Opciones
const all_customers = ref([])
const customers = ref([])
const all_items = ref([])
const items = ref([])
const categories = ref([])
const state_types = ref([])
const document_types = ref([])
const all_series = ref([])
const series = ref([])
const establishments = ref([])

const pickerOptionsDates = reactive({
    disabledDate: (time) => {
        if (!search.d_start) return false
        const startDate = new Date(search.d_start)
        return time < startDate
    }
})


const tableColumns = ref([
    // ID (campo único requerido)
    {
        field: 'id',
        title: 'ID',
        isUnique: true,
        hide: true,
        filter: false,
        search: false,
        width: '90px'
    },

    // SOAP
    {
        field: 'soap_type_description',
        title: 'SOAP',
        width: '100px',
        hide: true,
    },

    // Emisión
    {
        field: 'date_of_issue',
        title: 'Emisión',
        width: '95px',
        type: 'date'
    },

    // Fecha de pago
    {
        field: 'date_of_payment',
        title: 'Fecha de pago',
        width: '95px',
        type: 'date',
        cellRenderer: (row) => row.date_of_payment,
        hide: true,
    },

    // Fecha Vencimiento
    {
        field: 'date_of_due',
        title: 'Fecha Vencimiento',
        width: '95px',
        type: 'date',
        cellRenderer: (row) => row.date_of_due,
        hide: true,
    },

    // Cliente
    {
        field: 'customer_name',
        title: 'Cliente',
        cellRenderer: (row) => row.customer_name
    },

    // Número
    {
        field: 'number',
        title: 'Número',
        cellRenderer: (row) => row.number
    },

    // Notas C/D
    {
        field: 'notes',
        title: 'Notas C/D',
        cellRenderer: (row) => row.notes,
        filter: false,
        hide: true,
        search: false,
    },

    // Guía de Remisión
    {
        field: 'dispatches',
        title: 'Guía de Remisión',
        cellRenderer: (row) => row.dispatches,
        filter: false,
        hide: true,
        search: false,
    },

        // Nota de venta
    {
        field: 'sales_note',
        title: 'Nota de venta',
        cellRenderer: (row) => row.sales_note,
        hide: true,
    },

        // Pedidos
    {
        field: 'order_note',
        title: 'Pedidos',
        cellRenderer: (row) => row.order_note,
        hide: true,
    },

        // Email Enviado
    {
        field: 'email_send_it',
        title: 'Email Enviado',
        cellRenderer: (row) => row.email_send_it,
        filter: false,
        search: false,
        hide: true,
    },

    // Estado
    {
        field: 'state_type_description',
        title: 'Estado',
        cellRenderer: (row) => row.state_type_description,
        filter: false,
        search: false
    },

    // Usuario
    {
        field: 'user_name',
        title: 'Usuario',
        cellRenderer: (row) => row.user_name,
        hide: true,
    },

    // T.C.
    {
        field: 'exchange_rate_sale',
        title: 'T.C.',
        type: 'number',
        width: '80px',
        hide: true,
    },

        // Moneda
    {
        field: 'currency_type_id',
        title: 'Moneda',
        width: '80px',
        hide: true,
    },

    // Guia
    {
        field: 'guides',
        title: 'Guia',
        cellRenderer: (row) => row.guides,
        filter: false,
        search: false,
        hide: true
    },

            // Placa
    {
        field: 'plate_numbers',
        title: 'Placa',
        cellRenderer: (row) => row.plate_numbers,
        hide: true,
    },

    // T.Exportación
    {
        field: 'total_exportation',
        title: 'T.Exportación',
        type: 'number',
        cellRenderer: (row) => row.total_exportation,
        hide: true,
    },

    // T.Gratuita
    {
        field: 'total_free',
        title: 'T.Gratuita',
        type: 'number',
        cellRenderer: (row) => row.total_free,
        hide: true,
    },

    // T.Inafecta
    {
        field: 'total_unaffected',
        title: 'T.Inafecta',
        type: 'number',
        cellRenderer: (row) => row.total_unaffected,
        hide: true,
    },

    // T.Exonerado
    {
        field: 'total_exonerated',
        title: 'T.Exonerado',
        type: 'number',
        cellRenderer: (row) => row.total_exonerated,
        hide: true,
    },

        // T.Cargos
    {
        field: 'total_charge',
        title: 'T.Cargos',
        type: 'number',
        cellRenderer: (row) => row.total_charge,
        hide: true,
    },

        // T.Gravado
    {
        field: 'total_taxed',
        title: 'T.Gravado',
        type: 'number',
        cellRenderer: (row) => row.total_taxed
    },

    // T.Igv
    {
        field: 'total_igv',
        title: 'T.Igv',
        type: 'number',
        cellRenderer: (row) => row.total_igv
    },

        // Total
    {
        field: 'total',
        title: 'Total',
        type: 'number',
        cellRenderer: (row) => row.total,
        hide: true,
    },

    // Saldo
    {
        field: 'balance',
        title: 'Saldo',
        type: 'number',
        cellRenderer: (row) => row.balance,
        hide: true,
    },

        // Orden de compra
    {
        field: 'purchase_order',
        title: 'Orden de compra',
        width: '95px',
        hide: true,
    },

    // Acciones
    {
        field: 'actions',
        title: 'Acciones',
        cellRenderer: (row) => row.actions || '',
        filter: false,
        search: false,
        sort: false,
        width: '100px'
    }
]);

// Methods
const loadConfiguration = () => {
    if (store && typeof store.loadConfiguration === 'function') {
        store.loadConfiguration()
    }
}

const initForm = () => {
    Object.assign(search, {
        date_of_issue: null,
        document_type_id: null,
        customer_id: null,
        item_id: null,
        category_id: null,
        state_type_id: null,
        series: null,
        number: null,
        d_start: null,
        d_end: null,
        pending_payment: false,
        observations: null,
        establishment_id: null
    })
}

const getQueryParameters = () => {
    const params = new URLSearchParams()

    Object.keys(search).forEach(key => {
        if (search[key] !== null && search[key] !== '' && search[key] !== false) {
            params.append(key, search[key])
        }
    })

    params.append('page', pagination.current_page)
    params.append('per_page', pagination.per_page)

    return params.toString()
}

const getRecords = async () => {
    loading_submit.value = true
    try {
        const queryParams = getQueryParameters()
        console.log('Fetching records with params:', queryParams)
        const response = await $http.get(`/${props.resource}/records?${queryParams}`)
        console.log('Response:', response.data)
        records.value = response.data.data || []
        pagination.total = response.data.meta?.total || 0
        pagination.current_page = response.data.meta?.current_page || 1
        pagination.per_page = parseInt(response.data.meta?.per_page || pagination.per_page)
        console.log('Updated pagination:', pagination)
    } catch (error) {
        console.error('Error al obtener registros:', error)
    } finally {
        loading_submit.value = false
    }
}

const getRecordsByFilter = async () => {
    pagination.current_page = 1
    await getRecords()
}

const resetFilters = () => {
    initForm()
    getRecordsByFilter()
}

const onPageChange = (page) => {
    console.log('Page changed to:', page)
    pagination.current_page = page
    getRecords()
}

const onPageSizeChange = (pageSize) => {
    console.log('Page size changed to:', pageSize)
    pagination.per_page = pageSize
    pagination.current_page = 1
    getRecords()
}

const searchRemoteCustomers = async (input) => {
    if (input.length > 0) {
        loading_search.value = true
        try {
            const response = await $http.get(`/documents/data-table/customers?input=${input}`)
            customers.value = response.data.customers
            if (customers.value.length === 0) {
                filterCustomers()
            }
        } catch (error) {
            console.error('Error al buscar clientes:', error)
        } finally {
            loading_search.value = false
        }
    } else {
        filterCustomers()
    }
}

const filterCustomers = () => {
    customers.value = all_customers.value
}

const searchRemoteItems = async (input) => {
    if (input.length > 0) {
        loading_search_item.value = true
        try {
            const response = await $http.get(`/documents/data-table/items?input=${input}`)
            items.value = response.data
            if (items.value.length === 0) {
                filterItems()
            }
        } catch (error) {
            console.error('Error al buscar items:', error)
        } finally {
            loading_search_item.value = false
        }
    } else {
        filterItems()
    }
}

const filterItems = () => {
    items.value = all_items.value
}

const changeDocumentType = () => {
    filterSeries()
}

const filterSeries = () => {
    search.series = null
    series.value = _.filter(all_series.value, { 'document_type_id': search.document_type_id })
    search.series = (series.value.length > 0) ? series.value[0].number : null
}

const changeDisabledDates = () => {
    // Actualizar pickerOptionsDates cuando cambia d_start
}

const changeEndDate = () => {
    // Lógica adicional si es necesaria
}

const clickSeeMore = () => {
    see_more.value = !see_more.value
}

// Lifecycle
onMounted(async () => {
    loadConfiguration()
    initForm()

    // Escuchar evento de recarga
    if ($eventHub) {
        $eventHub.$on('reloadData', () => {
            getRecords()
        })
    }

    // Cargar opciones iniciales
    try {
        const response = await $http.get(`/${props.resource}/data_table`)
        all_customers.value = response.data.customers || []
        all_items.value = response.data.items || []
        categories.value = response.data.categories || []
        state_types.value = response.data.state_types || []
        document_types.value = response.data.document_types || []
        all_series.value = response.data.series || []
        establishments.value = response.data.establishments || []

        customers.value = all_customers.value
        items.value = all_items.value
    } catch (error) {
        console.error('Error al cargar opciones:', error)
    }

    // Cargar registros
    await getRecords()
})
</script>

<template>
    <div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 py-0 px-3 filter-invoice">
                <div class="d-flex col-12 p-0">
                    <div class="col-lg-9 col-md-8 col-sm-12 mb-2 p-0">
                        <div class="form-group filter-content">
                            <el-button type="default" class="btn-show-filter btn-show-filter-invoice mb-2 ms-2"
                                :class="{ shift: see_more }" @click="clickSeeMore">
                                {{ see_more ? "Ocultar filtros" : "Mostrar filtros" }}
                            </el-button>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-12 text-end">
                        <slot name="showhide"></slot>
                    </div>
                </div>
                <div class="row mt-2 content-filter-invoice" v-if="see_more">
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label class="control-label">Tipo comprobante</label>
                            <el-select v-model="search.document_type_id" @change="changeDocumentType"
                                popper-class="el-select-document_type" filterable clearable>
                                <el-option v-for="option in document_types" :key="option.id" :value="option.id"
                                    :label="option.description"></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label class="control-label">Serie</label>
                            <el-select v-model="search.series" filterable clearable>
                                <el-option v-for="option in series" :key="option.number" :value="option.number"
                                    :label="option.number"></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label class="control-label">Número</label>
                            <el-input placeholder="Ingresar" v-model="search.number"></el-input>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 pb-2">
                        <div class="form-group">
                            <label class="control-label">Fecha inicio</label>
                            <el-date-picker v-model="search.d_start" type="date" style="width: 100%;"
                                placeholder="Buscar" value-format="YYYY-MM-DD"
                                @change="changeDisabledDates"></el-date-picker>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 pb-2">
                        <div class="form-group">
                            <label class="control-label">Fecha término</label>
                            <el-date-picker v-model="search.d_end" type="date" style="width: 100%;" placeholder="Buscar"
                                value-format="YYYY-MM-DD" :disabled-date="pickerOptionsDates.disabledDate"
                                @change="changeEndDate"></el-date-picker>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label class="control-label">Clientes</label>
                            <el-select v-model="search.customer_id" filterable remote popper-class="el-select-customers"
                                clearable placeholder="Nombre o número de documento"
                                :remote-method="searchRemoteCustomers" :loading="loading_search">
                                <el-option v-for="option in customers" :key="option.id" :value="option.id"
                                    :label="option.description"></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4" v-if="resource == 'documents'">
                        <div class="form-group">
                            <label class="control-label">Productos</label>
                            <el-select v-model="search.item_id" filterable remote popper-class="el-select-customers"
                                clearable placeholder="Nombre o código interno" :remote-method="searchRemoteItems"
                                :loading="loading_search_item">
                                <el-option v-for="option in items" :key="option.id" :value="option.id"
                                    :label="option.description"></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label class="control-label">Categorías</label>
                            <el-select v-model="search.category_id" filterable clearable>
                                <el-option v-for="option in categories" :key="option.id" :value="option.id"
                                    :label="option.description"></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label class="control-label">Estado</label>
                            <el-select v-model="search.state_type_id" filterable clearable>
                                <el-option v-for="option in state_types" :key="option.id" :value="option.id"
                                    :label="option.description"></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label class="control-label">Establecimiento</label>
                            <el-select v-model="search.establishment_id" filterable clearable>
                                <el-option v-for="option in establishments" :key="option.id" :value="option.id"
                                    :label="option.description"></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label class="control-label">Pago pendiente</label>
                            <el-checkbox v-model="search.pending_payment"></el-checkbox>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <el-button type="primary" @click="getRecordsByFilter">Buscar</el-button>
                            <el-button type="default" @click="resetFilters">Limpiar</el-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body card-body-invoice">
                    <div class="mb-5 relative">
            <button type="button" class="btn gap-2" @click="isOpen = !isOpen">
                Mostrar/Ocultar Columnas
                <svg
                    viewBox="0 0 24 24"
                    width="20"
                    height="20"
                    stroke="currentColor"
                    stroke-width="2"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="transition"
                    :class="{ 'rotate-180': isOpen }"
                >
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            <ul v-if="isOpen" class="absolute left-0 mt-0.5 p-2.5 min-w-[150px] bg-white rounded shadow-md space-y-1 z-10">
                <li v-for="col in tableColumns" :key="col.field">
                    <label class="flex items-center gap-2 w-full cursor-pointer text-gray-600 hover:text-black">
                        <input type="checkbox" class="form-checkbox" :checked="!col.hide" @change="col.hide = !$event.target.checked" />
                        <span>{{ col.title }}</span>
                    </label>
                </li>
            </ul>
        </div>
            <vue3-datatable :rows="records" :columns="tableColumns" :isServerMode="true" :totalRows="pagination.total"
                v-model:page="pagination.current_page" v-model:pageSize="pagination.per_page" :loading="loading_submit"
                :pageSizeOptions="[10, 20, 30, 50, 100]" @pageChange="onPageChange" @pageSizeChange="onPageSizeChange"
                skin="bh-table-striped bh-table-hover">
                <!-- Pasar slots dinámicamente al componente vue3-datatable -->
                <!--<template v-for="(_, slotName) in $slots" :key="slotName" #[slotName]="slotData">
                    <slot 
                        :name="slotName" 
                        :row="slotData?.row || slotData?.value" 
                        :value="slotData?.value"
                        v-bind="slotData"
                    ></slot>
                </template>-->
                    <template #actions="data">
                        <div class="text-center">
                            <button type="button" style="min-width: 41px"
                                class="btn waves-effect waves-light btn-xs btn-info m-1__2 me-2"
                                @click.prevent="clickDownload(data.value?.download_xml)" v-if="data.value?.has_xml">
                                XML
                            </button>
                            <button type="button" style="min-width: 41px"
                                class="btn waves-effect waves-light btn-xs btn-info m-1__2 me-2"
                                @click.prevent="clickDownload(data.value?.download_pdf)" v-if="data.value?.has_pdf">
                                PDF {{ typeUser }}
                            </button>
                            <button type="button" style="min-width: 41px"
                                class="btn waves-effect waves-light btn-xs btn-info m-1__2 me-2"
                                @click.prevent="clickDownload(data.value?.download_cdr)" v-if="data.value?.has_cdr">
                                CDR 
                            </button>
                        </div>
<div class="text-right" v-if="props.typeUser !== 'integrator'">
    <el-dropdown trigger="click" size="small">
        <el-button class="btn-dropdown">
            <i class="fas fa-ellipsis-v"></i>
            <i class="fas fa-ellipsis-h" style="display: none;"></i>
        </el-button>
        <template #dropdown>
            <el-dropdown-menu>
                <el-dropdown-item 
                    v-if="configuration.permission_to_edit_cpe && data.value.state_type_id === '01' && userPermissionEditCpe && data.value.is_editable">
                    <a :href="`/documents/${data.value.id}/edit`" style="text-decoration: none; color: inherit;">
                        Editar
                    </a>
                </el-dropdown-item>
                <el-dropdown-item 
                    v-else-if="data.value.state_type_id === '01' && userId == data.value.user_id && data.value.is_editable">
                    <a :href="`/documents/${data.value.id}/edit`" style="text-decoration: none; color: inherit;">
                        Editar
                    </a>
                </el-dropdown-item>
                
                <el-dropdown-item v-if="data.value.btn_resend && !isClient" @click="clickResend(data.value.id)">
                    Reenviar
                </el-dropdown-item>
                
                <el-dropdown-item v-if="data.value.btn_recreate_document" @click="clickReStore(data.value.id)">
                    Volver a recrear
                </el-dropdown-item>
                
                <el-dropdown-item v-if="data.value.btn_change_to_registered_status" @click="clickChangeToRegisteredStatus(data.value.id)">
                    Cambiar a estado registrado
                </el-dropdown-item>
                
                <el-dropdown-item v-if="data.value.btn_note">
                    <a :href="`/${resource}/note/${data.value.id}`" style="text-decoration: none; color: inherit;">
                        Nota
                    </a>
                </el-dropdown-item>
                
                <el-dropdown-item v-if="data.value.btn_guide">
                    <a :href="`/dispatches/create_new/document/${data.value.id}`" style="text-decoration: none; color: inherit;">
                        Guía
                    </a>
                </el-dropdown-item>
                
                <el-dropdown-item v-if="data.value.btn_voided" @click="clickVoided(data.value.id)">
                    Anular
                </el-dropdown-item>
                
                <el-dropdown-item v-if="data.value.btn_delete_doc_type_03" @click="clickDeleteDocument(data.value.id)">
                    Eliminar
                </el-dropdown-item>
                
                <el-dropdown-item v-if="isClient && !data.value.send_server" @click="clickSendOnline(data.value.id)">
                    Enviar Servidor
                </el-dropdown-item>
                
                <el-dropdown-item 
                    v-if="isClient && data.value.send_server && (data.value.state_type_id === '01' || data.value.state_type_id === '03')"
                    @click="clickCheckOnline(data.value.id)">
                    Consultar Servidor
                </el-dropdown-item>
                
                <el-dropdown-item v-if="data.value.btn_constancy_detraction" @click="clickCDetraction(data.value.id)">
                    C. Detracción
                </el-dropdown-item>
                
                <el-dropdown-item @click="clickOptions(data.value.id)">
                    Opciones
                </el-dropdown-item>
                
                <el-dropdown-item 
                    v-if="data.value.btn_force_send_by_summary && props.typeUser === 'admin'"
                    @click="clickForceSendBySummary(data.value.id)">
                    Enviar por resumen
                </el-dropdown-item>
                
                <el-dropdown-item divided @click="clickPayment(data.value.id)">
                    Pagos
                </el-dropdown-item>
                
                <el-dropdown-item v-if="data.value.btn_retention" divided @click="clickRetention(data.value.id)">
                    Retención
                </el-dropdown-item>
            </el-dropdown-menu>
        </template>
    </el-dropdown>
</div>
                    </template>
            </vue3-datatable>
        </div>
    </div>
</template>


<style scoped>
.filter-invoice {
    margin-bottom: 1rem;
}

.content-filter-invoice {
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 4px;
}

.btn-show-filter.shift {
    display: block !important;
}
</style>
