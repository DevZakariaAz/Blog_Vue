<template>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <Sidebar :isCollapsed="isSidebarCollapsed" />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navbar -->
            <Navbar :isSidebarCollapsed="isSidebarCollapsed" @toggle-sidebar="toggleSidebar" />

            <!-- Main Content Area -->
            <main :class="[
                'flex-1 overflow-y-auto p-4 bg-gray-100',
                isSidebarCollapsed ? 'ml-16' : 'ml-64',
            ]" style="margin-top: 4rem;">
                    <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import Sidebar from './Sidebar.vue';
import Navbar from './Navbar.vue';

const isSidebarCollapsed = ref(false);

const toggleSidebar = () => {
    isSidebarCollapsed.value = !isSidebarCollapsed.value;
};

</script>

<style scoped>
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    z-index: 50;
}

.navbar {
    position: fixed;
    top: 0;
    left: 16rem;
    right: 0;
    z-index: 40;
    height: 4rem;
    transition: left 0.3s ease;
}

.navbar.collapsed {
    left: 4rem;
}
</style>