<template>
    <div class="min-h-screen bg-gray-50">
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
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Error Loading Article</h2>
                <p class="text-gray-600 mb-4">{{ error }}</p>
                <button @click="fetchArticle"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    Try Again
                </button>
            </div>
        </div>

        <!-- Article Content -->
        <div v-else>
            <!-- Article Hero Section -->
            <div class="relative w-full h-[60vh] md:h-[70vh]">
                <div class="absolute inset-0 bg-cover bg-center"
                    :style="{ backgroundImage: `url('${article.featured_image_url ? article.featured_image_url : 'default.jpg'}')` }">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/70 to-transparent"></div>
                </div>
                <div class="absolute inset-0 flex items-end">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8 pb-16 md:pb-24">
                        <div class="max-w-3xl">
                            <div class="flex items-center space-x-2 mb-4">
                                <span
                                    class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-xs font-semibold rounded-full">
                                    {{ article.category.name }}
                                </span>
                                <span class="text-white/80 text-sm">{{ formatDate(article.created_at) }}</span>
                            </div>
                            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight mb-4">
                                {{ article.title }}
                            </h1>
                            <div class="flex items-center">
                                <img :src="article.user.profile_image" :alt="article.user.name"
                                    class="w-10 h-10 rounded-full object-cover border-2 border-white" />
                                <div class="ml-3">
                                    <p class="text-white font-medium">{{ article.user.name }}</p>
                                    <div class="flex items-center text-white/70 text-sm">
                                        <!-- <span>{{ article.readingTime }} min read</span>
                                        <span class="mx-2">•</span> -->
                                        <span>{{ article.view_count }} views</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="flex flex-col lg:flex-row lg:space-x-12">
                    <!-- Main Content -->
                    <div class="lg:w-2/3">
                        <div class="bg-white rounded-xl shadow-sm p-6 md:p-10">
                            <!-- Article Body -->
                            <div class="prose prose-lg max-w-none">
                                <!-- <p class="text-xl text-gray-700 mb-8 leading-relaxed">
                                    {{ article.excerpt }}
                                </p> -->

                                <div v-html="article.content"></div>
                            </div>

                            <!-- Tags -->
                            <div class="mt-10 pt-8 border-t border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Tags</h3>
                                <div class="flex flex-wrap gap-2">
                                    <a v-for="(tag) in article.tags" :key="tag.id" href="#"
                                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-full text-sm text-gray-700 transition duration-200">
                                        {{ tag.name }}
                                    </a>
                                </div>
                            </div>

                            <!-- Share -->
                            <div class="mt-8 pt-8 border-t border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Share this article</h3>
                                <div class="flex space-x-4">
                                    <button @click="shareArticle('facebook')"
                                        class="p-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button @click="shareArticle('twitter')"
                                        class="p-2 bg-sky-500 text-white rounded-full hover:bg-sky-600 transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button @click="shareArticle('linkedin')"
                                        class="p-2 bg-blue-800 text-white rounded-full hover:bg-blue-900 transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z">
                                            </path>
                                            <rect x="2" y="9" width="4" height="12"></rect>
                                            <circle cx="4" cy="4" r="2"></circle>
                                        </svg>
                                    </button>
                                    <button @click="copyArticleLink"
                                        class="p-2 bg-green-600 text-white rounded-full hover:bg-green-700 transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                                            <polyline points="16 6 12 2 8 6"></polyline>
                                            <line x1="12" y1="2" x2="12" y2="15"></line>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Author Bio -->
                            <!-- <div class="mt-10 pt-8 border-t border-gray-200">
                                <div
                                    class="flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6 bg-gray-50 p-6 rounded-xl">
                                    <img :src="article.user.profile_image" :alt="article.user.name"
                                        class="w-20 h-20 rounded-full object-cover border-2 border-white shadow-md" />
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-900">{{ article.user.name }}</h3>
                                        <p class="text-gray-600 mb-3">{{ article.user.role }}</p>
                                        <p class="text-gray-700">{{ article.user.bio }}</p>
                                        <div class="mt-4 flex space-x-3">
                                            <a :href="`/user/${article.user.id}/articles`"
                                                class="text-blue-600 hover:text-blue-800 font-medium">View all
                                                articles</a>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <!-- Comments -->
                            <div class="mt-10 pt-8 border-t border-gray-200">
                                <h3 id="comments-heading" class="text-xl font-semibold text-gray-900 mb-6">
                                    Comments ({{ article.comments.length }})
                                </h3>

                                <!-- Comment Form -->
                                <div class="mb-8">
                                    <template v-if="authStore.user">
                                        <form @submit.prevent="addComment(null)" aria-labelledby="comment-form-heading">
                                            <h4 id="comment-form-heading" class="sr-only">Add a comment</h4>
                                            <div class="flex items-start gap-4">
                                                <img :src="authStore.user.profile_image" :alt="authStore.user.name"
                                                    class="w-10 h-10 rounded-full object-cover flex-shrink-0" />
                                                <div class="flex-1 space-y-2">
                                                    <label for="comment-textarea" class="sr-only">Your comment</label>
                                                    <textarea id="comment-textarea" v-model="form.content"
                                                        placeholder="Add a comment..."
                                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                        rows="3" required aria-describedby="char-counter"
                                                        :maxlength="1000"></textarea>

                                                    <div v-if="form.content.length > 900" id="char-counter"
                                                        class="text-sm text-gray-500">
                                                        {{ 1000 - form.content.length }} characters remaining
                                                    </div>

                                                    <div class="flex justify-end">
                                                        <button type="submit"
                                                            :disabled="commentSubmitting || form.content.trim() === ''"
                                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                                            <span v-if="commentSubmitting">Posting...</span>
                                                            <span v-else>Post Comment</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </template>
                                    <template v-else>
                                        <p class="text-gray-600">
                                            Please <a href="/login"
                                                class="text-blue-600 hover:text-blue-800 underline">log in</a> to
                                            comment.
                                        </p>
                                    </template>
                                </div>

                                <!-- Comments List -->
                                <div v-if="article.comments.length > 0" class="space-y-6">
                                    <div v-for="(comment) in visibleComments" :key="comment.id"
                                        class="flex gap-4" :aria-labelledby="'comment-heading-' + comment.id">
                                        <img :src="comment.user.profile_image" :alt="comment.user.name"
                                            class="w-10 h-10 rounded-full object-cover flex-shrink-0" />

                                        <div class="flex-1">
                                            <div class="bg-gray-50 p-4 rounded-lg">
                                                <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                                    <h4 :id="'comment-heading-' + comment.id"
                                                        class="font-medium text-gray-900">
                                                        {{ comment.user.name }}
                                                    </h4>
                                                    <time :datetime="comment.created_at" class="text-sm text-gray-500">
                                                        {{ formatDate(comment.created_at) }}
                                                    </time>
                                                </div>
                                                <p class="text-gray-700 whitespace-pre-wrap">{{ comment.content }}</p>
                                            </div>

                                            <!-- Comment Actions -->
                                            <div v-if="authStore.isLoggedIn" class="mt-2 ml-2 flex gap-4 text-sm">
                                                <button
                                                    @click="replyingTo = replyingTo === comment.id ? null : comment.id"
                                                    class="text-gray-500 hover:text-blue-600"
                                                    :aria-expanded="replyingTo === comment.id ? 'true' : 'false'"
                                                    :aria-controls="'reply-form-' + comment.id">
                                                    {{ replyingTo === comment.id ? 'Cancel Reply' : 'Reply' }}
                                                </button>
                                            </div>

                                            <!-- Reply Form -->
                                            <div v-if="replyingTo === comment.id" :id="'reply-form-' + comment.id"
                                                class="mt-4 ml-14">
                                                <form @submit.prevent="addComment(comment.id)" class="space-y-2">
                                                    <label :for="'reply-textarea-' + comment.id" class="sr-only">Your
                                                        reply</label>
                                                    <textarea :id="'reply-textarea-' + comment.id"
                                                        v-model="replyContent" placeholder="Write your reply..."
                                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500"
                                                        rows="2" required></textarea>
                                                    <div class="flex justify-end gap-2">
                                                        <button type="button" @click="replyingTo = null"
                                                            class="px-3 py-1.5 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                                            Cancel
                                                        </button>
                                                        <button type="submit"
                                                            class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700">
                                                            Post Reply
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Replies List -->
                                            <div v-if="comment.replies.length" class="ml-14 mt-4 space-y-4">
                                                <div v-for="reply in comment.replies" :key="reply.id" class="flex gap-3"
                                                    :aria-labelledby="'reply-heading-' + reply.id">
                                                    <img :src="reply.user.profile_image" :alt="reply.user.name"
                                                        class="w-8 h-8 rounded-full object-cover flex-shrink-0" />
                                                    <div class="flex-1 bg-gray-100 p-3 rounded-lg">
                                                        <div class="flex flex-wrap justify-between gap-2 mb-1">
                                                            <h5 :id="'reply-heading-' + reply.id"
                                                                class="font-medium text-gray-800">
                                                                {{ reply.user.name }}
                                                            </h5>
                                                            <time :datetime="reply.created_at"
                                                                class="text-sm text-gray-500">
                                                                {{ formatDate(reply.created_at) }}
                                                            </time>
                                                        </div>
                                                        <p class="text-gray-700 whitespace-pre-wrap">{{ reply.content }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Show More Comments Button -->
                                    <div v-if="article.comments.length > visibleCount" class="text-center mt-6">
                                        <button @click="showMoreComments"
                                            class="px-4 py-2 text-sm font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition-colors">
                                            Show More Comments
                                        </button>
                                    </div>
                                </div>

                                <!-- Empty State -->
                                <div v-else class="text-center py-8">
                                    <p class="text-gray-500">No comments yet. Be the first to share your thoughts!</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:w-1/3 mt-10 lg:mt-0">
                        <!-- Newsletter -->
                        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Subscribe to our Newsletter</h3>
                            <p class="text-gray-600 mb-4">Get the latest articles and insights straight to your inbox.
                            </p>
                            <form @submit.prevent="subscribeToNewsletter" class="space-y-3">
                                <input type="email" v-model="emailInput" placeholder="Your email address"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required />
                                <button type="submit" :disabled="subscribeSubmitting"
                                    class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span v-if="subscribeSubmitting">Subscribing...</span>
                                    <span v-else>Subscribe</span>
                                </button>
                            </form>
                            <p class="mt-3 text-xs text-gray-500">We respect your privacy. Unsubscribe at any time.</p>
                        </div>

                        <!-- Related Articles -->
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Related Articles</h3>

                            <!-- Loading State for Related Articles -->
                            <div v-if="relatedLoading" class="py-8 flex justify-center">
                                <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500">
                                </div>
                            </div>

                            <!-- Related Articles Content -->
                            <div v-else-if="relatedArticles.length > 0" class="space-y-6">
                                <div v-for="(relatedArticle, index) in relatedArticles" :key="index"
                                    class="flex space-x-4">
                                    <img v-if="relatedArticle.featured_image_url"
                                        :src="relatedArticle.featured_image_url" :alt="relatedArticle.title"
                                        class="w-20 h-20 object-cover rounded-lg" />
                                    <div>
                                        <h4 class="font-medium text-gray-900 line-clamp-2 mb-1">
                                            <a :href="`/articles/${relatedArticle.id}`" class="hover:text-blue-600">{{
                                                relatedArticle.title }}</a>
                                        </h4>
                                        <p class="text-sm text-gray-500">{{ formatDate(relatedArticle.created_at) }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- No Related Articles -->
                            <div v-else class="py-8 text-center">
                                <p class="text-gray-500">No related articles found.</p>
                            </div>

                            <div class="mt-6 pt-4 border-t border-gray-200 text-center">
                                <a href="/articles" class="text-blue-600 hover:text-blue-800 font-medium">View All
                                    Articles</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <PublicFooter :categories="categories" />
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import PublicNavbar from '../../components/PublicNavbar.vue';
import PublicFooter from '../../components/PublicFooter.vue';
import { useAuthStore } from "@/stores/auth";

const authStore = useAuthStore();
const route = useRoute();
const articleId = route.params.id;

// State variables
const article = ref({});
const relatedArticles = ref([]);
const loading = ref(true);
const relatedLoading = ref(true);
const error = ref(null);
const emailInput = ref('');
const commentSubmitting = ref(false);
const subscribeSubmitting = ref(false);
const visibleCount = ref(2);
const replyingTo = ref(null);
const replyContent = ref('');
const categories = ref([]);

const form = ref({
    content: '',
});

const structureComments = (comments) => {
    const commentMap = {};
    const topLevelComments = [];

    // First pass: create a map of all comments
    comments.forEach(comment => {
        comment.replies = [];
        commentMap[comment.id] = comment;
    });

    // Second pass: build the hierarchy
    comments.forEach(comment => {
        if (comment.parent_id && commentMap[comment.parent_id]) {
            commentMap[comment.parent_id].replies.push(comment);
        } else {
            topLevelComments.push(comment);
        }
    });

    return topLevelComments;
};

// Fetch article data
const fetchArticle = async () => {
    loading.value = true;
    try {
        const response = await axios.get(`/api/articles/${articleId}`);
        article.value = response.data.article;
        article.value.comments = structureComments(article.value.comments);
        relatedArticles.value = response.data.relatedArticles;
        categories.value = response.data.categories;
    } catch (err) {
        console.error(err);
        error.value = 'Failed to load article';
    } finally {
        loading.value = false;
        relatedLoading.value = false;
    }
};

const visibleComments = computed(() => {
    return article.value.comments.slice(0, visibleCount.value);
});

const showMoreComments = () => {
    visibleCount.value += 4;
};

// Format date to be more readable
const formatDate = (dateString) => {
    if (!dateString) return '';
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

// Newsletter subscription
const subscribeToNewsletter = async () => {
    if (subscribeSubmitting.value) return;

    subscribeSubmitting.value = true;
    try {
        await axios.post('/api/newsletter/subscribe', { email: emailInput.value });
        alert('Thank you for subscribing to our newsletter!');
        emailInput.value = '';
    } catch (err) {
        console.error('Error subscribing to newsletter:', err);
        alert(err.response?.data?.message || 'Failed to subscribe. Please try again later.');
    } finally {
        subscribeSubmitting.value = false;
    }
};


const addComment = async (parentId = null) => {
    const content = parentId ? replyContent.value : form.value.content;

    if (commentSubmitting.value || !content.trim()) {
        return;
    }

    commentSubmitting.value = true;

    try {
        const response = await axios.post(`/api/comments/store`, {
            content,
            article_id: article.value.id,
            parent_id: parentId
        });

        const newComment = {
            ...response.data.comment,
            user: {
                id: authStore.user.id,
                name: authStore.user.name,
                profile_image: authStore.user.profile_image
            },
            replies: []
        };

        if (parentId) {
            // Add as reply
            const parentComment = findComment(article.value.comments, parentId);
            if (parentComment) {
                parentComment.replies = parentComment.replies || [];
                parentComment.replies.unshift(newComment);
            }
            replyContent.value = '';
            replyingTo.value = null;
        } else {
            // Add as top-level comment
            article.value.comments.unshift(newComment);
            form.value.content = '';
        }

    } catch (err) {
        console.error('Error posting comment:', err);
        alert(err.response?.data?.message || 'Failed to post comment');
    } finally {
        commentSubmitting.value = false;
    }
};

// Helper function to find a comment by ID (including in replies)
const findComment = (comments, commentId) => {
    for (const comment of comments) {
        if (comment.id === commentId) return comment;
        if (comment.replies?.length) {
            const found = findComment(comment.replies, commentId);
            if (found) return found;
        }
    }
    return null;
};

// Share article
const shareArticle = (platform) => {
    const url = window.location.href;
    const title = article.value.title;

    let shareUrl;

    switch (platform) {
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
            break;
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`;
            break;
        case 'linkedin':
            shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`;
            break;
        default:
            return;
    }

    window.open(shareUrl, '_blank', 'width=600,height=400');
};

// Copy article link
const copyArticleLink = () => {
    const url = window.location.href;
    navigator.clipboard.writeText(url)
        .then(() => alert('Link copied to clipboard!'))
        .catch(err => console.error('Failed to copy link:', err));
};

// Fetch data when component mounts
onMounted(() => {
    fetchArticle();
});
</script>