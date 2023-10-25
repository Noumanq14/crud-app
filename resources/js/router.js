import { createWebHistory,createRouter } from "vue-router";

import home from "./pages/home.vue";
import login from "./pages/login.vue";
import dashboard from "./pages/dashboard.vue";
import company from "./pages/company/company.vue";
import addNewCompany from "./pages/company/addNewCompany.vue";
import { UserStore } from "@/store/UserStore.js";

const routes = [
    {
        path: "/",
        name: "Home",
        component: home
    },
    {
        path: "/login",
        name: "Login",
        component: login,
        meta: {
            requiresAuth: false
        }
    },
    {
        path: "/dashboard",
        name: "Dashboard",
        component: dashboard,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: "/company",
        name: "Company",
        component: company,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: "/addNewCompany",
        name: "AddNewCompany",
        component: addNewCompany,
        meta: {
            requiresAuth: true
        }
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from) => {
    const store = UserStore();
    if (to.meta.requiresAuth && !store.token)
        return {name: 'Login'}
    if (to.meta.requiresAuth == false && store.token)
        return {name: 'Dashboard'}
});

export default router;
