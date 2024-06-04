<template>
    <el-page-header>
        <template #extra>
            <!-- <router-link :to="{ name: 'consults.create' }"> -->
                <el-button>{{ $t('projects.titles.create') }}</el-button>
            <!-- </router-link> -->
        </template>
    </el-page-header>
    <el-table
        :columns="columns"
        :row-key="(record) => record.id"
        :data-source="projects.data"
        :loading="loading"
    >
        <!-- <template #bodyCell="{ column, record }">
            <template v-if="column.key === 'action'">
                <span>
                    <router-link :to="{ path: `/consults/${record.id}` }">
                        <a-button>See</a-button>
                    </router-link>
                    <a-divider type="vertical" />
                        <a-popconfirm
                            title="Are you sure delete this consult?"
                            ok-text="Yes"
                            cancel-text="No"
                            :okButtonProps="{danger: true}"
                            @confirm="deleteConsult(record)"
                        >
                            <a-button danger>Delete</a-button>
                        </a-popconfirm>
                </span>
            </template>
        </template> -->
    </el-table>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { ElMessage } from 'element-plus'

    let projects = []
    const loading = ref(true)

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
            ElMessage('This is a error message.')
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
                    ElMessage('This is a message.')
                }
            }
        } catch (error) {
            ElMessage('This is a error message.')
        } finally {
            loading.value = false;
        }
    }

    onMounted(() => {
        loadProjects()
    })
</script>
