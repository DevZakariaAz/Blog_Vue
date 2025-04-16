<template>
    <aside :class="[
        'sidebar bg-gray-800 text-white transition-all duration-300 ease-in-out flex flex-col',
        isCollapsed ? 'w-16' : 'w-64',
    ]">
        <!-- Sidebar Header -->
        <div class="p-4 border-b border-gray-700">
            <h2 v-if="!isCollapsed" class="text-lg font-semibold">My Blog</h2>
            <h2 v-else class="text-lg font-semibold text-center">MB</h2>
        </div>

        <!-- Navigation Menu -->
        <div class="p-4 flex-1">
            <ul class="space-y-2">
                <li v-if="authStore.roles.includes('admin')">
                    <router-link :to="{ name: 'admin-dashboard' }" class="flex items-center p-2 hover:bg-gray-700 rounded">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span v-if="!isCollapsed" class="ml-2">Dashboard</span>
                    </router-link>
                </li>
                <li v-if="authStore.permissions.includes('view article')">
                    <router-link :to="{ name: 'admin-articles' }" class="flex items-center p-2 hover:bg-gray-700 rounded">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span v-if="!isCollapsed" class="ml-2">Articles</span>
                    </router-link>
                </li>
                <li v-if="authStore.permissions.includes('view category')">
                    <router-link :to="{ name: 'admin-categories' }" class="flex items-center p-2 hover:bg-gray-700 rounded">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 3v18M18 3v18" />
                        </svg>
                        <span v-if="!isCollapsed" class="ml-2">Categories</span>
                    </router-link>
                </li>
                <li v-if="authStore.permissions.includes('view tag')">
                    <router-link :to="{ name: 'admin-tags' }" class="flex items-center p-2 hover:bg-gray-700 rounded">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5a2 2 0 012 2v5.293a2 2 0 01-.586 1.414l-6.707 6.707a2 2 0 01-2.828 0l-3.172-3.172a2 2 0 010-2.828L5.293 7.586A2 2 0 016.707 7H7z" />
                        </svg>
                        <span v-if="!isCollapsed" class="ml-2">Tags</span>
                    </router-link>
                </li>
                <li v-if="authStore.permissions.includes('view comment')">
                    <router-link :to="{ name: 'admin-comments' }" class="flex items-center p-2 hover:bg-gray-700 rounded">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6M9 11h6M9 15h6" />
                        </svg>
                        <span v-if="!isCollapsed" class="ml-2">Comments</span>
                    </router-link>
                </li>
                <li v-if="authStore.roles.includes('admin')">
                    <router-link to="/users" class="flex items-center p-2 hover:bg-gray-700 rounded">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14c-4.418 0-8 3.582-8 8s3.582 8 8 8 8-3.582 8-8-3.582-8-8-8zm0 0c2.485 0 4.5-2.015 4.5-4.5S14.485 5 12 5 7.5 7.015 7.5 9.5 9.515 14 12 14z" />
                        </svg>
                        <span v-if="!isCollapsed" class="ml-2">Users</span>
                    </router-link>
                </li>
            </ul>
        </div>

        <!-- User Profile -->
        <div class="p-4 border-t border-gray-700 relative">
            <div class="flex items-center cursor-pointer" @click="toggleDropdown">
                <img v-if="authStore.user" :src="authStore.user.profile_image" :alt="authStore.user.name || 'User'"
                    class="w-8 h-8 rounded-full" />
                <div v-if="authStore.user && !isCollapsed" class="ml-3">
                    <p class="text-sm font-semibold">{{ authStore.user.name }}</p>
                    <p class="text-xs text-gray-400">{{ authStore.user.email }}</p>
                </div>
            </div>

            <!-- Dropdown -->
            <ul v-show="isDropdownOpen"
                class="absolute left-0 bottom-full transform -translate-y-2 w-52 bg-white text-gray-900 shadow-lg rounded-lg p-2 z-50">
                <li>
                    <a href="/profile" class="block px-4 py-2 hover:bg-gray-200">Profile</a>
                </li>
                <li>
                    <button @click="logout" class="block w-full text-left px-4 py-2 hover:bg-gray-200">
                        Log Out
                    </button>
                </li>
            </ul>
        </div>
    </aside>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { useAuthStore } from "@/stores/auth";

const authStore = useAuthStore();

// Sidebar collapsed state
defineProps({
    isCollapsed: {
        type: Boolean,
        default: false,
    },
});

const isDropdownOpen = ref(false);

const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};

const router = useRouter();
const logout = async () => {
    try {
        await axios.post('/logout'); // Send logout request
        authStore.logout(); // Call the logout method from the auth store
        window.location.href = '/'; // Redirect to home page after logout
    } catch (error) {
        console.error('Logout failed:', error);
    }
};

</script>
