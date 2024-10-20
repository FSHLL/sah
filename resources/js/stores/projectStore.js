import { defineStore } from 'pinia'
import axios from "axios";
import { useToast } from 'primevue/usetoast';

export const useProjectStore = defineStore('projects', {
    state: () => ({
        projectsData: [],
        project: {},
        loadingData: false,
        total: 0,
        perPage: 15,
        currentPage: 1,
        toast: useToast()
    }),

    getters: {
        projects: state => state.projectsData,
        loading: state => state.loadingData,
    },

    actions: {
        async loadProjects(page = 1) {
            try {
                this.loadingData = true
                const response = await axios.get('/api/projects', {
                    params: {
                        page,
                        perPage: this.perPage
                    }
                });
                this.projectsData = response.data.data;
                this.total = response.data.total;
                this.currentPage = response.data.current_page;
            } catch (error) {
                this.toast.add({ severity: 'error', summary: 'Error', detail: error.response?.data.message ?? error.message, life: 3000 });
            } finally {
                this.loadingData = false
            }
        },
        async loadProject(id) {
            try {
                this.loadingData = true
                const response = await axios.get(`/api/projects/${id}`);
                this.project = response.data;
            } catch (error) {
                this.toast.add({ severity: 'error', summary: 'Error', detail: error.response?.data.message ?? error.message, life: 3000 });
            } finally {
                this.loadingData = false
            }
        },
        async storeProject(project) {
            try {
                this.loadingData = true
                const response = await axios.post('/api/projects', project);
                this.projectsData.push(response.data)
                return response.data
            } catch (error) {
                this.toast.add({ severity: 'error', summary: 'Error', detail: error.response?.data.message ?? error.message, life: 3000 });
            } finally {
                this.loadingData = false
            }
        },
        async deleteProject(project) {
            try {
                this.loadingData = true
                await axios.delete(`/api/projects/${project.id}`);
                const index = this.projectsData.findIndex((p) => p.id === project.id)
                this.projectsData.splice(index, 1)
                return true
            } catch (error) {
                this.toast.add({ severity: 'error', summary: 'Error', detail: error.response?.data.message ?? error.message, life: 3000 });
            } finally {
                this.loadingData = false;
            }
        }
    }
});
