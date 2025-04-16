<template>
    <div class="article-content prose prose-lg max-w-none" v-html="processedContent"></div>
</template>

<script setup>
import { defineProps, computed } from 'vue';
import DOMPurify from 'dompurify';

const props = defineProps({
    content: {
        type: String,
        default: ''
    }
});

const processedContent = computed(() => {
    let content = props.content;

    // If you need any client-side processing
    content = content.replace(/src="blob:[^"]+"/g, 'src="/images/image-placeholder.jpg"');

    return DOMPurify.sanitize(content, {
        ADD_TAGS: ['iframe', 'img'],
        ADD_ATTR: ['allow', 'allowfullscreen', 'frameborder', 'scrolling', 'src', 'alt']
    });
});
</script>

<style>
.article-content img {
    @apply rounded-lg max-w-full h-auto my-4;
}

.article-content a {
    @apply text-blue-600 hover:underline;
}

.article-content blockquote {
    @apply border-l-4 border-gray-300 pl-4 italic my-4 text-gray-700;
}

.article-content pre {
    @apply bg-gray-800 text-white p-4 rounded-lg my-4 overflow-x-auto;
}

.article-content code {
    @apply font-mono bg-gray-100 px-1 py-0.5 rounded text-sm;
}

.article-content pre code {
    @apply bg-transparent text-white p-0;
}

.article-content h1 {
    @apply text-3xl font-bold mb-4 mt-6;
}

.article-content h2 {
    @apply text-2xl font-bold mb-3 mt-5;
}

.article-content h3 {
    @apply text-xl font-bold mb-3 mt-4;
}

.article-content ul {
    @apply list-disc pl-5 mb-4;
}

.article-content ol {
    @apply list-decimal pl-5 mb-4;
}

.article-content iframe {
    @apply max-w-full rounded-lg my-4;
}

.article-content .text-align-center {
    @apply text-center;
}

.article-content .text-align-right {
    @apply text-right;
}

.article-content hr {
    @apply my-6 border-t border-gray-300;
}
</style>