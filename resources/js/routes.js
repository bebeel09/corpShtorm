import Vue from 'vue';
import VueRouter from 'vue-router';
import Page403 from "./pages/error/403";

Vue.use(VueRouter);

const router = new VueRouter({
    base: '/',
    routes: [
        {
            path: '/403',
            component: Page403,
        }
    ]
});

export default router;