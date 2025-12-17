<template>
    <div class="card">
        <div class="card-header bg-info bg-info-customer-admin">
            <h3 class="my-0">Configuración de Soporte</h3>
        </div>
        <div class="card-body">
            <form autocomplete="off" @submit.prevent="submit">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" :class="{'has-danger': errors.phone}">
                                <label class="control-label">Teléfono</label>
                                <el-input v-model="form.phone"></el-input>
                                <small class="form-control-feedback text-muted">Agregar código de país, ejemplo; 51955955955</small>
                                <small class="form-control-feedback" v-if="errors.phone" v-text="errors.phone[0]"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" :class="{'has-danger': errors.whatsapp_number}">
                                <label class="control-label">Número de WhatsApp</label>
                                <el-input v-model="form.whatsapp_number"></el-input>
                                <small class="form-control-feedback text-muted">Agregar código de país, ejemplo; 51955955955</small>
                                <small class="form-control-feedback" v-if="errors.whatsapp_number" v-text="errors.whatsapp_number[0]"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" :class="{'has-danger': errors.address_contact}">
                                <label class="control-label">Correo Electrónico</label>
                                <el-input v-model="form.address_contact" type="email"></el-input>
                                <small class="form-control-feedback text-muted">Ejemplo: soporte@miempresa.com</small>
                                <small class="form-control-feedback" v-if="errors.address_contact" v-text="errors.address_contact[0]"></small>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label>Mostrar botón flotante de WhatsApp</label>
                            <div :class="{'has-danger': errors.enable_whatsapp}">
                                <el-switch
                                    v-model="form.enable_whatsapp"
                                    active-text="Si"
                                    inactive-text="No">
                                </el-switch>
                                <small class="form-control-feedback" v-if="errors.enable_whatsapp" v-text="errors.enable_whatsapp[0]"></small>
                                <br>
                                <small class="form-control-feedback">Se mostrará el botón de Whatsapp en la parte inferior derecha en el sistema del cliente.</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group" :class="{'has-danger': errors.introduction}">
                                <label class="control-label d-block">Mensaje de introducción</label>
                                <CKEditor
                                    v-model="form.introduction"
                                    :config="editorConfig"
                                />
                                <small class="form-control-feedback">Agrega detalles sobre el soporte. Puede indicar algún mensaje corto sobre como es la atención o el  horario o forma de comunicarse con soporte.</small>
                                <small class="form-control-feedback" v-if="errors.introduction" v-text="errors.introduction[0]"></small>                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions text-end pt-2">
                    <el-button type="primary" native-type="submit" :loading="loading_submit">Guardar</el-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import CKEditor from '@/components/CKEditor.vue'
import axios from 'axios'
import { useMessage } from '@/helpers/compat'

const $message = useMessage()

const loading_submit = ref(false)
const resource = 'users'
const errors = ref({})
const editorConfig = {
    toolbar: [
        'heading',
        '|',
        'bold', 'italic', 'link',
        'bulletedList', 'numberedList',
        '|',
        'blockQuote',
        'undo', 'redo'
    ]
}
const form = ref({
    phone: null,
    whatsapp_number: null,
    address_contact: null,
    enable_whatsapp: true,
    introduction: ''
})

const initForm = () => {
    errors.value = {}
    form.value = {
        phone: null,
        whatsapp_number: null,
        address_contact: null,
        enable_whatsapp: true,
        introduction: ''
    }
}

const submit = () => {
    loading_submit.value = true
    axios.post(`/${resource}`, form.value)
        .then(response => {
            if (response.data.success) {
                $message.success(response.data.message)
            } else {
                $message.error(response.data.message)
            }
        })
        .catch(error => {
            if (error.response?.status === 422) {
                errors.value = error.response.data
            } else {
                console.log(error)
            }
        })
        .finally(() => {
            loading_submit.value = false
        })
}

onMounted(() => {
    initForm()
    axios.get(`/${resource}/record`)
        .then(response => {
            if (response.data !== '') {
                form.value = Object.assign({
                    phone: null,
                    whatsapp_number: null,
                    address_contact: null,
                    enable_whatsapp: true,
                    introduction: ''
                }, response.data.data || {})
            }
        })
})
</script>
