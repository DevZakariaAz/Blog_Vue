<template>
    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="col-span-1">
                    <h2 class="text-2xl font-bold mb-4">Insights Blog</h2>
                    <p class="text-gray-400 mb-6">Exploring ideas that shape our world</p>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                                </path>
                            </svg>
                        </a>
                        <a href="#"
                            class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>
                        </a>
                        <a href="#"
                            class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        </a>
                        <a href="#"
                            class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z">
                                </path>
                                <rect x="2" y="9" width="4" height="12"></rect>
                                <circle cx="4" cy="4" r="2"></circle>
                            </svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-5">Navigation</h3>
                    <ul class="space-y-3">
                        <li><router-link :to="{ name: 'home' }"
                                class="text-gray-400 hover:text-white transition duration-200">Home</router-link></li>
                        <li><router-link :to="{ name: 'articles' }"
                                class="text-gray-400 hover:text-white transition duration-200">Articles</router-link>
                        </li>
                        <li><router-link class="text-gray-400 hover:text-white transition duration-200">About
                                Us</router-link>
                        </li>
                        <li><router-link
                                class="text-gray-400 hover:text-white transition duration-200">Contact</router-link>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-5">Categories</h3>
                    <ul class="space-y-3">
                        <li v-for="category in categories" :key="category.id"
                            class="text-gray-400 hover:text-white transition duration-200">
                            {{ category.name }}
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-5">Legal</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Privacy
                                Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Terms of
                                Service</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Cookie
                                Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/10 mt-12 pt-8 text-center">
                <p class="text-gray-500">© {{ currentYear }} Insights Blog. All rights reserved.</p>
            </div>
        </div>
    </footer>
</template>
<script setup>
import { computed } from 'vue';
import { defineProps } from 'vue';

defineProps({
    categories: Array,
});
const currentYear = computed(() => new Date().getFullYear());
</script>