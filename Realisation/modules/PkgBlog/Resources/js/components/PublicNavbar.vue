<template>
    <nav class="sticky top-0 z-50 bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <router-link :to="{ name: 'home' }" class="text-2xl font-extrabold text-gray-900 tracking-tight">
                    Insights
                </router-link>
            </div>

            <!-- Simple Search -->
            <div class="hidden md:block flex-1 max-w-md mx-8 relative">
                <div class="flex items-center bg-gray-100 rounded-full px-4 py-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input v-model="searchQuery" type="text" placeholder="Search articles..." @input="handleSearchInput"
                        class="bg-transparent border-none w-full focus:outline-none text-sm" />
                </div>

                <!-- Search results dropdown -->
                <div v-if="showResults && searchResults.length"
                    class="absolute mt-1 w-full bg-white border rounded shadow z-50 max-h-60 overflow-y-auto">
                    <div v-for="result in searchResults" :key="result.id" @click="goToArticle(result.id)"
                        class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm text-gray-700">
                        <img :src="result.featured_image_url" alt="Article Image"
                            class="w-10 h-10 object-cover rounded" />
                        <span>{{ result.title }}</span>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <button class="lg:hidden" @click="toggleMobileMenu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-8">
                <router-link v-for="link in mainLinks" :key="link.name" :to="link.to"
                    class="text-gray-500 hover:text-gray-900 font-medium"
                    :class="{ 'text-gray-900 font-semibold': isActive(link.to) }">
                    {{ link.name }}
                </router-link>

                <!-- Categories Dropdown -->
                <div class="relative">
                    <button @click="showCategoryDropdown = !showCategoryDropdown"
                        class="text-gray-500 hover:text-gray-900 font-medium flex items-center gap-1">
                        Categories
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div v-if="showCategoryDropdown"
                        class="absolute top-full mt-2 w-48 bg-white border rounded shadow-md z-50">
                        <router-link v-for="category in categories" :key="category.id"
                            :to="{ name: 'articles', query: { category: category.id } }"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                            {{ category.name }}
                        </router-link>
                    </div>
                </div>

                <!-- Auth Buttons -->
                <div v-if="!authStore.isLoggedIn" class="flex items-center space-x-4">
                    <a href="/login" class="text-gray-600 hover:text-gray-900 font-medium">Sign In</a>
                    <a href="/register"
                        class="bg-gray-800 text-white px-5 py-2 rounded-full font-semibold hover:bg-gray-900">
                        Sign Up
                    </a>
                </div>

                <!-- User Profile -->
                <div v-else class="relative">
                    <button @click="toggleDropdown" class="flex items-center">
                        <img v-if="authStore.user" :src="authStore.user.profile_image" class="w-8 h-8 rounded-full" />
                    </button>
                    <div v-if="isDropdownOpen"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        <a href="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                        <button @click="logout"
                            class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                            Log Out
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div v-if="isMobileMenuOpen" class="lg:hidden bg-white shadow-md py-4 px-4">
            <div class="space-y-4">
                <router-link v-for="link in mainLinks" :key="link.name" :to="link.to"
                    class="block text-gray-500 hover:text-gray-900 font-medium"
                    :class="{ 'text-gray-900 font-semibold': isActive(link.to) }">
                    {{ link.name }}
                </router-link>

                <div v-if="categories.length" class="pt-2">
                    <div class="text-gray-500 font-medium">Categories</div>
                    <div class="pl-4 mt-2 space-y-2">
                        <router-link v-for="category in categories" :key="category.id"
                            :to="{ name: 'articles', query: { category: category.id } }"
                            class="block text-gray-500 hover:text-gray-900">
                            {{ category.name }}
                        </router-link>
                    </div>
                </div>

                <div v-if="!authStore.isLoggedIn" class="pt-4 space-y-3 border-t">
                    <a href="/login" class="block text-gray-600 hover:text-gray-900">Sign In</a>
                    <a href="/register" class="block bg-gray-800 text-white px-5 py-2 rounded-full text-center">
                        Sign Up
                    </a>
                </div>

                <div v-else class="pt-4 space-y-3 border-t">
                    <div class="text-gray-600">Hello, {{ authStore.user.name }}</div>
                    <a href="/profile" class="block text-gray-600 hover:text-gray-900">Profile</a>
                    <button @click="logout" class="text-gray-600 hover:text-gray-900">Logout</button>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const props = defineProps({
    categories: {
        type: Array,
        default: () => []
    }
});

const route = useRoute();
const router = useRouter();
const authStore = useAuthStore();

// State
const searchQuery = ref('');
const showCategoryDropdown = ref(false);
const isDropdownOpen = ref(false);
const isMobileMenuOpen = ref(false);
const searchResults = ref([]);
const showResults = ref(false);

const goToArticle = (id) => {
    router.push({ name: 'article-detail', params: { id } });
    searchQuery.value = '';
    showResults.value = false;
};

let searchTimeout = null;

const handleSearchInput = () => {
    clearTimeout(searchTimeout);
    
    // Immediately hide results if query is empty
    if (searchQuery.value.trim() === '') {
        searchResults.value = [];
        showResults.value = false;
        return;
    }

    // Only search after typing stops for 300ms
    searchTimeout = setTimeout(() => {
        performSearch();
    }, 300);
};

const performSearch = async () => {
    if (searchQuery.value.trim().length < 2) {
        searchResults.value = [];
        showResults.value = false;
        return;
    }

    try {
        const { data } = await axios.get('/api/articles/search', {
            params: { query: searchQuery.value }
        });
        searchResults.value = data;
        showResults.value = true;
    } catch (err) {
        console.error(err);
        searchResults.value = [];
        showResults.value = false;
    }
};

// Clear results when clicking outside
const handleClickOutside = (event) => {
    const searchContainer = document.querySelector('.search-container');
    if (searchContainer && !searchContainer.contains(event.target)) {
        showResults.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
    clearTimeout(searchTimeout);
});




// Menu links
const mainLinks = [
    { name: 'Home', to: { name: 'home' } },
    { name: 'Articles', to: { name: 'articles' } },
    { name: 'About', to: { path: '/about' } },
    { name: 'Contact', to: { path: '/contact' } }
];

// Toggle mobile menu
const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};

const logout = async () => {
    try {
        await axios.post('/logout');
        authStore.logout();
        window.location.href = '/';
    } catch (error) {
        console.error('Logout failed:', error);
    }
};

const isActive = (to) => {
    if (typeof to === 'string') return route.path === to;
    if (to.name) return route.name === to.name;
    return route.path === to.path;
};

</script>