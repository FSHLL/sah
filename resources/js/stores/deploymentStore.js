import { defineStore } from 'pinia'
import axios from "axios";
import { useToast } from 'primevue/usetoast';

export const useDeploymentStore = defineStore('deployments', {
    state: () => ({
        deploymentsData: [],
        loadingData: false,
        total: 0,
        perPage: 15,
        currentPage: 1,
        toast: useToast()
    }),

    getters: {
        deployments: state => state.deploymentsData,
        loading: state => state.loadingData,
    },

    actions: {
        async loadDeployments(project, page = 1) {
            try {
                this.loadingData = true
                const response = await axios.get(`/api/projects/${project.id}/deployments`, {
                    params: {
                        page,
                        perPage: this.perPage
                    }
                });
                this.deploymentsData = response.data.data;
                this.total = response.data.total;
                this.currentPage = response.data.current_page;
            } catch (error) {
                this.toast.add({ severity: 'error', summary: 'Error', detail: error.response?.data.message ?? error.message, life: 3000 });
            } finally {
                this.loadingData = false
            }
        }
    }
});
