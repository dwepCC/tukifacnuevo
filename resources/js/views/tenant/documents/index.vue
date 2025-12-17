<script setup>
import { ref, reactive, computed, onMounted, getCurrentInstance } from 'vue'
import { ElMessage, ElMessageBox } from 'element-plus'
import axios from 'axios'
import moment from 'moment'
import DocumentsVoided from "./partials/voided.vue"
import DocumentOptions from "./partials/options.vue"
import DocumentPayments from "./partials/payments.vue"
import DocumentImportSecond from "./partials/import_second.vue"
import DocumentImportExcel from "./partials/ImportExcel.vue"
import DataTable from "../../../components/DataTableDocumentsV3.vue"
import ItemsImport from "./import.vue"
import DocumentConstancyDetraction from "./partials/constancy_detraction.vue"
import ReportPayment from "./partials/report_payment.vue"
import ReportPaymentComplete from "./partials/report_payment_complete.vue"
import DocumentValidate from "./partials/validate.vue"
import MassiveValidateCpe from "../../../../../modules/ApiPeruDev/Resources/assets/js/components/MassiveValidateCPE.vue"
import DocumentRetention from "./partials/retention.vue"
import { useMainStore } from "@/stores/main"

// Props
const props = defineProps({
    isClient: Boolean,
    typeUser: String,
    import_documents: Boolean,
    import_documents_second: Boolean,
    document_import_excel: Boolean,
    userId: Number,
    configuration: Object,
    userPermissionEditCpe: Boolean,
    view_apiperudev_validator_cpe: Boolean,
    view_validator_cpe: Boolean
})

// Store
const store = useMainStore()

// Instance para acceder a globalProperties
const instance = getCurrentInstance()
const $http = instance?.appContext.config.globalProperties.$http || axios
const $eventHub = instance?.appContext.config.globalProperties.$eventHub

// State
const showDialogApiPeruDevValidate = ref(false)
const showDialogValidate = ref(false)
const showDialogReportPayment = ref(false)
const showDialogReportPaymentComplete = ref(false)
const showDialogVoided = ref(false)
const showImportDialog = ref(false)
const showDialogCDetraction = ref(false)
const showImportSecondDialog = ref(false)
const showImportExcelDialog = ref(false)
const showDialogRetention = ref(false)
const resource = ref("documents")
const recordId = ref(null)
const showDialogOptions = ref(false)
const showDialogPayments = ref(false)

const columns = reactive({
    notes: {
        title: "Notas C/D",
        visible: false
    },
    dispatch: {
        title: "Guía de Remisión",
        visible: false
    },
    plate_numbers: {
        title: "Placa",
        visible: false
    },
    user_name: {
        title: "Usuario",
        visible: false
    },
    exchange_rate_sale: {
        title: "Tipo de cambio",
        visible: false
    },
    total_exportation: {
        title: "T.Exportación",
        visible: false
    },
    total_free: {
        title: "T.Gratuito",
        visible: false
    },
    total_unaffected: {
        title: "T.Inafecto",
        visible: false
    },
    total_exonerated: {
        title: "T.Exonerado",
        visible: false
    },
    date_of_due: {
        title: "F. Vencimiento",
        visible: false
    },
    guides: {
        title: "Guias",
        visible: false
    },
    sales_note: {
        title: "Nota de ventas",
        visible: false
    },
    order_note: {
        title: "Pedidos",
        visible: false
    },
    send_it: {
        title: "Correo enviado al destinatario",
        visible: false
    },
    total: {
        title: "Total",
        visible: false
    },
    currency_type_id: {
        title: "Moneda",
        visible: false
    },
    purchase_order: {
        title: "Orden de Compra",
        visible: false
    },
    soap_type: {
        title: "Soap",
        visible: false
    },
    balance: {
        title: "Saldo",
        visible: true
    },
    total_charge: {
        title: "T.Cargos",
        visible: false
    },
    date_payment: {
        title: "Fecha de pago",
        visible: false
    }
})

// Computed
const config = computed(() => store.config)

