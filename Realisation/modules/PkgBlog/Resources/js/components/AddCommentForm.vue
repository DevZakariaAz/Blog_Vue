<template>
    <div class="mt-8">
        <h3 class="text-xl font-semibold text-gray-900">Add a Comment</h3>
        <textarea v-model="newComment" class="w-full p-3 mt-2 border rounded-lg" rows="4"
            placeholder="Write your comment..."></textarea>
        <button @click="submitComment" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
            :disabled="loading">
            <span v-if="loading">Submitting...</span>
            <span v-else>Submit Comment</span>
        </button>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const newComment = ref('');
const loading = ref(false);

const submitComment = async () => {
    if (newComment.value.trim() === '') return;
    loading.value = true;
    // Submit the comment logic here
    loading.value = false;
};
</script>