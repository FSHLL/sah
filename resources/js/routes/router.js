import { createRouter, createWebHistory } from 'vue-router';

import ProjectsIndex from '../pages/projects/Index.vue';
import ProjectsShow from '../pages/projects/Show.vue';

const router = createRouter({
    history: createWebHistory(),
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/projects',
            name: 'projects',
            component: ProjectsIndex,
        },
        {
            path: '/projects/:id',
            name: 'projects.show',
            component: ProjectsShow,
        },
    ]
});

export default router;
