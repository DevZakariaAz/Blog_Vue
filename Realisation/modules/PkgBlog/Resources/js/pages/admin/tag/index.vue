<template>
    <Layout>
        <div class="p-6 space-y-6">
            <!-- Header: Title + Create Button -->
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">Tags</h2>
                <router-link v-if="authStore.permissions.includes('create tag')" :to="{ name: 'admin-tag-create' }"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                    + Create Tag
                </router-link>
            </div>

            <!-- Search Section -->
            <div class="flex flex-wrap items-center gap-4 bg-white p-4 rounded-lg shadow">
                <!-- Search Input -->
                <input v-model="searchQuery" type="text" placeholder="Search by name..."
                    class="border border-gray-300 p-2 rounded-lg w-full md:w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-500" />

                <!-- Reset Filters -->
                <button @click="searchQuery = ''"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Reset
                </button>
            </div>

            <!-- Tags Table -->
            <div class="overflow-x-auto bg-white p-4 rounded-lg shadow">
                <table class="w-full border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700 text-left">
                            <th class="py-2 px-4">#</th>
                            <th class="py-2 px-4">Name</th>
                            <th class="py-2 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody v-if="searchedTags.length">
                        <tr v-for="(tag, index) in searchedTags" :key="tag.id"
                            class="border-t hover:bg-gray-50 text-left">
                            <td class="py-2 px-4">{{ index + 1 }}</td>
                            <td class="py-2 px-4">{{ tag.name }}</td>
                            <td class="py-2 px-4 space-x-2">
                                <router-link v-if="authStore.permissions.includes('edit tag')" :to="{ name: 'admin-tag-edit', params: { id: tag.id } }"
                                    class="text-yellow-500 hover:underline">
                                    Edit
                                </router-link>
                                <button v-if="authStore.permissions.includes('delete tag')" @click="deleteTag(tag.id)" class="text-red-500 hover:underline">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="3" class="text-center py-4">No tags found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from "../../../components/Layout.vue";
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import { useAuthStore } from "@/stores/auth";

const authStore = useAuthStore();
const tags = ref([]);
const searchQuery = ref("");

const fetchTags = async () => {
    try {
        const response = await axios.get("/api/tags");
        tags.value = response.data.data;
    } catch (error) {
        console.error("Error fetching tags:", error);
    }
};

// Computed property for filtering tags
const searchedTags = computed(() => {
    return tags.value.filter(tag =>
        tag.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const deleteTag = async (tagId) => {
    if (confirm("Are you sure you want to delete this tag?")) {
        try {
            const response = await axios.delete(`/api/tags/${tagId}`);
            alert(response.data.message);

            // Remove category from the list
            tags.value = tags.value.filter(tag => tag.id !== tagId);
        } catch (error) {
            alert(error.response?.data?.message || "An error occurred. Please try again.");
        }
    }
};

onMounted(fetchTags);
</script>
