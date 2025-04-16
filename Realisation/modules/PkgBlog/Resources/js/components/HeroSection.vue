<script setup>
import { defineProps } from 'vue';

defineProps({
    featuredArticle: Object,
    formatDate: Function,
    articlesCount: Number,
    readersCount: Number,
    categoriesCount: Number,
});

const emit = defineEmits(['scrollToNewsletter']);

</script>

<template>
    <section class="relative">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
            <div class="absolute inset-0 bg-gradient-to-r from-gray-900/80 to-gray-900/60"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="flex flex-col lg:flex-row lg:items-center lg:space-x-16">
                <div class="text-white max-w-2xl">
                    <span
                        class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-md rounded-full text-sm font-semibold mb-6 border border-white/20">Featured
                        Publication</span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                        Discover Insights That
                        <span class="bg-gradient-to-r from-blue-500 to-purple-500 bg-clip-text text-transparent">Shape
                            Our World</span>
                    </h1>
                    <p class="text-lg md:text-xl opacity-90 mb-10 leading-relaxed">
                        Exploring ideas through thoughtful analysis and engaging stories from leading thinkers and
                        creators.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <router-link :to="{ name: 'articles' }"
                            class="flex items-center bg-gradient-to-r from-blue-500 to-purple-500 text-white px-7 py-3 rounded-full font-semibold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition duration-300">
                            <span>Explore Articles</span>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 ml-2 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </router-link>
                        <button @click="emit('scrollToNewsletter')"
                            class="px-7 py-3 rounded-full font-semibold border-2 border-white/50 text-white hover:bg-white/10 hover:border-white transition duration-300">
                            Subscribe
                        </button>
                    </div>
                </div>

                <div class="mt-12 lg:mt-0">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-2xl">
                        <div class="flex flex-col sm:flex-row">
                            <div class="p-6 flex-1">
                                <span
                                    class="inline-block px-3 py-1 text-xs font-semibold bg-indigo-100 text-indigo-800 rounded-full mb-3">Latest</span>
                                <router-link :to="{ name: 'article-detail', params: { id: featuredArticle.id } }"
                                    class="text-lg font-bold text-gray-900 mb-4 line-clamp-2">{{ featuredArticle.title
                                    }}</router-link>
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    <div class="flex items-center space-x-2">
                                        <img :src="featuredArticle.user?.profile_image"
                                            :alt="featuredArticle.user?.name"
                                            class="w-6 h-6 rounded-full object-cover" />
                                        <span>{{ featuredArticle.user?.name }}</span>
                                    </div>
                                    <span class="ms-3">{{ formatDate(featuredArticle.created_at) }}</span>
                                </div>
                            </div>
                            <div class="sm:w-44 h-32 sm:h-auto">
                                <img v-if="featuredArticle.featured_image_url" :src="featuredArticle.featured_image_url"
                                    :alt="featuredArticle.title" class="w-full h-full object-cover" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="max-w-3xl mx-auto -mb-16 mt-12 relative z-10">
                <div class="bg-white rounded-2xl shadow-xl flex justify-around py-6 px-4">
                    <div class="text-center">
                        <span class="block text-3xl font-extrabold text-gray-900">{{ articlesCount }}+</span>
                        <span class="text-sm text-gray-500 font-medium">Articles</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-3xl font-extrabold text-gray-900">{{ readersCount }}+</span>
                        <span class="text-sm text-gray-500 font-medium">Readers</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-3xl font-extrabold text-gray-900">{{ categoriesCount }}</span>
                        <span class="text-sm text-gray-500 font-medium">Categories</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>