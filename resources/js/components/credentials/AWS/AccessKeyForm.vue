<template>
    <div class="mt-6 space-y-6">
        <Toast />
        <div>
            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Key ID</label>
            <InputText type="text" v-model="accessKeyId" />
        </div>
        <div>
            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" >Key Secret</label>
            <Password v-model="accessKeySecret" />
        </div>
        <div>
            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" >Region</label>
            <AutoComplete v-model="region" dropdown :suggestions="localRegions" placeholder="Select a Region" @complete="search" />
        </div>
        <Button label="Submit" :loading="loading" @click="createAccessKeys()" />
    </div>
</template>
<script setup>
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import InputText from "primevue/inputtext";
import Password from "primevue/password";
import Button from "primevue/button";
import Toast from "primevue/toast";
import AutoComplete from "primevue/autocomplete";
import axios from 'axios';

const props = defineProps({
    regions: {
        type: Array,
        required: true,
    }
})

const toast = useToast();
const accessKeyId = ref("");
const accessKeySecret = ref("");
const region = ref("");
const loading = ref(false);

const localRegions = ref(props.regions);

const createAccessKeys = async () => {
    try {
        loading.value = true
        await axios.post('/api/credentials', {
            access_key_id: accessKeyId.value,
            access_key_secret: accessKeySecret.value,
            region: region.value,
        })
        window.location.reload();
    } catch (error) {
        console.log(error);
        toast.add({ severity: 'error', summary: 'Error', detail: error.message, life: 3000 });
    } finally {
        loading.value = false
    }
}

const search = (event) => {
    localRegions.value = props.regions.filter((r) => r.includes(event.query));
}
</script>
