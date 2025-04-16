<script setup>
import { defineProps, defineEmits } from 'vue';

defineProps(['modelValue']);
const emit = defineEmits(['update:modelValue', 'subscribeToNewsletter']);

const updateValue = (event) => {
    emit('update:modelValue', event.target.value);
};
</script>

<template>
    <section class="py-16 bg-gray-800 text-white text-center">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold mb-4">Stay Updated</h2>
            <p class="text-lg opacity-90 mb-8">Subscribe to our newsletter for the latest articles, insights, and
                updates delivered straight to your inbox.</p>
            <form @submit.prevent="emit('subscribeToNewsletter')" class="flex flex-col sm:flex-row gap-4 mb-4">
                <input type="email" :value="modelValue" @input="updateValue" placeholder="Your email address"
                    class="flex-1 px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30"
                    required />
                <button type="submit"
                    class="px-6 py-3 bg-white text-gray-800 rounded-lg font-semibold hover:bg-gray-100 transition duration-200">Subscribe</button>
            </form>
            <p class="text-sm opacity-70">We respect your privacy. Unsubscribe at any time.</p>
        </div>
    </section>
</template>