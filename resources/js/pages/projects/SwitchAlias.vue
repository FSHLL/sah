<template>
    <Button icon="pi pi-arrows-v" severity="secondary" rounded text @click="visible = true" />
    <Dialog v-model:visible="visible" modal header="Switch Version" :style="{ width: '25rem' }">
        <div class="card">
            <div v-for="(data, func) in functions" :key="func" class="flex items-center gap-4 mb-4">
                <label class="font-semibold w-24">{{ func }}</label>
                <Select v-model="functionsForm[func]" :options="data.versions" id="name" class="flex-auto" autocomplete="off" />
                <br/>
            </div>

            <div class="flex justify-end gap-2">
                <Button type="button" label="Cancel" severity="secondary" @click="visible = false" :loading="loading"></Button>
                <Button type="button" label="Save" @click="rollback"></Button>
            </div>
        </div>
    </Dialog>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import Dialog from 'primevue/dialog';
import Select from 'primevue/select';
import Button from 'primevue/button';
import axios from 'axios';
import { useRoute } from 'vue-router';

    const visible = ref(false);
    const loading = ref(false);

    const functions = ref([]);

    const functionsForm = ref({});

    const route = useRoute()

    const emit = defineEmits(['pi-arrow-right-arrow-left'])

    const loadVersion = async () => {
        try {
            loading.value = true;
            const response = await axios.get(`/api/projects/${route.params.id}/versions`);
            functions.value = response.data;
        } catch (error) {
            console.log(error);
        } finally {
            loading.value = false;
        }
    }

    const rollback = async () => {
        try {
            loading.value = true;
            await axios.put(`/api/projects/${route.params.id}/updateVersions`, {
                functions: functionsForm.value
            });
            emit('versions-updated')
            loading.value = false;
            visible.value = false;
        } catch (error) {
            console.log(error);
        } finally {
            loading.value = false;
        }
    }

    onMounted(() => {
        loadVersion()
    })
</script>
