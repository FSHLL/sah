import { createRouter, createWebHistory } from 'vue-router';

import ProjectsIndex from '../pages/projects/Index.vue';

const router = createRouter({
    history: createWebHistory(),
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/projects',
            name: 'projects',
            component: ProjectsIndex,
        },
    ]
});

export default router;
