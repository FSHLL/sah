<template>
    <div>
        <ConfirmPopup></ConfirmPopup>
        <DataTable :loading="loading" :value="projects.data" tableStyle="min-width: 50rem">
            <template #header>
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <span class="text-xl font-bold"></span>
                    <Create></Create>
                </div>
            </template>
            <Column v-for="col of columns" :key="col.key" :field="col.dataIndex" :header="col.title"></Column>
            <Column header="Action">
                <template #body="slotProps">
                    <Button @click="router.push(`projects/${slotProps.data.id}`)" label="See" outlined></Button>
                    <Button @click="confirmDelete($event, slotProps.data)" label="Delete" severity="danger" outlined></Button>
                </template>
            </Column>
        </DataTable>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { useConfirm } from "primevue/useconfirm";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import ConfirmPopup from 'primevue/confirmpopup'
import { useRouter } from "vue-router";
import Create from "./Create.vue";

    const confirm = useConfirm();
    const projects = ref([])
    const loading = ref(true)

    const router = useRouter()

    const columns = [
        {
            title: 'Name',
            dataIndex: 'name',
            key: 'name',
        },
        {
            title: 'Created at',
            dataIndex: 'created_at',
            key: 'created_at',
        },
    ];

    const loadProjects= async () => {
        try {
            loading.value = true;
            const response = await axios.get('/api/projects');
            projects.value = response.data;
        } catch (error) {
            console.log(error);
        } finally {
            loading.value = false;
        }
    }

    const confirmDelete = (event, project) => {
        confirm.require({
            target: event.currentTarget,
            message: 'Do you want to delete this record?',
            icon: 'pi pi-info-circle',
            rejectProps: {
                label: 'Cancel',
                severity: 'secondary',
                outlined: true
            },
            acceptProps: {
                label: 'Delete',
                severity: 'danger'
            },
            accept: () => {
                deleteProject(project);
            },
            reject: () => {}
        });
    };

    const deleteProject= async (project) => {
        try {
            await axios.delete(`/api/projects/${project.id}`);
            const index = projects.value.indexOf(project);
            if (index !== -1) {
                projects.value.splice(index, 1);
                console.log('deleted');
            }
        } catch (error) {
            console.log(error);
        } finally {
            loading.value = false;
        }
    }

    onMounted(() => {
        loadProjects()
    })
</script>
