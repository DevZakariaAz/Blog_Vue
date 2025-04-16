<template>
    <Layout>
        <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow-md">
            <h2 class="text-2xl font-bold mb-4">Create New Tag</h2>

            <!-- Success Message -->
            <p v-if="successMessage" class="text-green-600 mb-4">{{ successMessage }}</p>

            <!-- Form -->
            <form @submit.prevent="submitTag">
                <!-- Title -->
                <div class="mb-4">
                    <label for="tag" class="block text-gray-700 font-semibold mb-2">Tag</label>
                    <input v-model="form.name" type="text"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition-all duration-200 ease-in-out"
                        required placeholder="Enter tag name" />
                    <p v-if="errors.name" class="text-red-500 text-sm">{{ errors.name[0] }}</p>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center">
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 flex items-center gap-2"
                        :disabled="loading">
                        <span v-if="loading">Saving...</span>
                        <span v-else>Create Tag</span>
                    </button>
                </div>
            </form>
        </div>
    </Layout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import Layout from "../../../components/Layout.vue";

const router = useRouter();

// Form Data
const form = ref({
    name: ""
});

// Error Messages
const errors = ref({});

// Success Message
const successMessage = ref("");

// Loading State
const loading = ref(false);

// Handle Form Submission
const submitTag= async () => {
    loading.value = true;
    errors.value = {}; // Reset errors
    successMessage.value = ""; // Reset success message

    try {
        // Send form data
        await axios.post("/api/tags/store", {
            name: form.value.name
        });

        // Show success message
        successMessage.value = "Tag created successfully!";

        // Redirect after 1 second
        setTimeout(() => router.push("/admin/tags"), 1000);
    } catch (error) {
        if (error.response && error.response.data.errors) {
            errors.value = error.response.data.errors;
        }
    } finally {
        loading.value = false;
    }
};

</script>
