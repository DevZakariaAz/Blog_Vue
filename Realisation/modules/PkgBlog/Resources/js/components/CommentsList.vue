<template>
    <div class="comments-list">
        <!-- Empty State -->
        <div v-if="!comments || comments.length === 0" class="text-center py-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-3" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
            <h3 class="text-gray-500 font-medium">No comments yet</h3>
            <p class="text-gray-400 text-sm mt-1">Be the first to start the conversation</p>
        </div>

        <!-- Comments List -->
        <div v-else class="space-y-6">
            <div v-for="comment in visibleComments" :key="comment.id" class="comment-item">
                <div class="flex items-start gap-3">
                    <!-- Avatar -->
                    <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden flex-shrink-0">
                        <img v-if="comment.user && comment.user.profile_image" :src="comment.user.profile_image"
                            :alt="comment.user.name" class="w-full h-full object-cover" />
                        <div v-else
                            class="w-full h-full flex items-center justify-center bg-blue-100 text-blue-600 font-medium">
                            {{ getInitials(comment.user ? comment.user.name : comment.author_name) }}
                        </div>
                    </div>

                    <!-- Comment Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <h4 class="font-medium text-gray-900">
                                {{ comment.user ? comment.user.name : comment.author_name }}
                            </h4>

                            <span class="text-xs text-gray-500">
                                {{ formatDate(comment.created_at) }}
                            </span>
                        </div>

                        <div class="text-gray-700 text-sm whitespace-pre-line">
                            {{ comment.content }}
                        </div>
                    </div>
                </div>

                <!-- Nested Replies (if any) -->
                <div v-if="comment.replies && comment.replies.length > 0" class="mt-4 ml-12 space-y-4">
                    <div v-for="reply in comment.replies" :key="reply.id" class="flex items-start gap-3">
                        <!-- Reply Avatar -->
                        <div class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden flex-shrink-0">
                            <img v-if="reply.user && reply.user.avatar" :src="reply.user.avatar" :alt="reply.user.name"
                                class="w-full h-full object-cover" />
                            <div v-else
                                class="w-full h-full flex items-center justify-center bg-blue-100 text-blue-600 font-medium text-xs">
                                {{ getInitials(reply.user ? reply.user.name : reply.author_name) }}
                            </div>
                        </div>

                        <!-- Reply Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <h4 class="font-medium text-gray-900 text-sm">
                                    {{ reply.user ? reply.user.name : reply.author_name }}
                                </h4>

                                <span class="text-xs text-gray-500">
                                    {{ formatDate(reply.created_at) }}
                                </span>
                            </div>

                            <div class="text-gray-700 text-sm whitespace-pre-line">
                                {{ reply.content }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="comments.length > visibleCount" class="text-center mt-4">
                <button @click="showMoreComments"
                    class="px-4 py-2 text-sm font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition-colors">
                    Show More Comments
                </button>
            </div>

        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal"
            class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md overflow-hidden">
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete Comment</h3>
                    <p class="text-gray-600">Are you sure you want to delete this comment? This action cannot be undone.
                    </p>
                </div>
                <div class="p-4 bg-gray-50 flex justify-end gap-3">
                    <button @click="showDeleteModal = false"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 text-sm font-medium transition-colors">
                        Cancel
                    </button>
                    <button @click="handleDeleteConfirm"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm font-medium transition-colors">
                        Delete Comment
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits, ref, computed } from 'vue';

const props = defineProps({
    comments: {
        type: Array,
        default: () => []
    }
});

const emit = defineEmits(['approve', 'reject', 'delete']);

// State for delete confirmation
const showDeleteModal = ref(false);
const commentToDelete = ref(null);

// Format date to a readable format
const formatDate = (dateString) => {
    if (!dateString) return '';

    const date = new Date(dateString);

    // If it's today, show time
    const today = new Date();
    if (date.toDateString() === today.toDateString()) {
        return new Intl.DateTimeFormat('en-US', {
            hour: 'numeric',
            minute: 'numeric'
        }).format(date);
    }

    // If it's within the last week, show day of week
    const lastWeek = new Date();
    lastWeek.setDate(lastWeek.getDate() - 7);
    if (date > lastWeek) {
        return new Intl.DateTimeFormat('en-US', {
            weekday: 'short',
            hour: 'numeric',
            minute: 'numeric'
        }).format(date);
    }

    // Otherwise show full date
    return new Intl.DateTimeFormat('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    }).format(date);
};

// Get initials from name for avatar fallback
const getInitials = (name) => {
    if (!name) return '';

    return name
        .split(' ')
        .map(part => part.charAt(0))
        .join('')
        .toUpperCase()
        .substring(0, 2);
};

// Handle delete confirmation
const confirmDelete = (commentId) => {
    commentToDelete.value = commentId;
    showDeleteModal.value = true;
};

const handleDeleteConfirm = () => {
    emit('delete', commentToDelete.value);
    showDeleteModal.value = false;
    commentToDelete.value = null;
};

const visibleCount = ref(4);

const visibleComments = computed(() => {
    return props.comments.slice(0, visibleCount.value);
});

const showMoreComments = () => {
    visibleCount.value += 4;
};

</script>