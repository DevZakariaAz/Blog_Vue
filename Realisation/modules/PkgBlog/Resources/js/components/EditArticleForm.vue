<template>
    <!-- Article Form -->
    <form @submit.prevent="submitForm" class="space-y-6">
        <!-- Title -->
        <div>
            <label for="title" class="block text-gray-700 font-semibold mb-2">Title</label>
            <input v-model="article.title" type="text" id="title"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition-all duration-200 ease-in-out"
                required />
        </div>

        <!-- Category -->
        <div>
            <label for="category" class="block text-gray-700 font-semibold mb-2">Category</label>
            <select v-model="article.category_id" id="category"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition-all duration-200 ease-in-out"
                required>
                <option v-for="category in categories" :key="category.id" :value="category.id">
                    {{ category.name }}
                </option>
            </select>
        </div>

        <!-- Content -->
        <div>
            <label for="content" class="block text-gray-700 font-semibold mb-2">Content</label>
            <textarea v-model="article.content" id="content" rows="6"
                class="w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition-all duration-200 ease-in-out"
                required></textarea>
        </div>

        <!-- Tags -->
        <div>
            <label for="tags" class="block text-gray-700 font-semibold mb-2">Tags</label>
            <div class="space-x-2">
                <span v-for="tag in tags" :key="tag.id" class="inline-block mb-2">
                    <input type="checkbox" :value="tag.id" v-model="selectedTags" class="mr-2">
                    {{ tag.name }}
                </span>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end space-x-4">
            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                Save
            </button>
            <button type="button" @click="cancel"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600 transition">
                Cancel
            </button>
        </div>
    </form>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();
const article = ref({
    title: '',
    content: '',
    category_id: '',
});
const categories = ref([]);
const tags = ref([]);
const selectedTags = ref([]);

// Fetch categories, tags, and article data
const fetchArticleData = async (id) => {
    try {
        const response = await axios.get(`/api/articles/${id}/edit`);
        article.value = response.data.article;
        categories.value = response.data.categories;
        tags.value = response.data.tags;
        selectedTags.value = response.data.selectedTags;
    } catch (error) {
        console.error('Error fetching article:', error);
    }
};

// Submit the updated article
const submitForm = async () => {
    const updatedArticle = {
        ...article.value,
        tags: selectedTags.value, // Pass the selected tags directly
    };

    try {
        await axios.put(`/api/articles/${article.value.id}`, updatedArticle);
        router.push(`/articles/${article.value.id}`);
    } catch (error) {
        console.error('Error updating article:', error);
    }
};

// Fetch data on mounted
onMounted(() => {
    const articleId = router.currentRoute.value.params.id;
    fetchArticleData(articleId);
});

const cancel = () => {
    router.push('/admin/articles'); // Redirect to the articles page
};
</script>

<style scoped>
input,
textarea,
select {
    transition: all 0.2s ease-in-out;
}

input:focus,
textarea:focus,
select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
}

button:hover {
    background-color: #2563eb;
}

button:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}

button:disabled {
    background-color: #d1d5db;
    cursor: not-allowed;
}
</style>