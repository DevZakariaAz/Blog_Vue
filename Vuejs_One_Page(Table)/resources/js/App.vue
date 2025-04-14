<template>
    <div class="max-w-4xl mx-auto p-8 bg-white shadow-lg rounded-lg">
        <h1 class="text-3xl font-semibold text-center mb-6">Products List</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
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
</template>

<script setup>
import { ref , onMounted } from 'vue';
import axios from 'axios';

onMounted(() => {
getArticles();
});

const Articles = ref([]);
const getArticles = async () => {
const response = await axios.get('http://127.0.0.1:8000/articles');
Articles.value = response.data;
};
</script>