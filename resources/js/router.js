import { createRouter, createWebHistory } from "vue-router";
import axios from "axios";

const routes = [
    { path: "/", component: () => import("./Pages/HomeRoute.vue") },
    {
        path: "/dashboard",
        component: () => import("./Pages/Dashboard.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/login",
        component: () => import("./Pages/Login.vue"),
    },
    {
        path: "/register",
        component: () => import("./Pages/Register.vue"),
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// global navigation guard
router.beforeEach(async (to, from, next) => {
    if (to.meta.requiresAuth) {
        try {
            // Check if the user is authenticated
            await axios.get("/user");
            next();
        } catch (error) {
            // Redirect to the login page if not authenticated
            console.error("Unauthorized access. Redirecting to login.");
            next("/login");
        }
    } else {
        next(); // Always allow access if no auth is required
    }
});

export default router;
