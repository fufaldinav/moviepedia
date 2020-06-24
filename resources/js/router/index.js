import Vue from 'vue';
import VueRouter from 'vue-router';
import AppBdError from '../components/AppBdError';
import AppNotFound from '../components/AppNotFound';
import AppTable from '../components/AppTable';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', name: 'table', component: AppTable },
        { path: '/error', name: 'error', component: AppBdError },
        { path: '*', name: '404', component: AppNotFound },
    ],
});

export default router;
