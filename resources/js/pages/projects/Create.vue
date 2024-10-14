<template>
    <div class="card flex justify-center">
        <Button label="New" icon="pi pi-plus" @click="visible = true" />
        <Dialog v-model:visible="visible" modal header="Create Project" :style="{ width: '25rem' }">
            <div class="flex items-center gap-4 mb-4">
                <label for="name" class="font-semibold w-24">Name</label>
                <InputText v-model="project.name" id="name" class="flex-auto" autocomplete="off" />
            </div>
            <div class="flex items-center gap-4 mb-8">
                <label for="email" class="font-semibold w-24">Stack</label>
                <Select :loading="loadingStacks" v-model="project.stack" :options="stacks" filter optionLabel="StackName" placeholder="Select a Stack" class="flex-auto" />
            </div>
            <div class="flex justify-end gap-2">
                <Button type="button" label="Cancel" severity="secondary" @click="visible = false" :loading="loading"></Button>
                <Button :disabled="!project.name && !project.stack" type="button" label="Save" @click="createProject"></Button>
            </div>
        </Dialog>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';
import Button from 'primevue/button';
import axios from 'axios';
import { useToast } from 'primevue/usetoast';

    const project = ref({});
    const visible = ref(false);
    const loadingStacks = ref(false);
    const loading = ref(false);

    const stacks = ref([]);

    const toast = useToast()

    const loadStacks= async () => {
        try {
            loadingStacks.value = true;
            const response = await axios.get('/api/stacks');
            stacks.value = response.data;
        } catch (error) {
            toast.add({ severity: 'error', summary: 'Error', detail: error.response?.data.message ?? error.message, life: 3000 });
        } finally {
            loadingStacks.value = false;
        }
    }

    const createProject= async () => {
        try {
            loading.value = true;
            await axios.post('/api/projects', {
                name: project.value.name,
                stack_id: project.value.stack.StackId,
            });
            loading.value = false;
            visible.value = false;
        } catch (error) {
            toast.add({ severity: 'error', summary: 'Error', detail: error.response?.data.message ?? error.message, life: 5000 });
        } finally {
            loading.value = false;
        }
    }

    onMounted(() => {
        loadStacks()
    })
</script>
