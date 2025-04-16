<!-- <template>
    <Layout>
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <ArticleHeader :title="article.title" :category="article.category"
                :publishedDate="new Date(article.created_at).toLocaleDateString()" />

            <ArticleContent :content="article.content" />

            <TagsList :tags="article.tags" />

            <CommentsList :comments="comments" />

            <AddCommentForm />
        </div>
    </Layout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import Layout from '../../../components/Layout.vue';
import ArticleHeader from '../../../components/ArticleHeader.vue';
import ArticleContent from '../../../components/ArticleContent.vue';
import TagsList from '../../../components/TagsList.vue';
import CommentsList from '../../../components/CommentsList.vue';
import AddCommentForm from '../../../components/AddCommentForm.vue';

const router = useRouter();

// Data
const article = ref({});
const comments = ref([]);

// Fetch Article Data
const fetchArticleData = async (id) => {
    try {
        const response = await axios.get(`/api/articles/${id}`);
        article.value = response.data.article;
        comments.value = response.data.comments || [];
    } catch (error) {
        console.error('Error fetching article data:', error);
    }
};

// Fetch article when component is mounted
onMounted(() => {
    const articleId = router.currentRoute.value.params.id;
    fetchArticleData(articleId);
});
</script>

<style scoped>
/* Additional custom styles (if needed) */
</style> -->

