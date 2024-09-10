<template>
    <Panel :header="project.name">
        <Message v-if="!project.stack_resources?.aliases" severity="warn">No Alias created for this project</Message>
        <Message v-if="project.stack_resources?.alias_sync" severity="info">Alias Sync</Message>

        <div class="flex items-center justify-center">
            <Card v-for="func in project.stack_resources?.functions" :key="func">
                <template #title>{{ func }}</template>
            </Card>
        </div>
        <br>
        <Card>
            <template #title>Deployments</template>
            <template #content>
                <DataTable :loading="loading" :value="deployments.data" tableStyle="min-width: 50rem">
                    <template #empty> No deployments found. </template>
                    <Column v-for="col of columns" :key="col.key" :field="col.dataIndex" :header="col.title"></Column>
                </DataTable>
            </template>
        </Card>
    </Panel>
</template>

<script setup>
import { onMounted, ref } from "vue";
import Card from 'primevue/card';
import Message from 'primevue/message';
import Panel from 'primevue/panel';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { useRoute } from "vue-router";

    const project = ref({})
    const loading = ref(true)
    const deployments = ref([])

    const columns = [
        {
            title: 'ID',
            dataIndex: 'id',
            key: 'id',
        },
        {
            title: 'Created at',
            dataIndex: 'created_at',
            key: 'created_at',
        },
    ];

    const route = useRoute()

    const loadProject = async () => {
        try {
            loading.value = true;
            const response = await axios.get(`/api/projects/${route.params.id}`);
            project.value = response.data;
        } catch (error) {
            console.log(error);
        } finally {
            loading.value = false;
        }
    }

    const loadDeployments = async () => {
        try {
            loading.value = true;
            const response = await axios.get(`/api/projects/${route.params.id}/deployments`);
            deployments.value = response.data;
        } catch (error) {
            console.log(error);
        } finally {
            loading.value = false;
        }
    }


    onMounted(() => {
        loadProject()
        loadDeployments()
    })
</script>
