<template>
    <ConfirmPopup></ConfirmPopup>
    <Panel :header="projectStore.project.name">
        <template #icons>
            <SwitchAlias v-if="hasAliases" @versions-updated="updateVersions"></SwitchAlias>
            <Button icon="pi pi-send" severity="secondary" rounded text @click="toggle" />
            <Popover ref="op">
                <div class="flex flex-col gap-4 w-[25rem]">
                    <span class="font-medium block mb-2">Deploy project URL</span>
                    <InputText v-on:focus="$event.target.select()" :value="getProjectURL()" readonly></InputText>
                    <Button class="flex justify-center w-full" icon="pi pi-copy" severity="secondary" @click="copy" />
                </div>
            </Popover>
        </template>
        <Message v-if="!hasAliases" severity="warn">No Alias created for this project</Message>
        <Message v-if="projectStore.project.stack_resources?.alias_sync" severity="info">Alias Sync</Message>
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
                            {{ func.label }} <current-version v-if="hasAliases" :ref="setVersionRef" :function="func.label"/>
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
        <Card v-if="hasAliases">
            <template #title>Deployments</template>
            <template #content>
                <DataTable paginator :rows="deploymentStore.perPage" :totalRecords="deploymentStore.total" lazy :loading="deploymentStore.loading" :value="deploymentStore.deployments" tableStyle="min-width: 50rem">
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
import SwitchAlias from './SwitchAlias.vue';
import Popover from 'primevue/popover';
import InputText from 'primevue/inputtext';

import { useRoute } from "vue-router";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import { useProjectStore } from "../../stores/projectStore";
import { useDeploymentStore } from "../../stores/deploymentStore";

    const deployLoading = ref(false)
    const currentVersions = ref([])

    const selectedFunction = ref(0)
    const op = ref();

    const hasAliases = computed(() => projectStore.project.stack_resources?.functions.some((f) => f.alias !== ''))

    const confirm = useConfirm();
    const toast = useToast()
    const projectStore = useProjectStore()
    const deploymentStore = useDeploymentStore()
    const route = useRoute()

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

    const functionsMapped = computed(() => {
        return projectStore.project.stack_resources?.functions.map(resource => {
            const children = [];

            resource.triggers.forEach(trigger => {
                children.push({
                    label: trigger.service
                });
            })

            if (resource.alias) {
                children.push({
                    label: resource.alias
                });
            }

            return {
                label: resource.function,
                children: children
            };
        })
    })

    const loadProject = async () => {
        if (route.params.id !== projectStore.project.id) {
            await projectStore.loadProject(route.params.id)
        }
    }

    const loadDeployments = async () => {
        if (projectStore.project.id) {
            await deploymentStore.loadDeployments(projectStore.project)
        }
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
            updateVersions()
        } catch (error) {
            console.log(error);
        } finally {
            deployLoading.value = false;
        }
    }

    const setVersionRef = (el) => {
        currentVersions.value.push(el);
    }

    const updateVersions = () => {
        currentVersions.value.forEach((cv) => cv.loadVersion())
    }

    const getProjectURL = () => {
        return `${window.location.origin}/api/projects/${route.params.id}/deploy`
    }

    const toggle = (event) => {
        op.value.toggle(event);
    }

    const copy = async () => {
        try {
            await navigator.clipboard.writeText(getProjectURL());
            toast.add({ severity: 'success', summary: 'Copy successful', life: 3000 });
        } catch(error) {
            toast.add({ severity: 'error', summary: 'Error', detail: error.message, life: 3000 });
        }
    }

    onMounted(async () => {
        await loadProject()
        await loadDeployments()
    })
</script>