<template>
    <Layout>
        <div class="max-w-5xl mx-auto">
            <!-- Admin Toolbar -->
            <div
                class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 mb-6 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center">
                    <button @click="router.back()" class="mr-4 text-gray-500 hover:text-gray-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                    </button>
                    <h1 class="text-xl font-bold text-gray-900">Article Management</h1>
                </div>

                <div class="flex items-center gap-3">
                    <span :class="[
                        'px-2.5 py-1 rounded-full text-xs font-medium',
                        article.status === 'published' ? 'bg-green-100 text-green-800' :
                            article.status === 'draft' ? 'bg-yellow-100 text-yellow-800' :
                                article.status === 'archived' ? 'bg-gray-100 text-gray-800' :
                                    'bg-blue-100 text-blue-800'
                    ]">
                        {{ article.status ? article.status.charAt(0).toUpperCase() + article.status.slice(1) :
                        'Loading...' }}
                    </span>

                    <button @click="editArticle"
                        class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded flex items-center transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                        Edit Article
                    </button>

                    <div class="relative" ref="actionsDropdownRef">
                        <button @click="toggleActionsDropdown"
                            class="p-1.5 rounded-md hover:bg-gray-100 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="12" cy="5" r="1"></circle>
                                <circle cx="12" cy="19" r="1"></circle>
                            </svg>
                        </button>

                        <div v-if="showActionsDropdown"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 border border-gray-100">
                            <div class="py-1">
                                <button v-if="article.status !== 'published'" @click="updateStatus('published')"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 12l2 2 4-4"></path>
                                        <circle cx="12" cy="12" r="10"></circle>
                                    </svg>
                                    Publish
                                </button>
                                <button v-if="article.status !== 'draft'" @click="updateStatus('draft')"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-yellow-500"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 19l7-7 3 3-7 7-3-3z"></path>
                                        <path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"></path>
                                        <path d="M2 2l7.586 7.586"></path>
                                        <circle cx="11" cy="11" r="2"></circle>
                                    </svg>
                                    Save as Draft
                                </button>
                                <button v-if="article.status !== 'archived'" @click="updateStatus('archived')"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="21 8 21 21 3 21 3 8"></polyline>
                                        <rect x="1" y="3" width="22" height="5"></rect>
                                        <line x1="10" y1="12" x2="14" y2="12"></line>
                                    </svg>
                                    Archive
                                </button>
                                <div class="border-t border-gray-100 my-1"></div>
                                <button @click="duplicateArticle"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                    </svg>
                                    Duplicate
                                </button>
                                <div class="border-t border-gray-100 my-1"></div>
                                <button @click="confirmDelete"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-red-500"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                        </path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Article Preview -->
            <div v-if="loading"
                class="bg-white rounded-lg shadow-sm border border-gray-100 p-8 mb-6 flex justify-center">
                <div class="animate-pulse flex flex-col w-full">
                    <div class="h-8 bg-gray-200 rounded w-3/4 mb-4"></div>
                    <div class="h-4 bg-gray-200 rounded w-1/2 mb-6"></div>
                    <div class="h-4 bg-gray-200 rounded w-full mb-2"></div>
                    <div class="h-4 bg-gray-200 rounded w-full mb-2"></div>
                    <div class="h-4 bg-gray-200 rounded w-3/4 mb-6"></div>
                </div>
            </div>

            <div v-else class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-6">
                <!-- Article Header -->
                <ArticleHeader :title="article.title" :author="article.user"
                    :date="article.published_at || article.created_at" :category="article.category"
                    :readTime="article.read_time || '5 min'" class="p-6 border-b border-gray-100" />

                <!-- Article Content -->
                <div class="p-6">
                    <ArticleContent :content="article.content" />
                </div>

                <!-- Article Tags -->
                <div class="px-6 pb-6">
                    <TagsList :tags="article.tags || []" />
                </div>
            </div>

            <!-- Article Metadata -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Stats Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Article Stats</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Views</span>
                            <span class="text-sm font-medium">{{ article.view_count || 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Comments</span>
                            <span class="text-sm font-medium">{{ comments.length }}</span>
                        </div>
                        <!-- <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Likes</span>
                            <span class="text-sm font-medium">{{ article.likes || 0 }}</span>
                        </div> -->
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Created</span>
                            <span class="text-sm font-medium">{{ formatDate(article.created_at) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Last Updated</span>
                            <span class="text-sm font-medium">{{ formatDate(article.updated_at) }}</span>
                        </div>
                    </div>
                </div>

                <!-- SEO Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">SEO</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-gray-600 block mb-1">Meta Title</span>
                            <p class="text-sm font-medium truncate">{{ article.meta_title || article.title || 'No meta title' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600 block mb-1">Meta Description</span>
                            <p class="text-sm line-clamp-2">{{ article.description || 'No meta description' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600 block mb-1">Slug</span>
                            <p class="text-sm font-medium truncate">{{ article.slug || 'No slug' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Featured Image</h3>
                    <div v-if="article.featured_image_url" class="aspect-video bg-gray-100 rounded-md overflow-hidden">
                        <img :src="article.featured_image_url" :alt="article.title" class="w-full h-full object-cover" />
                    </div>
                    <div v-else class="aspect-video bg-gray-100 rounded-md flex items-center justify-center">
                        <span class="text-sm text-gray-500">No featured image</span>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800">Comments ({{ comments.length }})</h3>
                    <!-- <div class="flex items-center gap-2">
                        <button @click="toggleCommentModeration"
                            class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9"></path>
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                            </svg>
                            {{ moderationMode ? 'Exit Moderation' : 'Moderate Comments' }}
                        </button>
                    </div> -->
                </div>

                <div class="p-5">
                    <CommentsList :comments="comments" />
                </div>
            </div>

            <!-- Related Articles -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Related Articles</h3>
                </div>

                <div class="p-5">
                    <div v-if="relatedArticles.length" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div v-for="relatedArticle in relatedArticles" :key="relatedArticle.id"
                            class="flex items-start space-x-3">
                            <div class="w-16 h-16 bg-gray-100 rounded-md flex-shrink-0 overflow-hidden">
                                <img v-if="relatedArticle.featured_image_url" :src="relatedArticle.featured_image_url"
                                    :alt="relatedArticle.title" class="w-full h-full object-cover" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-medium text-gray-900 truncate">{{ relatedArticle.title }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ formatDate(relatedArticle.published_at ||
                                    relatedArticle.created_at) }}</p>
                                <div class="mt-2">
                                    <a :href="`/admin/articles/${relatedArticle.id}`"
                                        class="text-xs text-blue-600 hover:text-blue-800">View Article</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-sm text-gray-500 text-center py-4">
                        No related articles found
                    </div>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div v-if="showDeleteModal"
                class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-md overflow-hidden">
                    <div class="p-5">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete Article</h3>
                        <p class="text-gray-600">Are you sure you want to delete this article? This action cannot be
                            undone.</p>
                    </div>
                    <div class="p-4 bg-gray-50 flex justify-end gap-3">
                        <button @click="showDeleteModal = false"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 text-sm font-medium transition-colors">
                            Cancel
                        </button>
                        <button @click="deleteArticle"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm font-medium transition-colors flex items-center">
                            <svg v-if="deletingArticle" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Delete Article
                        </button>
                    </div>
                </div>
            </div>

            <!-- Status Update Toast -->
            <div v-if="showStatusToast"
                class="fixed bottom-4 right-4 bg-white rounded-lg shadow-lg border border-gray-100 p-4 flex items-start max-w-sm z-50">
                <div :class="[
                    'flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center mr-3',
                    statusToastType === 'success' ? 'bg-green-100 text-green-500' :
                        statusToastType === 'error' ? 'bg-red-100 text-red-500' :
                            'bg-blue-100 text-blue-500'
                ]">
                    <svg v-if="statusToastType === 'success'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <svg v-else-if="statusToastType === 'error'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-900">{{ statusToastTitle }}</h4>
                    <p class="text-sm text-gray-600 mt-1">{{ statusToastMessage }}</p>
                </div>
                <button @click="showStatusToast = false" class="ml-auto text-gray-400 hover:text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, computed } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import Layout from '../../../components/Layout.vue';
import ArticleHeader from '../../../components/ArticleHeader.vue';
import ArticleContent from '../../../components/ArticleContent.vue';
import TagsList from '../../../components/TagsList.vue';
import CommentsList from '../../../components/CommentsList.vue';

const router = useRouter();

// Data
const article = ref({});
const comments = ref([]);
const relatedArticles = ref([]);
const loading = ref(true);

// UI State
const showActionsDropdown = ref(false);
const actionsDropdownRef = ref(null);
const moderationMode = ref(false);
const showDeleteModal = ref(false);
const deletingArticle = ref(false);

// Toast State
const showStatusToast = ref(false);
const statusToastType = ref('success');
const statusToastTitle = ref('');
const statusToastMessage = ref('');

// Computed
const hasErrors = computed(() => Object.keys(errors.value).length > 0);
const errors = ref({});

// Fetch Article Data
const fetchArticleData = async (id) => {
    loading.value = true;
    try {
        const response = await axios.get(`/api/articles/${id}`);
        article.value = response.data.article;
        relatedArticles.value = response.data.relatedArticles || [];
        comments.value = response.data.article.comments || [];
    } catch (error) {
        console.error('Error fetching article data:', error);
        showToast('error', 'Error', 'Failed to load article data');
    } finally {
        loading.value = false;
    }
};

// Format Date
const formatDate = (dateString) => {
    if (!dateString) return 'N/A';

    const date = new Date(dateString);
    return new Intl.DateTimeFormat('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    }).format(date);
};

// Actions Dropdown
const toggleActionsDropdown = () => {
    showActionsDropdown.value = !showActionsDropdown.value;
};

// Close dropdown when clicking outside
const handleClickOutside = (event) => {
    if (actionsDropdownRef.value && !actionsDropdownRef.value.contains(event.target)) {
        showActionsDropdown.value = false;
    }
};

// Edit Article
const editArticle = () => {
    router.push(`/articles/${article.value.id}/edit`);
};

// Update Article Status
const updateStatus = async (status) => {
    showActionsDropdown.value = false;

    try {
        await axios.patch(`/api/articles/${article.value.id}/status`, { status });

        // Update local state
        article.value.status = status;

        // Show success toast
        showToast(
            'success',
            'Status Updated',
            `Article has been ${status === 'published' ? 'published' : status === 'draft' ? 'saved as draft' : 'archived'}`
        );
    } catch (error) {
        console.error('Error updating article status:', error);
        showToast('error', 'Error', 'Failed to update article status');
    }
};

// Duplicate Article
const duplicateArticle = async () => {
    showActionsDropdown.value = false;

    try {
        const response = await axios.post(`/api/articles/${article.value.id}/duplicate`);

        // Show success toast
        showToast('success', 'Article Duplicated', 'A copy of this article has been created');

        // Navigate to the new article
        setTimeout(() => {
            router.push(`/admin/articles/${response.data.article.id}`);
        }, 1500);
    } catch (error) {
        console.error('Error duplicating article:', error);
        showToast('error', 'Error', 'Failed to duplicate article');
    }
};

// Delete Article
const confirmDelete = () => {
    showActionsDropdown.value = false;
    showDeleteModal.value = true;
};

const deleteArticle = async () => {
    deletingArticle.value = true;

    try {
        await axios.delete(`/api/articles/${article.value.id}`);

        // Show success toast
        showToast('success', 'Article Deleted', 'The article has been permanently deleted');

        // Navigate back to articles list
        setTimeout(() => {
            router.push('/admin/articles');
        }, 1500);
    } catch (error) {
        console.error('Error deleting article:', error);
        showToast('error', 'Error', 'Failed to delete article');
        showDeleteModal.value = false;
    } finally {
        deletingArticle.value = false;
    }
};

// Comment Moderation
const toggleCommentModeration = () => {
    moderationMode.value = !moderationMode.value;
};

// const approveComment = async (commentId) => {
//     try {
//         await axios.patch(`/api/comments/${commentId}/approve`);

//         // Update local state
//         const commentIndex = comments.value.findIndex(c => c.id === commentId);
//         if (commentIndex !== -1) {
//             comments.value[commentIndex].status = 'approved';
//         }

//         showToast('success', 'Comment Approved', 'The comment is now visible to all users');
//     } catch (error) {
//         console.error('Error approving comment:', error);
//         showToast('error', 'Error', 'Failed to approve comment');
//     }
// };

// const rejectComment = async (commentId) => {
//     try {
//         await axios.patch(`/api/comments/${commentId}/reject`);

//         // Update local state
//         const commentIndex = comments.value.findIndex(c => c.id === commentId);
//         if (commentIndex !== -1) {
//             comments.value[commentIndex].status = 'rejected';
//         }

//         showToast('success', 'Comment Rejected', 'The comment has been rejected');
//     } catch (error) {
//         console.error('Error rejecting comment:', error);
//         showToast('error', 'Error', 'Failed to reject comment');
//     }
// };

// const deleteComment = async (commentId) => {
//     try {
//         await axios.delete(`/api/comments/${commentId}`);

//         // Update local state
//         comments.value = comments.value.filter(c => c.id !== commentId);

//         showToast('success', 'Comment Deleted', 'The comment has been permanently deleted');
//     } catch (error) {
//         console.error('Error deleting comment:', error);
//         showToast('error', 'Error', 'Failed to delete comment');
//     }
// };

// Toast Helper
const showToast = (type, title, message) => {
    statusToastType.value = type;
    statusToastTitle.value = title;
    statusToastMessage.value = message;
    showStatusToast.value = true;

    // Auto-hide toast after 5 seconds
    setTimeout(() => {
        showStatusToast.value = false;
    }, 5000);
};

// Fetch article when component is mounted
onMounted(() => {
    const articleId = router.currentRoute.value.params.id;
    fetchArticleData(articleId);

    // Add event listener for closing dropdown
    document.addEventListener('click', handleClickOutside);
});

// Clean up event listeners
onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>

<style scoped>
/* Transitions for toast */
.toast-enter-active,
.toast-leave-active {
    transition: opacity 0.3s, transform 0.3s;
}

.toast-enter-from,
.toast-leave-to {
    opacity: 0;
    transform: translateY(20px);
}
</style>