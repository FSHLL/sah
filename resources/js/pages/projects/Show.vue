<template>
    <Panel :header="project.name">
        <Message v-if="!hasAliases" severity="warn">No Alias created for this project</Message>
        <Message v-if="project.stack_resources?.alias_sync" severity="info">Alias Sync</Message>
        <br>
        <div class="card">
            <Tabs :value="0">
                <TabList v-for="(func, index) in functionsMapped" :key="func.label">
                    <Tab :value="index">{{ func.label }}</Tab>
                </TabList>
                <TabPanels>
                    <TabPanel v-for="(func, index) in functionsMapped" :key="func.children" :value="index">
                        <OrganizationChart :value="func">
                            <template #default="slotProps">
                                <span>{{ slotProps.node.label }}</span>
                            </template>
                        </OrganizationChart>
                    </TabPanel>
                </TabPanels>
            </Tabs>
        </div>
        <Divider/>
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
import { computed, onMounted, ref } from "vue";
import Card from 'primevue/card';
import Message from 'primevue/message';
import Panel from 'primevue/panel';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Divider from 'primevue/divider';
import OrganizationChart from 'primevue/organizationchart';
import Tabs from 'primevue/tabs';
import TabList from 'primevue/tablist';
import Tab from 'primevue/tab';
import TabPanels from 'primevue/tabpanels';
import TabPanel from 'primevue/tabpanel';
import { useRoute } from "vue-router";

    const project = ref({})
    const loading = ref(true)
    const deployments = ref([])
    const functionsMapped = ref([])

    const hasAliases = computed(() => project.value.stack_resources?.functions.some((f) => f.alias))

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
            mapFunction()
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

    const mapFunction = () => {
        functionsMapped.value = project.value.stack_resources?.functions.map(resource => {
            const children = [];

            children.push({
                label: resource.alias
            });

            children.push({
                label: resource.version
            });

            resource.triggers.forEach(trigger => {
                children.push({
                    label: trigger.function
                });
            });

            return {
                label: resource.function,
                children: children
            };
        })
    }

    onMounted(() => {
        loadProject()
        loadDeployments()
    })
</script>