// Methods
const formatDate = (date) => {
    if (!date) return null
    return moment(date).format("DD-MM-YYYY")
}

const loadConfiguration = () => {
    store.loadConfiguration()
}

const getColumnsToShow = (updated) => {
    $http
        .post("/validate_columns", {
            columns: columns,
            report: "document_index",
            updated: updated !== undefined
        })
        .then(response => {
            if (updated === undefined) {
                let currentCols = response.data.columns
                if (currentCols !== undefined) {
                    Object.assign(columns, currentCols)
                }
            }
        })
        .catch(error => {
            console.error(error)
        })
}

const clickVoided = (recordIdParam = null) => {
    recordId.value = recordIdParam
    showDialogVoided.value = true
}

const clickDownload = (download) => {
    window.open(download, "_blank")
}

const clickResend = (document_id) => {
    $http
        .get(`/${resource.value}/send/${document_id}`)
        .then(response => {
            if (response.data.success) {
                ElMessage.success(response.data.message)
                $eventHub?.$emit("reloadData")
            } else {
                ElMessage.error(response.data.message)
            }
        })
        .catch(error => {
            ElMessage.error(error.response?.data?.message || 'Error al reenviar')
        })
}

const clickSendOnline = (document_id) => {
    $http
        .get(`/${resource.value}/send_server/${document_id}/1`)
        .then(response => {
            if (response.data.success) {
                ElMessage.success("Se envio satisfactoriamente el comprobante.")
                $eventHub?.$emit("reloadData")
                clickCheckOnline(document_id)
            } else {
                ElMessage.error(response.data.message)
            }
        })
        .catch(error => {
            ElMessage.error(error.response?.data?.message || 'Error al enviar')
        })
}

const clickCheckOnline = (document_id) => {
    $http
        .get(`/${resource.value}/check_server/${document_id}`)
        .then(response => {
            if (response.data.success) {
                ElMessage.success("Consulta satisfactoria.")
                $eventHub?.$emit("reloadData")
            } else {
                ElMessage.error(response.data.message)
            }
        })
        .catch(error => {
            ElMessage.error(error.response?.data?.message || 'Error al consultar')
        })
}

const clickCDetraction = (recordIdParam) => {
    recordId.value = recordIdParam
    showDialogCDetraction.value = true
}

const clickOptions = (recordIdParam = null) => {
    recordId.value = recordIdParam
    showDialogOptions.value = true
}

const clickReStore = (document_id) => {
    $http
        .get(`/${resource.value}/re_store/${document_id}`)
        .then(response => {
            if (response.data.success) {
                ElMessage.success(response.data.message)
                $eventHub?.$emit("reloadData")
            } else {
                ElMessage.error(response.data.message)
            }
        })
        .catch(error => {
            ElMessage.error(error.response?.data?.message || 'Error al recrear')
        })
}

const tooltip = (row, message = true) => {
    if (message) {
        if (row.shipping_status) return row.shipping_status.message
        if (row.sunat_shipping_status) return row.sunat_shipping_status.message
        if (row.query_status) return row.query_status.message
    }

    if (row.shipping_status || row.sunat_shipping_status || row.query_status) {
        return true
    }

    return false
}

const clickPayment = (recordIdParam) => {
    recordId.value = recordIdParam
    showDialogPayments.value = true
}

const clickChangeToRegisteredStatus = (document_id) => {
    $http
        .get(`/${resource.value}/change_to_registered_status/${document_id}`)
        .then(response => {
            if (response.data.success) {
                ElMessage.success(response.data.message)
                $eventHub?.$emit("reloadData")
            } else {
                ElMessage.error(response.data.message)
            }
        })
        .catch(error => {
            ElMessage.error(error.response?.data?.message || 'Error al cambiar estado')
        })
}

const clickImport = () => {
    showImportDialog.value = true
}

const clickDownloadReportPagos = () => {
    showDialogReportPaymentComplete.value = true
}

const clickImportSecond = () => {
    showImportSecondDialog.value = true
}

