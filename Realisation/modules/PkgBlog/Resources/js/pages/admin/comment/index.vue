<template>
    <Layout>
        <div class="p-6 space-y-6">
            <!-- Header -->
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">Comments</h2>
            </div>

            <!-- Filters -->
            <div class="flex flex-wrap items-center gap-4 bg-white p-4 rounded-lg shadow">
                <input v-model="searchQuery" type="text" placeholder="Search by comment content..."
                    class="border border-gray-300 p-2 rounded-lg w-full md:w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-500" />

                <select v-model="selectedArticle"
                    class="border border-gray-300 p-2 rounded-lg w-full md:w-1/4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Articles</option>
                    <option v-for="article in articles" :key="article.id" :value="article.id">
                        {{ article.title }}
                    </option>
                </select>

                <button @click="searchQuery = ''; selectedArticle = ''"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Reset
                </button>
            </div>

            <!-- Comments Table -->
            <div class="overflow-x-auto bg-white p-4 rounded-lg shadow">
                <table class="w-full border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700 text-left">
                            <th class="py-2 px-4">#</th>
                            <th class="py-2 px-4">Article</th>
                            <th class="py-2 px-4">Author</th>
                            <th class="py-2 px-4">Content</th>
                            <th class="py-2 px-4">Created At</th>
                            <th class="py-2 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody v-if="filteredComments.length">
                        <tr v-for="(comment, index) in filteredComments" :key="comment.id"
                            class="border-t hover:bg-gray-50 text-left">
                            <td class="py-2 px-4">{{ index + 1 }}</td>
                            <td class="py-2 px-4">{{ comment.article.title }}</td>
                            <td class="py-2 px-4">{{ comment.user.name }}</td>
                            <td class="py-2 px-4 max-w-xs truncate">{{ comment.content }}</td>
                            <td class="py-2 px-4">{{ formatDate(comment.created_at) }}</td>
                            <td class="py-2 px-4 space-x-2">
                                <router-link v-if="authStore.hasPermission('view comment')"
                                    to=""
                                    class="text-blue-500 hover:underline">
                                    View
                                </router-link>
                                <button
                                    v-if="(authStore.hasPermission('delete comment') && comment.user_id === authStore.user.id) || authStore.hasRole('admin')"
                                    @click="deleteComment(comment.id)" class="text-red-500 hover:underline">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="6" class="text-center py-4">No comments found.</td>
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
const articles = ref([]);
const comments = ref([]);
const searchQuery = ref("");
const selectedArticle = ref("");

const fetchComments = async () => {
    try {
        const response = await axios.get("/api/comments");
        const data = response.data.data;

        comments.value = data;

        const uniqueArticles = new Map();
        data.forEach(comment => {
            if (comment.article && !uniqueArticles.has(comment.article.id)) {
                uniqueArticles.set(comment.article.id, comment.article);
            }
        });
        articles.value = [...uniqueArticles.values()];
    } catch (error) {
        console.error("Error fetching comments:", error);
    }
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString();
};

const filteredComments = computed(() => {
    return comments.value.filter(comment => {
        const matchesSearch = comment.content
            .toLowerCase()
            .includes(searchQuery.value.toLowerCase());

        const matchesArticle = selectedArticle.value
            ? comment.article.id === selectedArticle.value
            : true;

        if (authStore.hasRole('admin')) {
            return matchesSearch && matchesArticle;
        }

        const isOwner = comment.user_id === authStore.user.id;
        return matchesSearch && matchesArticle && isOwner;
    });
});

const deleteComment = async (commentId) => {
    if (confirm("Are you sure you want to delete this comment?")) {
        try {
            await axios.delete(`/api/comments/${commentId}`);
            comments.value = comments.value.filter(comment => comment.id !== commentId);
        } catch (error) {
            console.error("Error deleting comment:", error);
            alert("There was an error deleting the comment. Please try again later.");
        }
    }
};

onMounted(fetchComments);
</script>