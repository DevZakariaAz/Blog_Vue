<script setup>
import { defineProps } from 'vue';

defineProps(['popularTags']);
</script>

<template>
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-10">Popular Tags</h2>
            <div class="flex flex-wrap justify-center gap-3">
                <a v-for="(tag, index) in popularTags" :key="index" href="#"
                    class="px-4 py-2 bg-gray-100 rounded-full text-sm text-gray-700 hover:bg-gray-200 transition duration-200">
                    {{ tag.name }}
                </a>
            </div>
        </div>
    </section>
</template>