const clickImportExcel = () => {
    showImportExcelDialog.value = true
}

const destroy = (url) => {
    return new Promise((resolve) => {
        ElMessageBox.confirm('¿Desea eliminar el registro?', 'Eliminar', {
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            type: 'warning'
        }).then(() => {
            $http.delete(url)
                .then(res => {
                    if (res.data.success) {
                        ElMessage.success(res.data.message)
                        resolve()
                    } else {
                        ElMessage.error(res.data.message)
                        resolve()
                    }
                })
                .catch(error => {
                    if (error.response?.status === 500) {
                        ElMessage.error('Error al intentar eliminar')
                    } else {
                        console.log(error.response?.data?.message)
                    }
                })
        }).catch(() => {
            // Usuario canceló
        })
    })
}

const clickDeleteDocument = (document_id) => {
    destroy(`/${resource.value}/delete_document/${document_id}`).then(() => {
        $eventHub?.$emit("reloadData")
    })
}

const clickReportPayments = () => {
    showDialogReportPayment.value = true
}

const forceSendBySummary = (url, params) => {
    return new Promise((resolve) => {
        ElMessageBox.confirm('Debe validar que la boleta no se encuentre en Sunat, ya que si la envió de forma individual al menos una vez, puede que ya se encuentre registrada.', '¿Desea enviar la boleta por resumen?', {
            confirmButtonText: 'Modificar',
            cancelButtonText: 'Cancelar',
            type: 'warning'
        }).then(() => {
            $http.post(url, params)
                .then(res => {
                    if (res.data.success) {
                        ElMessage.success(res.data.message)
                        resolve()
                    } else {
                        ElMessage.error(res.data.message)
                    }
                })
                .catch(error => {
                    if (error.response?.status === 500) {
                        ElMessage.error('Error desconocido')
                    } else {
                        console.log(error.response?.data?.message)
                    }
                })
        }).catch(() => {
            // Usuario canceló
        })
    })
}

const clickForceSendBySummary = (id) => {
    forceSendBySummary(`/${resource.value}/force-send-by-summary`, {
        id: id
    }).then(() => {
        $eventHub?.$emit("reloadData")
    })
}

const clickRetention = (recordIdParam) => {
    recordId.value = recordIdParam
    showDialogRetention.value = true
}

const isDateWarning = (date_due) => {
    let today = Date.now()
    return moment(date_due).isBefore(today)
}

const go = (url) => {
    window.location.href = url
}

