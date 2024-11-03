<template>
    <em v-if="loading" class="pi pi-spin pi-spinner"></em>
    <Tag v-else severity="Secondary" :value="version"></Tag>
</template>
<script setup>
import axios from 'axios';
import Tag from 'primevue/tag';
import { useToast } from 'primevue/usetoast';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';

const props = defineProps({
    function: {
        type: String,
        required: true
    },
    update: {
        type: Boolean,
        default: false
    },
})

const route = useRoute()
const toast = useToast()

const version = ref(null)
const loading = ref(true)

const loadVersion = async () => {
    try {
        loading.value = true;
        const response = await axios.get(`/api/projects/${route.params.id}/aliasVersion`, {
            params: {
                function: props.function
            }
        });
        version.value = response.data
    } catch (error) {
        toast.add({ severity: 'error', summary: 'Error', detail: error.response?.data.message ?? error.message, life: 5000 });
    } finally {
        loading.value = false;
    }
}

onMounted(() => {
    loadVersion()
})

defineExpose({
    loadVersion
})

</script>
