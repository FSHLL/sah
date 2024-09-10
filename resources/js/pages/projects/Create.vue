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
                <Select v-model="project.stack" :options="stacks" optionLabel="StackName" placeholder="Select a Stack" class="flex-auto" />
            </div>
            <div class="flex justify-end gap-2">
                <Button type="button" label="Cancel" severity="secondary" @click="visible = false"></Button>
                <Button type="button" label="Save" @click="createProject"></Button>
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

    const project = ref({});
    const visible = ref(false);
    const loading = ref(false);

    const stacks = ref([]);

    const loadStacks= async () => {
        try {
            loading.value = true;
            const response = await axios.get('/api/stacks');
            stacks.value = response.data;
        } catch (error) {
            console.log(error);
        } finally {
            loading.value = false;
        }
    }

    const createProject= async () => {
        try {
            loading.value = true;
            const response = await axios.post('/api/projects', {
                name: project.value.name,
                stack_id: project.value.stack.StackId,
            });
            loading.value = false;
            visible.value = false;
        } catch (error) {
            console.log(error);
        } finally {
            loading.value = false;
        }
    }

    onMounted(() => {
        loadStacks()
    })
</script>
