<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-900 text-white">
        <div class="text-center">
            <h1 class="text-4xl font-bold">403 Unauthorized</h1>
            <p class="mt-4">You do not have the necessary permissions to access this page.</p>
            <button @click="goBack"
                class="mt-6 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow-md transition">
                Go Back
            </button>
        </div>
    </div>
</template>

<script setup>
import { useRouter } from "vue-router";

const router = useRouter();

const goBack = () => {
    router.back();
};
</script>
