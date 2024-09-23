<template>
    <ConfirmPopup></ConfirmPopup>
    <Panel :header="project.name">
        <template #icons>
            <Button icon="pi pi-cog" severity="secondary" rounded text />
        </template>
        <Message v-if="!hasAliases" severity="warn">No Alias created for this project</Message>
        <Message v-if="project.stack_resources?.alias_sync" severity="info">Alias Sync</Message>
        <br>
        <div class="card">
            <Splitter style="height: 300px">
                <SplitterPanel class="flex items-center justify-center" :size="25" :minSize="10">
                    <nav class="flex min-w-[240px] flex-col gap-1 p-1.5">
                        <div
                            v-for="(func, index) in functionsMapped" :key="func.label" @click="selectedFunction = index"
                            role="button"
                            class="text-slate-800 flex w-full items-center rounded-md p-3 transition-all hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100"
                        >
                            {{ func.label }} - <current-version :function="func.label"/>
                        </div>
                    </nav>
                </SplitterPanel>
                <SplitterPanel class="flex items-center justify-center" :size="75">
                    <div v-for="(func, index) in functionsMapped" :key="func.children">
                        <OrganizationChart :value="func" v-if="selectedFunction === index">
                            <template #default="slotProps">
                                <span>{{ slotProps.node.label }}</span>
                            </template>
                        </OrganizationChart>
                    </div>
                </SplitterPanel>
            </Splitter>
        </div>
        <Divider/>
        <Card>
            <template #title>Deployments</template>
            <template #content>
                <DataTable :loading="loading" :value="deployments.data" tableStyle="min-width: 50rem">
                    <template #empty> No deployments found. </template>
                    <Column v-for="col of columns" :key="col.key" :field="col.dataIndex" :header="col.title"></Column>
                    <Column header="Action">
                        <template #body="slotProps">
                            <Button @click="confirmRollback($event, slotProps.data)" severity="secondary" label="Switch" :loading="deployLoading" outlined />
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>
    </Panel>
</template>

<script setup>
import axios from "axios";
import { computed, onMounted, ref } from "vue";
import Card from 'primevue/card';
import Message from 'primevue/message';
import Panel from 'primevue/panel';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Divider from 'primevue/divider';
import OrganizationChart from 'primevue/organizationchart';
import Button from 'primevue/button';
import CurrentVersion from './CurrentVersion.vue';
import Splitter from 'primevue/splitter';
import SplitterPanel from 'primevue/splitterpanel';
import ConfirmPopup from "primevue/confirmpopup";

import { useRoute } from "vue-router";
import { useConfirm } from "primevue/useconfirm";

    const project = ref({})
    const loading = ref(true)
    const deployLoading = ref(false)
    const deployments = ref([])
    const functionsMapped = ref([])
    const updateVersion = ref(false)

    const selectedFunction = ref(0)

    const hasAliases = computed(() => project.value.stack_resources?.functions.some((f) => f.alias))

    const confirm = useConfirm();

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

            resource.triggers.forEach(trigger => {
                children.push({
                    label: trigger.Service
                });
            })

            children.push({
                label: resource.alias
            });

            return {
                label: resource.function,
                children: children
            };
        })
    }

    const confirmRollback = (event, deployment) => {
        confirm.require({
            target: event.currentTarget,
            message: 'Do you want to rollback to this deployment?',
            icon: 'pi pi-info-circle',
            rejectProps: {
                label: 'Cancel',
                severity: 'secondary',
                outlined: true
            },
            acceptProps: {
                label: 'Rollback',
                severity: 'danger'
            },
            accept: () => {
                rollbackToDeployment(deployment);
            },
            reject: () => {}
        });
    };

    const rollbackToDeployment = async (deployment) => {
        try {
            deployLoading.value = true
            await axios.put(`/api/projects/${route.params.id}/deployments/${deployment.id}/rollback`);
            updateVersion.value = !updateVersion.value
        } catch (error) {
            console.log(error);
        } finally {
            deployLoading.value = false;
        }
    }

    onMounted(() => {
        loadProject()
        loadDeployments()
    })
</script>
