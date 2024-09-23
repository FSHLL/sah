<template>
    <h4>{{ version }}</h4>
</template>
<script setup>
import axios from 'axios';
import { onMounted, ref, watch } from 'vue';
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
        console.log(error);
    } finally {
        loading.value = false;
    }
}

watch(() => props.update, () => {
    loadVersion();
});

onMounted(() => {
    loadVersion()
})

</script>
