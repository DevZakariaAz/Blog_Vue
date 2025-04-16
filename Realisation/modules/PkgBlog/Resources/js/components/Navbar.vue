<template>
    <header :class="[
        'navbar flex h-16 items-center bg-white border-b',
        isSidebarCollapsed ? 'collapsed' : '',
    ]">
        <!-- Navbar content -->
        <div class="flex items-center gap-2 px-4 w-full">
            <!-- Sidebar Toggle Button -->
            <button @click="toggleSidebar" class="p-2 hover:bg-gray-100 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Breadcrumb -->
            <breadcrumbs />

            <!-- Search Bar -->
            <!-- <div class="ml-auto">
                <input type="text" placeholder="Search posts..."
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div> -->
        </div>
    </header>
</template>

<script setup>
import breadcrumbs from './breadcrumbs.vue';
const emit = defineEmits(['toggle-sidebar']);

const toggleSidebar = () => {
    emit('toggle-sidebar');
};

// Receive the collapsed state from the parent
const props = defineProps({
    isSidebarCollapsed: {
        type: Boolean,
        default: false,
    },
});
</script>