// Lifecycle
onMounted(() => {
    store.setConfiguration(props.configuration)
    loadConfiguration()
    getColumnsToShow()
})
</script>
<template>
    <div class="documents">
        <div class="page-header pr-0">
            <h2>
                <a href="/documents">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        style="margin-top: -5px;" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-file-text">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                </a>
            </h2>
            <ol class="breadcrumbs">
                <li class="active"><span>Listado de comprobantes</span></li>
                <!-- <li><span class="text-muted">Facturas - Notas <small>(crédito y débito)</small> - Boletas - Anulaciones</span></li> -->
            </ol>
            <div class="right-wrapper pull-right" v-if="typeUser != 'integrator'">
                <span v-if="import_documents == true">
                    <button type="button" class="btn btn-custom btn-sm  mt-2 me-2" @click.prevent="clickImport()">
                        <i class="fa fa-upload"></i> Importar Formato 1
                    </button>
                </span>
                <span v-if="import_documents_second == true">
                    <button type="button" class="btn btn-custom btn-sm  mt-2 me-2" @click.prevent="clickImportSecond()">
                        <i class="fa fa-upload"></i> Importar Formato 2
                    </button>
                </span>
                <span v-if="document_import_excel">
                    <button type="button" class="btn btn-custom btn-sm  mt-2 me-2" @click.prevent="clickImportExcel">
                        <i class="fa fa-upload"></i> Importar Formato
                    </button>
                </span>
                <a :href="`/${resource}/create`" class="btn btn-custom btn-sm  mt-2 me-2"><i
                        class="fa fa-plus-circle"></i> Nuevo</a>
                <div class="btn-group flex-wrap dropdown">
                    <button type="button" class="btn btn-custom btn-sm  mt-2 me-2 dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-money-bill-wave-alt"></i> Reporte de
                        Pagos <span class="caret"></span>
                    </button>
                    <!-- validadores apiperu  -->
                    <a href="#" @click.prevent="showDialogApiPeruDevValidate = true"
                        v-if="view_apiperudev_validator_cpe" class="btn btn-custom btn-sm  mt-2 me-2"><i
                            class="fa fa-check"></i> Validación masiva</a>
                    <a href="#" @click.prevent="showDialogValidate = true" v-if="view_validator_cpe"
                        class="btn btn-custom btn-sm  mt-2 me-2"><i class="fa fa-file"></i> Validar CPE</a>

                    <div class="dropdown-menu" role="menu" x-placement="bottom-start"
                        style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 42px, 0px);">
                        <a class="dropdown-item text-1" href="#" @click.prevent="clickReportPayments()">Generar
                            Reporte</a>
                        <a class="dropdown-item text-1" href="#" @click.prevent="clickDownloadReportPagos()">Descargar
                            Excel</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card tab-content-default row-new mb-0">
            <!--
            <div class="data-table-visible-columns">

                <el-dropdown :hide-on-click="false">
                    <el-button type="primary">
                        Mostrar/Ocultar columnas<i class="el-icon-arrow-down el-icon--right"></i>
                    </el-button>
                    <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item v-for="(column, index) in columns"
                                          :key="index">
                            <el-checkbox v-model="column.visible">{{ column.title }}</el-checkbox>
                        </el-dropdown-item>
                    </el-dropdown-menu>
                </el-dropdown>
            </div>
            -->
            <div class="card-body card-body-invoice">
                <!--<div class="data-table-visible-columns">
                    <el-dropdown :hide-on-click="false">
                        <el-button type="default">
                            Mostrar/Ocultar columnas<i class="el-icon-arrow-down el-icon--right"></i>
                        </el-button>
                        <template #dropdown>
                            <el-dropdown-menu>
                                <el-dropdown-item v-for="(column, index) in columns" :key="index">
                                    <el-checkbox @change="getColumnsToShow(1)" v-model="column.visible">{{ column.title
                                        }}
                                    </el-checkbox>
                                </el-dropdown-item>
                            </el-dropdown-menu>
                        </template>
                    </el-dropdown>
                </div>-->
                <data-table :resource="resource" :columns="columns" :configuration="configuration" :is-client="isClient" :user-id="userId">
                    <!-- Slots para renderizado personalizado de celdas -->
                    <!--<template #date_of_payment="data">
                        <span class="text-center">{{ formatDate(data.row?.date_of_payment || data.value) }}</span>
                    </template>

                    <template #date_of_due="data">
                        <span class="text-center" :class="{
                            'text-danger': data.row?.balance > 0 && isDateWarning(data.row?.date_of_due)
                        }">
                            {{ data.row?.date_of_due || data.value }}
                        </span>
                    </template>

                    <template #customer_name="data">
                        <div>
                            {{ data.row?.customer_name || data.value }}<br />
                            <small>{{ data.row?.customer_number }}</small>
                        </div>
                    </template>

                    <template #number="data">
                        <div>
                            {{ data.row?.number || data.value }}<br />
                            <small>{{ data.row?.document_type_description }}</small><br />
                            <small v-if="data.row?.affected_document">{{ data.row?.affected_document }}</small>
                        </div>
                    </template>

                    <template #notes="data">
                        <template v-for="(note, index) in (data.row?.notes || [])" :key="index">
                            <label class="d-block">
                                {{ note.note_type_description }}: {{ note.description }}
                            </label>
                        </template>
                    </template>

                    <template #dispatches="data">
                        <template v-for="(dispatch, index) in (data.row?.dispatches || [])" :key="index">
                            <label class="d-block">{{ dispatch.description }}</label>
                        </template>
                    </template>

                    <template #sales_note="data">
                        <template v-for="(note, index) in (data.row?.sales_note || [])" :key="index">
                            <label class="d-block">
                                {{ note.number_full }} ({{ note.state_type_description }})
                            </label>
                        </template>
                    </template>

                    <template #order_note="data">
                        <template v-if="data.row?.order_note && data.row?.order_note.identifier">
                            {{ data.row.order_note.identifier }}
                        </template>
                    </template>

                    <template #email_send_it="data">
                        <span class="badge" :class="{
                            'text-muted': data.row?.email_send_it === false,
                            'text-success': data.row?.email_send_it === true
                        }">
                            <i class="fas fa-lg" :class="{
                                'fa-minus': data.row?.email_send_it === false,
                                'fa-check': data.row?.email_send_it === true
                            }"></i>
                        </span>
                    </template>

                    <template #state_type_description="data">
                        <div>
                            <el-tooltip v-if="tooltip(data.row, false)" class="item" effect="dark" placement="bottom">
                                <template #content>{{ tooltip(data.row) }}</template>
                                <span class="badge bg-secondary text-white" :class="{
                                    'bg-danger': data.row?.state_type_id === '11',
                                    'bg-warning': data.row?.state_type_id === '13',
                                    'bg-secondary': data.row?.state_type_id === '01',
                                    'bg-info': data.row?.state_type_id === '03',
                                    'bg-success': data.row?.state_type_id === '05',
                                    'bg-secondary': data.row?.state_type_id === '07',
                                    'bg-dark': data.row?.state_type_id === '09'
                                }">
                                    {{ data.row?.state_type_description || data.value }}
                                </span>
                            </el-tooltip>
                            <span v-else class="badge bg-secondary text-white" :class="{
                                'bg-danger': data.row?.state_type_id === '11',
                                'bg-warning': data.row?.state_type_id === '13',
                                'bg-secondary': data.row?.state_type_id === '01',
                                'bg-info': data.row?.state_type_id === '03',
                                'bg-success': data.row?.state_type_id === '05',
                                'bg-secondary': data.row?.state_type_id === '07',
                                'bg-dark': data.row?.state_type_id === '09'
                            }">
                                {{ data.row?.state_type_description || data.value }}
                            </span>
                            <a v-if="data.row?.state_type_id === '13'" href="voided" class="small">
                                <br />Ir a anulaciones
                            </a>
                            <template v-if="data.row?.regularize_shipping && data.row?.state_type_id === '01'">
                                <el-tooltip class="item" effect="dark" :content="data.row?.message_regularize_shipping"
                                    placement="top-start">
                                    <i class="fas fa-exclamation-triangle fa-lg" style="color: #D2322D !important"></i>
                                </el-tooltip>
                            </template>
                        </div>
                    </template>

                    <template #user_name="data">
                        <div>
                            {{ data.row?.user_name || data.value }}<br />
                            <small>{{ data.row?.user_email }}</small>
                        </div>
                    </template>

                    <template #guides="data">
                        <div class="text-center">
                            <span v-for="(item, i) in (data.row?.guides || [])" :key="i">
                                {{ item.number }}<br />
                            </span>
                        </div>
                    </template>

                    <template #plate_numbers="data">
                        <div class="text-center">
                            <span v-for="(item, i) in (data.row?.plate_numbers || [])" :key="i">
                                {{ item.description }}<br />
                            </span>
                        </div>
                    </template>

                    <template #total_exportation="data">
                        <span class="text-right">
                            {{ data.row?.currency_type_id === 'PEN' ? 'S/' : '$' }}
                            {{ data.row?.total_exportation || data.value }}
                        </span>
                    </template>

                    <template #total_free="data">
                        <span class="text-right">
                            {{ data.row?.currency_type_id === 'PEN' ? 'S/' : '$' }}
                            {{ data.row?.total_free || data.value }}
                        </span>
                    </template>

                    <template #total_unaffected="data">
                        <span class="text-right">
                            {{ data.row?.currency_type_id === 'PEN' ? 'S/' : '$' }}
                            {{ data.row?.total_unaffected || data.value }}
                        </span>
                    </template>

                    <template #total_exonerated="data">
                        <span class="text-right">
                            {{ data.row?.currency_type_id === 'PEN' ? 'S/' : '$' }}
                            {{ data.row?.total_exonerated || data.value }}
                        </span>
                    </template>

                    <template #total_charge="data">
                        <span class="text-right">
                            {{ data.row?.currency_type_id === 'PEN' ? 'S/' : '$' }}
                            {{ data.row?.total_charge || data.value }}
                        </span>
                    </template>

                    <template #total_taxed="data">
                        <span class="text-right">
                            {{ data.row?.currency_type_id === 'PEN' ? 'S/' : '$' }}
                            {{ data.row?.total_taxed || data.value }}
                        </span>
                    </template>

                    <template #total_igv="data">
                        <span class="text-right">
                            {{ data.row?.currency_type_id === 'PEN' ? 'S/' : '$' }}
                            {{ data.row?.total_igv || data.value }}
                        </span>
                    </template>

                    <template #total="data">
                        <span class="text-right">
                            {{ data.row?.currency_type_id === 'PEN' ? 'S/' : '$' }}
                            {{ data.row?.total || data.value }}
                        </span>
                    </template>

                    <template #balance="data">
                        <span class="text-right" :class="{
                            'text-warning': data.row?.balance > 0,
                            'text-success': data.row?.balance == 0
                        }">
                            {{ data.row?.currency_type_id === 'PEN' ? 'S/' : '$' }}
                            {{ data.row?.balance || data.value }}
                        </span>
                    </template>

                    <template #actions="data">
                        <div class="text-center">
                            <button type="button" style="min-width: 41px"
                                class="btn waves-effect waves-light btn-xs btn-info m-1__2 me-2"
                                @click.prevent="clickDownload(data.row?.download_xml)" v-if="data.row?.has_xml">
                                XML
                            </button>
                            <button type="button" style="min-width: 41px"
                                class="btn waves-effect waves-light btn-xs btn-info m-1__2 me-2"
                                @click.prevent="clickDownload(data.row?.download_pdf)" v-if="data.row?.has_pdf">
                                PDF
                            </button>
                            <button type="button" style="min-width: 41px"
                                class="btn waves-effect waves-light btn-xs btn-info m-1__2 me-2"
                                @click.prevent="clickDownload(data.row?.download_cdr)" v-if="data.row?.has_cdr">
                                CDR
                            </button>
                        </div>
                        <div class="text-right" v-if="typeUser != 'integrator'">
                            <el-dropdown trigger="click" size="small">
                                <el-button class="btn-dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                    <i class="fas fa-ellipsis-h" style="display: none;"></i>
                                </el-button>
                                <template #dropdown>
                                    <el-dropdown-menu>
                                        <el-dropdown-item
                                            v-if="configuration.permission_to_edit_cpe && data.row?.state_type_id === '01' && userPermissionEditCpe && data.row?.is_editable">
                                            <a :href="`/documents/${data.row?.id}/edit`"
                                                style="text-decoration: none; color: inherit;">
                                                Editar
                                            </a>
                                        </el-dropdown-item>
                                        <el-dropdown-item
                                            v-else-if="data.row?.state_type_id === '01' && userId == data.row?.user_id && data.row?.is_editable">
                                            <a :href="`/documents/${data.row?.id}/edit`"
                                                style="text-decoration: none; color: inherit;">
                                                Editar
                                            </a>
                                        </el-dropdown-item>
                                        <el-dropdown-item v-if="data.row?.btn_resend && !isClient"
                                            @click="clickResend(data.row?.id)">
                                            Reenviar
                                        </el-dropdown-item>
                                        <el-dropdown-item v-if="data.row?.btn_recreate_document"
                                            @click="clickReStore(data.row?.id)">
                                            Volver a recrear
                                        </el-dropdown-item>
                                        <el-dropdown-item v-if="data.row?.btn_change_to_registered_status"
                                            @click="clickChangeToRegisteredStatus(data.row?.id)">
                                            Cambiar a estado registrado
                                        </el-dropdown-item>
                                        <el-dropdown-item v-if="data.row?.btn_note">
                                            <a :href="`/${resource.value}/note/${data.row?.id}`"
                                                style="text-decoration: none; color: inherit;">
                                                Nota
                                            </a>
                                        </el-dropdown-item>
                                        <el-dropdown-item v-if="data.row?.btn_guide">
                                            <a :href="`/dispatches/create_new/document/${data.row?.id}`"
                                                style="text-decoration: none; color: inherit;">
                                                Guía
                                            </a>
                                        </el-dropdown-item>
                                        <el-dropdown-item v-if="data.row?.btn_voided"
                                            @click="clickVoided(data.row?.id)">
                                            Anular
                                        </el-dropdown-item>
                                        <el-dropdown-item v-if="data.row?.btn_delete_doc_type_03"
                                            @click="clickDeleteDocument(data.row?.id)">
                                            Eliminar
                                        </el-dropdown-item>
                                        <el-dropdown-item v-if="isClient && !data.row?.send_server"
                                            @click="clickSendOnline(data.row?.id)">
                                            Enviar Servidor
                                        </el-dropdown-item>
                                        <el-dropdown-item
                                            v-if="isClient && data.row?.send_server && (data.row?.state_type_id === '01' || data.row?.state_type_id === '03')"
                                            @click="clickCheckOnline(data.row?.id)">
                                            Consultar Servidor
                                        </el-dropdown-item>
                                        <el-dropdown-item v-if="data.row?.btn_constancy_detraction"
                                            @click="clickCDetraction(data.row?.id)">
                                            C. Detracción
                                        </el-dropdown-item>
                                        <el-dropdown-item @click="clickOptions(data.row?.id)">
                                            Opciones
                                        </el-dropdown-item>
                                        <el-dropdown-item
                                            v-if="data.row?.btn_force_send_by_summary && typeUser === 'admin'"
                                            @click="clickForceSendBySummary(data.row?.id)">
                                            Enviar por resumen
                                        </el-dropdown-item>
                                        <el-dropdown-item divided @click="clickPayment(data.row?.id)">
                                            Pagos
                                        </el-dropdown-item>
                                        <el-dropdown-item v-if="data.row?.btn_retention" divided
                                            @click="clickRetention(data.row?.id)">
                                            Retención
                                        </el-dropdown-item>
                                    </el-dropdown-menu>
                                </template>
                            </el-dropdown>
                        </div>
                    </template>-->
                </data-table>
            </div>

            <documents-voided v-model:showDialog="showDialogVoided" :recordId="recordId"></documents-voided>

            <items-import v-model:showDialog="showImportDialog"></items-import>

            <document-import-second v-model:showDialog="showImportSecondDialog"></document-import-second>

            <document-options v-model:showDialog="showDialogOptions" :recordId="recordId" :showClose="true"
                :configuration="configuration"></document-options>

            <document-payments v-model:showDialog="showDialogPayments" :documentId="recordId"></document-payments>

            <document-constancy-detraction v-model:showDialog="showDialogCDetraction"
                :recordId="recordId"></document-constancy-detraction>
            <report-payment v-model:showDialog="showDialogReportPayment"></report-payment>

            <report-payment-complete v-model:showDialog="showDialogReportPaymentComplete"></report-payment-complete>

            <DocumentValidate v-model:showDialogValidate="showDialogValidate"></DocumentValidate>

            <massive-validate-cpe v-model:showDialogValidate="showDialogApiPeruDevValidate"></massive-validate-cpe>

            <document-import-excel v-model:showDialog="showImportExcelDialog"></document-import-excel>

            <document-retention v-model:showDialog="showDialogRetention" :documentId="recordId"></document-retention>
        </div>
    </div>
</template>
<style>
.dropdown-menu.show {
    display: block;
    max-height: 140px;
    overflow-y: auto;
}
</style>
