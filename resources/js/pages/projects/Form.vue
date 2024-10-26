<template>
    <Button :icon="buttonIcon" severity="secondary" rounded text @click="visible = true" />
    <Dialog v-model:visible="visible" modal header="Create Project" :style="{ width: '25rem' }">
        <div class="flex items-center gap-4 mb-4">
            <label for="name" class="font-semibold w-24">Name</label>
            <InputText v-model="project.name" id="name" class="flex-auto" autocomplete="off" />
        </div>
        <div class="flex items-center gap-4 mb-8">
            <label for="email" class="font-semibold w-24">Stack</label>
            <Select :loading="loadingStacks" v-model="project.stack" :options="stacks" filter optionLabel="StackName"
                placeholder="Select a Stack" class="flex-auto" />
        </div>
        <div class="flex items-center gap-4 mb-4">
            <label for="alias" class="font-semibold w-24">Alias</label>
            <InputText v-model="project.alias" id="alias" class="flex-auto" autocomplete="off" />
        </div>
        <div class="flex justify-end gap-2">
            <Button type="button" label="Cancel" severity="secondary" @click="visible = false"
                :loading="projectStore.loading"></Button>
            <Button :disabled="!project.name && !project.stack" type="button" label="Save" @click="sendForm"></Button>
        </div>
    </Dialog>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';
import Button from 'primevue/button';
import axios from 'axios';
import { useProjectStore } from '../../stores/projectStore';
import { useToast } from 'primevue/usetoast';

const project = ref({});
const visible = ref(false);
const loadingStacks = ref(false);
const stacks = ref([]);

const toast = useToast()
const projectStore = useProjectStore()

const props = defineProps({
    edit: {
        type: Boolean,
        default: false,
    },
    buttonLabel: {
        type: String,
        default: 'New',
    },
    buttonIcon: {
        type: String,
        default: 'pi pi-plus',
    }
})

project.value.id = projectStore.project.id
project.value.name = projectStore.project.name
project.value.alias = projectStore.project.alias

const loadStacks = async () => {
    try {
        loadingStacks.value = true;
        const response = await axios.get('/api/stacks');
        stacks.value = response.data;
        project.value.stack = stacks.value.find(s => s.StackId === projectStore.project.stack_id)
    } catch (error) {
        toast.add({ severity: 'error', summary: 'Error', detail: error.response?.data.message ?? error.message, life: 3000 });
    } finally {
        loadingStacks.value = false;
    }
}

const sendForm = async () => {
    if (props.edit) {
        updateProject()
    } else {
        createProject()
    }
}

const createProject = async () => {
    const newProject = await projectStore.storeProject({
        name: project.value.name,
        stack_id: project.value.stack.StackId,
        alias: project.value.alias ?? 'ACTIVE'
    })
    if (newProject) {
        visible.value = false
    }
}

const updateProject = async () => {
    const editedProject = await projectStore.updateProject({
        id: project.value.id,
        name: project.value.name,
        stack_id: project.value.stack.StackId,
        alias: project.value.alias ?? 'ACTIVE'
    })
    if (editedProject) {
        visible.value = false
    }
}

onMounted(() => {
    loadStacks()
})
</script>
