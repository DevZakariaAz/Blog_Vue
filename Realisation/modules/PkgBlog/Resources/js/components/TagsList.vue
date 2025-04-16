<template>
    <div class="tags-list">
        <h3 v-if="showTitle" class="text-sm font-medium text-gray-700 mb-2">Tags</h3>

        <div v-if="tags && tags.length > 0" class="flex flex-wrap gap-2">
            <span v-for="tag in tags" :key="tag.id || tag"
                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                :class="{ 'cursor-pointer hover:bg-blue-200': clickable }" @click="handleTagClick(tag)">
                {{ typeof tag === 'object' ? tag.name : tag }}
            </span>
        </div>

        <div v-else class="text-sm text-gray-500">
            No tags
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    tags: {
        type: Array,
        default: () => []
    },
    showTitle: {
        type: Boolean,
        default: false
    },
    clickable: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['tag-click']);

const handleTagClick = (tag) => {
    if (props.clickable) {
        emit('tag-click', tag);
    }
};
</script>