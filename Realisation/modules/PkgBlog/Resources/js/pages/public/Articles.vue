<template>
    <div class="bg-gray-50 min-h-screen">
      <PublicNavbar @search="handleSearch" :categories="categories"/>
      <!-- Hero Section -->
      <div class="relative bg-gradient-to-r from-blue-500 to-purple-500 overflow-hidden">
        <div class="absolute inset-0 opacity-20">
          <svg class="h-full w-full" viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
            <path d="M-86.96 -86.96L-48.23 -48.23L-86.96 -9.51L-48.23 -48.23L-9.51 -86.96L-48.23 -48.23L-9.51 -9.51L-48.23 -48.23L-9.51 -86.96" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round" class="text-white"></path>
            <path d="M-86.96 28.94L-48.23 67.66L-86.96 106.38L-48.23 67.66L-9.51 28.94L-48.23 67.66L-9.51 106.38L-48.23 67.66L-9.51 28.94" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round" class="text-white"></path>
            <path d="M28.94 -86.96L67.66 -48.23L28.94 -9.51L67.66 -48.23L106.38 -86.96L67.66 -48.23L106.38 -9.51L67.66 -48.23L106.38 -86.96" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round" class="text-white"></path>
            <path d="M28.94 28.94L67.66 67.66L28.94 106.38L67.66 67.66L106.38 28.94L67.66 67.66L106.38 106.38L67.66 67.66L106.38 28.94" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round" class="text-white"></path>
          </svg>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20 relative">
          <div class="text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl md:text-6xl">
              Our Articles
            </h1>
            <p class="mt-3 max-w-md mx-auto text-base text-indigo-100 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
              Discover the latest insights, tutorials, and stories from our team of experts.
            </p>
            
            <!-- Search Bar -->
            <!-- <div class="mt-8 max-w-xl mx-auto">
              <div class="relative flex items-center">
                <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Search articles..."
                  class="w-full px-5 py-3 text-base text-gray-900 placeholder-gray-500 border border-transparent rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                  @keyup.enter="searchArticles"
                />
                <button
                  @click="searchArticles"
                  class="absolute right-2 p-2 text-indigo-600 hover:text-indigo-800 focus:outline-none"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                  </svg>
                </button>
              </div>
            </div> -->
          </div>
        </div>
      </div>
  
      <!-- Main Content -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Filters -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 space-y-4 md:space-y-0">
          <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
            <!-- Category Filter -->
            <div class="relative">
              <select
                v-model="selectedCategory"
                @change="filterArticles"
                class="appearance-none pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
              >
                <option value="">All Categories</option>
                <option v-for="category in categories" :key="category.id" :value="category.id">
                  {{ category.name }}
                </option>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg> -->
              </div>
            </div>
  
            <!-- Tag Filter -->
            <div class="relative">
              <select
                v-model="selectedTag"
                @change="filterArticles"
                class="appearance-none pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
              >
                <option value="">All Tags</option>
                <option v-for="tag in tags" :key="tag.id" :value="tag.id">
                  {{ tag.name }}
                </option>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg> -->
              </div>
            </div>
          </div>
  
          <!-- View Toggle -->
          <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-500">View:</span>
            <button
              @click="viewMode = 'grid'"
              class="p-1.5 rounded-md"
              :class="viewMode === 'grid' ? 'bg-indigo-100 text-indigo-600' : 'text-gray-400 hover:text-gray-500'"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7"></rect>
                <rect x="14" y="3" width="7" height="7"></rect>
                <rect x="14" y="14" width="7" height="7"></rect>
                <rect x="3" y="14" width="7" height="7"></rect>
              </svg>
            </button>
            <button
              @click="viewMode = 'list'"
              class="p-1.5 rounded-md"
              :class="viewMode === 'list' ? 'bg-indigo-100 text-indigo-600' : 'text-gray-400 hover:text-gray-500'"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="8" y1="6" x2="21" y2="6"></line>
                <line x1="8" y1="12" x2="21" y2="12"></line>
                <line x1="8" y1="18" x2="21" y2="18"></line>
                <line x1="3" y1="6" x2="3.01" y2="6"></line>
                <line x1="3" y1="12" x2="3.01" y2="12"></line>
                <line x1="3" y1="18" x2="3.01" y2="18"></line>
              </svg>
            </button>
          </div>
        </div>
  
        <!-- Active Filters -->
        <div v-if="hasActiveFilters" class="mb-6 flex flex-wrap items-center gap-2">
          <span class="text-sm text-gray-500">Active filters:</span>
          <div v-if="selectedCategory" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
            <span>{{ getCategoryName(selectedCategory) }}</span>
            <button @click="clearCategoryFilter" class="ml-1.5 text-indigo-600 hover:text-indigo-800 focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
            </button>
          </div>
          <div v-if="selectedTag" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
            <span>{{ getTagName(selectedTag) }}</span>
            <button @click="clearTagFilter" class="ml-1.5 text-indigo-600 hover:text-indigo-800 focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
            </button>
          </div>
          <div v-if="searchQuery" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
            <span>Search: "{{ searchQuery }}"</span>
            <button @click="clearSearchQuery" class="ml-1.5 text-indigo-600 hover:text-indigo-800 focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
            </button>
          </div>
          <button 
            @click="clearAllFilters" 
            class="text-sm text-indigo-600 hover:text-indigo-800 font-medium ml-2"
          >
            Clear all
          </button>
        </div>
  
        <!-- Loading State -->
        <div v-if="loading" class="flex justify-center items-center py-20">
          <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <span class="ml-3 text-lg text-gray-600">Loading articles...</span>
        </div>
  
        <!-- Empty State -->
        <div v-else-if="articles.length === 0" class="text-center py-20">
          <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
            <polyline points="10 9 9 9 8 9"></polyline>
          </svg>
          <h3 class="mt-2 text-lg font-medium text-gray-900">No articles found</h3>
          <p class="mt-1 text-gray-500">
            {{ hasActiveFilters ? 'Try adjusting your filters or search query.' : 'Check back later for new content.' }}
          </p>
          <div v-if="hasActiveFilters" class="mt-6">
            <button
              @click="clearAllFilters"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Clear all filters
            </button>
          </div>
        </div>
  
        <!-- Articles Grid View -->
        <div v-else-if="viewMode === 'grid'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
          <article 
            v-for="article in articles" 
            :key="article.id" 
            class="flex flex-col overflow-hidden rounded-lg shadow-lg transition-all duration-300 hover:shadow-xl hover:translate-y-[-4px] bg-white"
          >
            <div class="flex-shrink-0">
              <router-link :to="{name: 'article-detail', params: {id: article.id}}" class="block">
                <img 
                  :src="article.featured_image_url || '/placeholder.jpg'" 
                  :alt="article.title"
                  class="h-48 w-full object-cover"
                />
              </router-link>
            </div>
            <div class="flex-1 p-6 flex flex-col justify-between">
              <div class="flex-1">
                <div class="flex items-center space-x-2 mb-2">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                    {{ article.category ? article.category.name : 'Uncategorized' }}
                  </span>
                  <span class="text-xs text-gray-500">
                    {{ formatDate(article.created_at) }}
                  </span>
                </div>
                <router-link :to="{name: 'article-detail', params: {id: article.id}}" class="block">
                  <h3 class="text-xl font-semibold text-gray-900 hover:text-indigo-600 transition-colors">
                    {{ article.title }}
                  </h3>
                  <p class="mt-3 text-base text-gray-500 line-clamp-3">
                    {{ article.description }}
                  </p>
                </router-link>
              </div>
              <div class="mt-6 flex items-center">
                <div class="flex-shrink-0">
                  <img 
                    :src="article.user && article.user.profile_image ? article.user.profile_image : '/default-avatar.jpg'" 
                    :alt="article.user ? article.user.name : 'Author'"
                    class="h-10 w-10 rounded-full object-cover"
                  />
                </div>
                <div class="ml-3">
                  <p class="text-sm font-medium text-gray-900">
                    {{ article.user ? article.user.name : 'Anonymous' }}
                  </p>
                  <div class="flex space-x-1 text-sm text-gray-500">
                    <span>{{ article.view_count || 0 }} views</span>
                  </div>
                </div>
              </div>
            </div>
          </article>
        </div>
  
        <!-- Articles List View -->
        <div v-else class="space-y-6">
          <article 
            v-for="article in articles" 
            :key="article.id" 
            class="flex flex-col sm:flex-row overflow-hidden rounded-lg shadow-lg transition-all duration-300 hover:shadow-xl hover:translate-y-[-4px] bg-white"
          >
            <div class="flex-shrink-0">
              <router-link :to="{name: 'article-detail', params: {id: article.id}}" class="block">
                <img 
                  :src="article.featured_image_url || '/placeholder.jpg'" 
                  :alt="article.title"
                  class="h-48 sm:h-full sm:w-48 object-cover"
                />
              </router-link >
            </div>
            <div class="flex-1 p-6 flex flex-col justify-between">
              <div class="flex-1">
                <div class="flex items-center space-x-2 mb-2">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                    {{ article.category ? article.category.name : 'Uncategorized' }}
                  </span>
                  <span class="text-xs text-gray-500">
                    {{ formatDate(article.created_at) }}
                  </span>
                </div>
                <router-link :to="{name: 'article-detail', params: {id: article.id}}" class="block">
                  <h3 class="text-xl font-semibold text-gray-900 hover:text-indigo-600 transition-colors">
                    {{ article.title }}
                  </h3>
                  <p class="mt-3 text-base text-gray-500">
                    {{ article.description }}
                  </p>
                </router-link>
              </div>
              <div class="mt-6 flex items-center">
                <div class="flex-shrink-0">
                  <img 
                    :src="article.user && article.user.profile_image ? article.user.profile_image : '/default-avatar.jpg'" 
                    :alt="article.user ? article.user.name : 'Author'"
                    class="h-10 w-10 rounded-full object-cover"
                  />
                </div>
                <div class="ml-3">
                  <p class="text-sm font-medium text-gray-900">
                    {{ article.user ? article.user.name : 'Anonymous' }}
                  </p>
                  <div class="flex space-x-1 text-sm text-gray-500">
                    <span>{{ article.view_count || 0 }} views</span>
                  </div>
                </div>
              </div>
            </div>
          </article>
        </div>
  
        <!-- Pagination -->
        <div v-if="articles.length > 0" class="mt-12 flex justify-center">
          <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
            <button
              @click="goToPreviousPage"
              :disabled="currentPage === 1"
              :class="[
                currentPage === 1 ? 'cursor-not-allowed text-gray-300' : 'text-gray-500 hover:bg-gray-50',
                'relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium'
              ]"
            >
              <span class="sr-only">Previous</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
              </svg>
            </button>
            
            <template v-for="page in totalPages" :key="page">
              <button
                v-if="shouldShowPage(page)"
                @click="goToPage(page)"
                :class="[
                  page === currentPage ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                  'relative inline-flex items-center px-4 py-2 border text-sm font-medium'
                ]"
              >
                {{ page }}
              </button>
              <span
                v-else-if="isEllipsis(page)"
                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700"
              >
                ...
              </span>
            </template>
            
            <button
              @click="goToNextPage"
              :disabled="currentPage === totalPages"
              :class="[
                currentPage === totalPages ? 'cursor-not-allowed text-gray-300' : 'text-gray-500 hover:bg-gray-50',
                'relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium'
              ]"
            >
              <span class="sr-only">Next</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
              </svg>
            </button>
          </nav>
        </div>
      </div>
      <PublicFooter :categories="categories" />
    </div>
  </template>
  
  <script setup>
  import { ref, computed, onMounted, watch } from 'vue';
  import { useRoute } from 'vue-router';
  import axios from 'axios';
  import PublicNavbar from '../../components/PublicNavbar.vue';
  import PublicFooter from '../../components/PublicFooter.vue';
  
  const route = useRoute();
  
  // State
  const articles = ref([]);
  const categories = ref([]);
  const tags = ref([]);
  const loading = ref(true);
  const viewMode = ref('grid');
  const currentPage = ref(1);
  const totalPages = ref(1);
  const totalArticles = ref(0);
  const perPage = ref(9);
  
  // Filters
  const searchQuery = ref('');
  const selectedCategory = ref('');
  const selectedTag = ref('');

  // Computed
  const hasActiveFilters = computed(() => {
    return searchQuery.value || selectedCategory.value || selectedTag.value;
  });
  
  // Methods
  const fetchArticles = async () => {
    loading.value = true;
    try {
      const params = {
        page: currentPage.value,
        per_page: perPage.value,
        category: selectedCategory.value,
        tag: selectedTag.value,
        search: searchQuery.value
      };
  
      const response = await axios.get('/api/articles', { params });
      
      // Check if the response has the expected structure
      if (response.data && response.data.articles) {
        if (response.data.articles.data) {
          articles.value = response.data.articles.data;
        } else {
          // Handle case where articles might be directly in the response
          articles.value = Array.isArray(response.data.articles) ? response.data.articles : [];
        }
        
        // Set pagination data if available
        totalPages.value = response.data.articles.last_page || 1;
        totalArticles.value = response.data.articles.total || articles.value.length;
        
        // Set categories and tags if available
        if (response.data.categories) {
          categories.value = response.data.categories;
        }
        
        if (response.data.tags) {
          tags.value = response.data.tags;
        }
      } else {
        console.error('Unexpected API response structure:', response.data);
        articles.value = [];
      }
    } catch (error) {
      console.error('Error fetching articles:', error);
      articles.value = [];
    } finally {
      loading.value = false;
    }
  };
  


