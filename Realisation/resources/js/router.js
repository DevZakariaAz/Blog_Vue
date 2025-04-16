import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "./stores/auth";
import { watchEffect } from "vue";

const routes = [
    {
        path: "/test-dashboard",
        name: "test-dashboard",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/TestDashboard.vue"
            ),
        meta: { requiresAuth: false },
    },
    {
        path: "/",
        name: "home",
        component: () =>
            import("../../modules/PkgBlog/Resources/js/pages/public/Home.vue"),
        meta: { requiresAuth: false },
    },
    {
        path: "/articles",
        name: "articles",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/public/Articles.vue"
            ),
        meta: { requiresAuth: false },
    },
    {
        path: "/articles/:id",
        name: "article-detail",
        component: () =>
            import("../../modules/PkgBlog/Resources/js/pages/public/Show.vue"),
        meta: { requiresAuth: false },
    },
    {
        path: "/admin/dashboard",
        name: "admin-dashboard",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/Dashboard.vue"
            ),
        meta: { requiresAuth: true, role: "admin" },
    },
    {
        path: "/admin/articles",
        name: "admin-articles",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/article/index.vue"
            ),
        meta: { requiresAuth: true, permission: "view article" },
    },
    {
        path: "/admin/articles/create",
        name: "admin-article-create",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/article/create.vue"
            ),
        meta: { requiresAuth: true, permission: "create article" },
    },
    {
        path: "/admin/articles/:id",
        name: "admin-article-detail",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/article/show.vue"
            ),
        meta: { requiresAuth: true, permission: "view article" },
    },
    {
        path: "/admin/articles/:id/edit",
        name: "admin-article-edit",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/article/edit.vue"
            ),
        meta: { requiresAuth: true, permission: "edit article" },
    },
    {
        path: "/admin/categories",
        name: "admin-categories",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/category/index.vue"
            ),
        meta: { requiresAuth: true, permission: "view category" },
    },
    {
        path: "/admin/categories/:id/edit",
        name: "admin-category-edit",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/category/edit.vue"
            ),
        meta: { requiresAuth: true, permission: "edit category" },
    },
    {
        path: "/admin/categories/create",
        name: "admin-category-create",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/category/create.vue"
            ),
        meta: { requiresAuth: true, permission: "create category" },
    },
    {
        path: "/admin/tags",
        name: "admin-tags",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/tag/index.vue"
            ),
        meta: { requiresAuth: true, permission: "view tag" },
    },
    {
        path: "/admin/tags/create",
        name: "admin-tag-create",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/tag/create.vue"
            ),
        meta: { requiresAuth: true, permission: "create tag" },
    },
    {
        path: "/admin/tags/:id/edit",
        name: "admin-tag-edit",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/tag/edit.vue"
            ),
        meta: { requiresAuth: true, permission: "edit tag" },
    },
    {
        path: "/unauthorized",
        name: "unauthorized",
        component: () =>
            import("../../modules/PkgBlog/Resources/js/pages/Unauthorized.vue"),
    },
    {
        path: "/admin/comments",
        name: "admin-comments",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/comment/index.vue"
            ),
        meta: { requiresAuth: true, permission: "view comment" },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        return { top: 0 };
      }
});

router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();

    if (authStore.loading) {
        const stopWatching = watchEffect(() => {
            if (!authStore.loading) {
                stopWatching();
                router.push(to.fullPath);
            }
        });

        return next(false);
    }

    if (to.meta.requiresAuth === false) {
        return next();
    }

    if (to.meta.requiresAuth && !authStore.user) {
        window.location.href = "/login";
        return;
    }

    if (to.meta.role && !authStore.hasRole(to.meta.role)) {
        return next("/unauthorized");
    }

    if (to.meta.permission && !authStore.hasPermission(to.meta.permission)) {
        return next("/unauthorized");
    }

    next();
});

export default router;
