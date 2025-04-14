<template>
    <div class="max-w-4xl mx-auto p-8 bg-white shadow-lg rounded-lg">
        <h1 class="text-3xl font-semibold text-center mb-6">Article List</h1>

        <div class="overflow-x-auto">
            <button @click="showModal = true" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Add Article
            </button>
            <table class="min-w-full mt-4 bg-white border border-gray-300 rounded-lg shadow-md">
                <thead class="bg-gray-50">
                    <tr class="text-left text-sm text-gray-700">
                        <th class="px-6 py-4 border-b font-medium">Name</th>
                        <th class="px-6 py-4 border-b font-medium">Description</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    <tr v-for="article in Articles" :key="article.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 border-b">{{ article.title }}</td>
                        <td class="px-6 py-4 border-b">{{ article.content }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Add Article</h2>
            <form @submit.prevent="addArticle">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input v-model="newArticle.title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea v-model="newArticle.content" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2" required></textarea>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="button" @click="showModal = false" class="mr-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Add
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const Articles = ref([]);
const showModal = ref(false);
const newArticle = ref({
    title: '',
    content: '',
});

onMounted(() => {
    getArticles();
});

const getArticles = async () => {
    try {
        const response = await axios.get('http://127.0.0.1:8000/articles');
        Articles.value = response.data;
    } catch (error) {
        console.error('Error fetching articles:', error);
    }
};

const addArticle = async () => {
    try {
        await axios.post('http://127.0.0.1:8000/articles', newArticle.value);
        await getArticles();
        newArticle.value = { title: '', content: '' };
        showModal.value = false;
    } catch (error) {
        console.error('Error adding article:', error);
    }
};
</script>