// // Watch for route changes
// watch(() => route.query, (newQuery) => {
//   currentPage.value = parseInt(newQuery.page) || 1;
//   selectedCategory.value = newQuery.category || '';
//   selectedTag.value = newQuery.tag || '';
//   searchQuery.value = newQuery.search || '';
  
//   fetchArticles();
// }, { immediate: true });

  const filterArticles = () => {
    currentPage.value = 1;
    fetchArticles();
  };
  
  // const searchArticles = () => {
  //   currentPage.value = 1;
  //   fetchArticles();
  // };
  
  const clearCategoryFilter = () => {
    selectedCategory.value = '';
    filterArticles();
  };
  
  const clearTagFilter = () => {
    selectedTag.value = '';
    filterArticles();
  };
  
  const clearSearchQuery = () => {
    searchQuery.value = '';
    filterArticles();
  };
  
  const clearAllFilters = () => {
    selectedCategory.value = '';
    selectedTag.value = '';
    searchQuery.value = '';
    filterArticles();
  };
  
  const getCategoryName = (categoryId) => {
    const category = categories.value.find(c => c.id === parseInt(categoryId));
    return category ? category.name : '';
  };
  
  const getTagName = (tagId) => {
    const tag = tags.value.find(t => t.id === parseInt(tagId));
    return tag ? tag.name : '';
  };
  
  const formatDate = (dateString) => {
    if (!dateString) return '';
    
    try {
      const options = { year: 'numeric', month: 'short', day: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    } catch (e) {
      console.error('Error formatting date:', e);
      return dateString;
    }
  };
  
  // Pagination
  const goToPage = (page) => {
    currentPage.value = page;
    fetchArticles();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };
  
  const goToPreviousPage = () => {
    if (currentPage.value > 1) {
      goToPage(currentPage.value - 1);
    }
  };
  
  const goToNextPage = () => {
    if (currentPage.value < totalPages.value) {
      goToPage(currentPage.value + 1);
    }
  };
  
  const shouldShowPage = (page) => {
    // Always show first and last page
    if (page === 1 || page === totalPages.value) return true;
    
    // Show pages around current page
    if (Math.abs(page - currentPage.value) <= 1) return true;
    
    return false;
  };
  
  const isEllipsis = (page) => {
    if (page === 1 || page === totalPages.value) return false;
    
    // Show ellipsis after page 2 if current page > 4
    if (page === 2 && currentPage.value > 4) return true;
    
    // Show ellipsis before last page - 1 if current page < last page - 3
    if (page === totalPages.value - 1 && currentPage.value < totalPages.value - 3) return true;
    
    return false;
  };
  
  // Watch for route changes
  watch(() => route.query, (newQuery) => {
    currentPage.value = parseInt(newQuery.page) || 1;
    selectedCategory.value = newQuery.category || '';
    selectedTag.value = newQuery.tag || '';
    searchQuery.value = newQuery.search || '';
    
    fetchArticles();
  }, { immediate: true });
  
  // Initial fetch
  onMounted(() => {
    fetchArticles();
  });
  </script>
  
  <style scoped>
  /* Add any additional scoped styles here */
  .line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  </style>