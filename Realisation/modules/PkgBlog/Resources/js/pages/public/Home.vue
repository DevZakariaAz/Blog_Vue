<template>
    <div class="font-sans text-gray-900">
        <!-- Navigation Bar -->
        <PublicNavbar @search="handleSearch" :categories="categories"/>

        <!-- Loading State -->
        <div v-if="loading" class="flex justify-center items-center min-h-screen">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
        </div>

        <!-- Error State -->
        <div v-else-if="error" class="flex justify-center items-center min-h-screen">
            <div class="bg-white p-8 rounded-xl shadow-md max-w-md text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-500 mx-auto mb-4" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Error Loading Home Page</h2>
                <p class="text-gray-600 mb-4">{{ error }}</p>
                <button @click="fetchHomeData"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    Try Again
                </button>
            </div>
        </div>

        <div v-else>
            <!-- Hero Section -->
            <HeroSection :featuredArticle="featuredArticle" :categories="categories" :popularTags="popularTags"
                :formatDate="formatDate" @subscribeToNewsletter="subscribeToNewsletter" :articlesCount="articlesCount"
                :readersCount="readersCount" :categoriesCount="categoriesCount"
                @scrollToNewsletter="scrollToNewsletter" />

            <!-- Featured Article -->
            <section class="bg-gray-50 pt-24 pb-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-bold text-center mb-12">Featured Article</h2>
                    <div v-if="featuredArticle?.id"
                        class="bg-white rounded-xl overflow-hidden shadow-lg flex flex-col md:flex-row">
                        <div class="md:w-1/2 relative">
                            <img v-if="featuredArticle.featured_image_url" :src="featuredArticle.featured_image_url"
                                :alt="featuredArticle.title" class="w-full h-full object-cover" />
                            <span
                                class="absolute top-4 left-4 bg-gray-800 text-white px-4 py-1 rounded-full text-sm font-semibold">
                                Featured
                            </span>
                        </div>
                        <div class="md:w-1/2 p-8 flex flex-col">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                {{ featuredArticle?.category?.name || 'Uncategorized' }}
                            </span>
                            <h3 class="text-2xl font-bold mb-4">{{ featuredArticle.title }}</h3>
                            <p class="text-gray-600 mb-6 flex-grow">{{ featuredArticle.description }}</p>
                            <div class="flex justify-between items-center mb-6">
                                <div class="flex items-center space-x-3">
                                    <img :src="featuredArticle?.user?.profile_image" :alt="featuredArticle?.user?.name"
                                        class="w-10 h-10 rounded-full object-cover" />
                                    <span class="font-medium">{{ featuredArticle?.user?.name || 'Unknown' }}</span>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <span>{{ formatDate(featuredArticle.created_at) }}</span>
                                </div>
                            </div>
                            <router-link :to="{ name: 'article-detail', params: { id: featuredArticle.id } }"
                                class="bg-gray-800 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-900 transition duration-200 self-start">
                                Read Article
                            </router-link>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Categories Section -->
            <section class="py-16 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-bold text-center mb-10">Explore Topics</h2>
                    <div class="flex flex-wrap justify-center gap-3">
                        <button @click="filterByCategory(null)"
                            :class="selectedCategory === null ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                            class="px-5 py-2 rounded-full text-sm font-medium transition duration-200">
                            All
                        </button>
                        <button v-for="category in categories" :key="category.id" @click="filterByCategory(category.id)"
                            :class="selectedCategory === category.id ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                            class="px-5 py-2 rounded-full text-sm font-medium transition duration-200">
                            {{ category.name }}
                        </button>
                    </div>
                </div>
            </section>

            <!-- Recent Articles -->
            <section class="py-16 bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center mb-12">
                        <h2 class="text-3xl font-bold">Recent Articles</h2>
                        <router-link :to="{ name: 'articles' }" class="text-gray-800 font-semibold hover:underline">View
                            All</router-link>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        <article v-for="article in filteredArticles" :key="article.id"
                            class="bg-white rounded-xl overflow-hidden shadow-lg transition duration-300 hover:-translate-y-2 hover:shadow-xl">
                            <div class="relative h-48">
                                <img v-if="article.featured_image_url" :src="article.featured_image_url"
                                    :alt="article.title" class="w-full h-full object-cover" />
                                <span
                                    class="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ article?.category?.name || 'Uncategorized' }}
                                </span>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-3 line-clamp-2">{{ article.title }}</h3>
                                <p class="text-gray-600 mb-6 line-clamp-3">{{ article.description }}</p>
                                <div class="flex justify-between items-center mb-6">
                                    <div class="flex items-center space-x-2">
                                        <img :src="article?.user?.profile_image" :alt="article?.user?.name"
                                            class="w-8 h-8 rounded-full object-cover" />
                                        <span class="text-sm font-medium">{{ article?.user?.name || 'Unknown' }}</span>
                                    </div>
                                    <time :datetime="article.created_at" class="text-xs text-gray-500">{{
                                        formatDate(article.created_at) }}</time>
                                </div>
                                <router-link :to="{ name: 'article-detail', params: { id: article.id } }"
                                    class="w-full bg-gray-800 text-white px-6 py-3 rounded-lg font-medium hover:bg-gray-900 transition duration-200">
                                    Read More
                                </router-link>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <!-- Newsletter -->
            <Newsletter ref="newsletterSection" v-model="emailInput" @subscribeToNewsletter="subscribeToNewsletter" />

            <!-- Popular Tags -->
            <PopularTags :popularTags="popularTags" />
        </div>
        <!-- Footer -->
        <PublicFooter :categories="categories" />
    </div>

</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import PublicNavbar from '../../components/PublicNavbar.vue';
import HeroSection from '../../components/HeroSection.vue';
import Newsletter from '../../components/Newsletter.vue';
import PopularTags from '../../components/PopularTags.vue';
import PublicFooter from '../../components/PublicFooter.vue';

const loading = ref(true);
const emailInput = ref('');
const selectedCategory = ref(null);

const articlesCount = ref(0);
const readersCount = ref(0);
const categoriesCount = ref(0);
const featuredArticle = ref(null);
const categories = ref([]);
const popularTags = ref([]);
const recentArticles = ref([]);
const newsletterSection = ref(null)

const scrollToNewsletter = () => {
    newsletterSection.value?.$el?.scrollIntoView({ behavior: 'smooth' })
}

const fetchHomeData = async () => {
    try {
        const response = await axios.get('/api/home-data');
        const data = response.data;

        articlesCount.value = data.articlesCount;
        readersCount.value = data.readersCount;
        categoriesCount.value = data.categoriesCount;
        featuredArticle.value = data.featuredArticle || null;
        categories.value = data.categories || [];
        popularTags.value = data.popularTags || [];
        recentArticles.value = data.recentArticles || [];
    } catch (error) {
        console.error("API Fetch Error:", error);
    } finally {
        loading.value = false;
    }
};

const filterByCategory = (categoryId) => {
    selectedCategory.value = categoryId;
};

// Filter articles by selected category
const filteredArticles = computed(() => {
    if (!selectedCategory.value) return recentArticles.value;
    return recentArticles.value.filter(article => article.category?.id === selectedCategory.value);
});

// Format date
const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

// Subscribe to newsletter
const subscribeToNewsletter = () => {
    alert(`Subscribed: ${emailInput.value}`);
};

onMounted(fetchHomeData);
</script>
