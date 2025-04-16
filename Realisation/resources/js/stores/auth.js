import { defineStore } from "pinia";
import axios from "axios";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        user: null,
        roles: [],
        permissions: [],
        loading: true,
    }),
    getters: {
        isLoggedIn: (state) => !!state.user,
    },
    actions: {
        async fetchUser() {
            try {
                const response = await axios.get("/user");
                this.user = response.data.user;
                this.roles = response.data.roles;
                this.permissions = response.data.permissions;
                this.loading = false;
            } catch (error) {
                console.error("Failed to fetch user data:", error);
            } finally {
                this.loading = false;
            }
        },
        logout() {
            this.user = null;
            this.roles = [];
            this.permissions = [];
            this.loading = false;
        },
        hasPermission(permission) {
            return this.permissions.includes(permission);
        },
        hasRole(role) {
            return this.roles.includes(role);
        },
    },
});
