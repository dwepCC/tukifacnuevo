<template>
    <div ref="editorContainer"></div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    config: {
        type: Object,
        default: () => ({})
    }
})

const emit = defineEmits(['update:modelValue'])

const editorContainer = ref(null)
let editorInstance = null

onMounted(async () => {
    if (editorContainer.value) {
        try {
            editorInstance = await ClassicEditor.create(editorContainer.value, {
                ...props.config,
                initialData: props.modelValue || ''
            })

            editorInstance.model.document.on('change:data', () => {
                const data = editorInstance.getData()
                emit('update:modelValue', data)
            })
        } catch (error) {
            console.error('Error al inicializar CKEditor:', error)
        }
    }
})

onBeforeUnmount(() => {
    if (editorInstance) {
        editorInstance.destroy()
            .then(() => {
                editorInstance = null
            })
            .catch(error => {
                console.error('Error al destruir CKEditor:', error)
            })
    }
})

watch(() => props.modelValue, (newValue) => {
    if (editorInstance && editorInstance.getData() !== newValue) {
        editorInstance.setData(newValue || '')
    }
})
</script>

