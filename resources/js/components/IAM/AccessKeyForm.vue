<template>
    <div class="mt-6 space-y-6">
        <div>
            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Key ID</label>
            <InputText type="text" v-model="accessKeyId" />
        </div>
        <div>
            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" >Key Secret</label>
            <Password v-model="accessKeySecret" />
        </div>
        <Button label="Submit" @click="createAccessKeys()" />
    </div>
</template>
<script setup>
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import InputText from "primevue/inputtext";
import Password from "primevue/password";
import Button from "primevue/button";
import axios from 'axios';

const toast = useToast();
const accessKeyId = ref("");
const accessKeySecret = ref("");

const createAccessKeys = async () => {
    try {
        const response = await axios.post('/api/aws-credential', {
            access_key_id: accessKeyId.value,
            access_key_secret: accessKeySecret.value,
        })
        window.location.reload()
    } catch (error) {
        console.log(error);
        toast.add({ severity: 'error', summary: 'Error', detail: error.message, life: 3000 });
    }
}
</script>
