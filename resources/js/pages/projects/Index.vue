<template>
    <div>
        <DataTable :value="products" tableStyle="min-width: 50rem">
            <Column v-for="col of columns" :key="col.key" :field="col.dataIndex" :header="col.name"></Column>
        </DataTable>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

    let projects = []
    const loading = ref(true)
    const date = ref()

    const columns = [
        {
            name: 'Name',
            dataIndex: 'name',
            key: 'name',
        },
        {
            title: 'Status',
            dataIndex: 'status',
            key: 'status',
        },
        {
            title: 'Created at',
            dataIndex: 'created_at',
            key: 'created_at',
        },
        {
            title: 'Action',
            key: 'action',
        },
    ];

    const loadProjects= async () => {
        try {
            const response = await axios.get('/api/projects');
            projects = response.data;
        } catch (error) {
            console.log(error);
        } finally {
            loading.value = false;
        }
    }

    const deleteProject= async (project) => {
        try {
            await axios.delete(`/api/projects/${consult.id}`);
            const index = projects.indexOf(consult);
            if (index !== -1) {
                projects.splice(index, 1);
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
