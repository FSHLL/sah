<template>
    <div>
        <ConfirmPopup></ConfirmPopup>
        <DataTable paginator :rows="projectStore.perPage" :totalRecords="projectStore.total" lazy
            :loading="projectStore.loading" :value="projectStore.projects" @page="onPage" tableStyle="min-width: 50rem">
            <template #header>
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <span class="text-xl font-bold"></span>
                    <Form/>
                </div>
            </template>
            <Column v-for="col of columns" :key="col.key" :field="col.dataIndex" :header="col.title"></Column>
            <Column header="Stack">
                <template #body="slotProps">
                    <ul class="list-disc">
                        <li v-for="f in slotProps.data.stack_resources.functions" :key="f">
                            {{ `${f.function} - ${f.version}` }}
                        </li>
                    </ul>
                    <p>{{ slotProps.data.stack_resources.version }}</p>
                </template>
            </Column>
            <Column header="Action">
                <template #body="slotProps">
                    <div class="flex flex-wrap gap-2">
                        <Button @click="showProject(slotProps.data)" label="Show" outlined/>
                        <Button @click="confirmDelete($event, slotProps.data)" label="Delete" severity="danger" outlined/>
                    </div>
                </template>
            </Column>
        </DataTable>
    </div>
</template>

<script setup>
import { onMounted } from "vue";
import { useConfirm } from "primevue/useconfirm";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import ConfirmPopup from 'primevue/confirmpopup'
import { useRouter } from "vue-router";
import Form from "./Form.vue";
import { useProjectStore } from "../../stores/projectStore";

const confirm = useConfirm();

const router = useRouter()
const projectStore = useProjectStore()

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
            projectStore.deleteProject(project);
        },
        reject: () => { }
    });
}

const onPage = (event) => {
    projectStore.loadProjects(event.page + 1)
};

const showProject = (project) => {
    projectStore.project = project
    router.push(`projects/${project.id}`)
};

onMounted(() => {
    projectStore.loadProjects()
})
</script>
