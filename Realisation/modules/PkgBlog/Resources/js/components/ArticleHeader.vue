<template>
    <div class="article-header">
        <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ title }}</h1>

        <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600">
            <!-- Author -->
            <div v-if="useRoute" class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden mr-2">
                    <img v-if="author.profile_image" :src="author.profile_image" :alt="author.name"
                        class="w-full h-full object-cover" />
                    <div v-else
                        class="w-full h-full flex items-center justify-center bg-blue-100 text-blue-600 font-medium">
                        {{ getInitials(author.name) }}
                    </div>
                </div>
                <span>{{ author.name }}</span>
            </div>

            <!-- Date -->
            <div v-if="date" class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <span>{{ formatDate(date) }}</span>
            </div>

            <!-- Category -->
            <div v-if="category" class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z">
                    </path>
                </svg>
                <span>{{ typeof category === 'object' ? category.name : category }}</span>
            </div>

            <!-- Read Time -->
            <!-- <div v-if="readTime" class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                <span>{{ readTime }} read</span>
            </div> -->
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
import { useRoute } from 'vue-router';

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    author: {
        type: Object,
        default: null
    },
    date: {
        type: String,
        default: null
    },
    category: {
        type: [String, Object],
        default: null
    },
    readTime: {
        type: String,
        default: null
    }
});

// Format date to a readable format
const formatDate = (dateString) => {
    if (!dateString) return '';

    const date = new Date(dateString);
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
</script>