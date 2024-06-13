<template>
    <div>

    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import Calendar from 'primevue/calendar'

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

            if (response.status === 200) {
                projects = response.data;
            }
        } catch (error) {
            console.log(error);
        } finally {
            loading.value = false;
        }
    }

    const deleteProject= async (project) => {
        try {
            const response = await axios.delete(`/api/projects/${consult.id}`);
            if (response.status === 200) {
                const index = projects.indexOf(consult);
                if (index !== -1) {
                    projects.splice(index, 1);
                    console.log('deleted');
                }
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
