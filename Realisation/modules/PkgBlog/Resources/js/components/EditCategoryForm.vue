<template>
    <!-- Category Form -->
    <form @submit.prevent="submitForm" class="space-y-6">
        <!-- Name -->
        <div>
            <label for="category" class="block text-gray-700 font-semibold mb-2">Category</label>
            <input v-model="selectedCategoryName" type="text"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition-all duration-200 ease-in-out"
                required />
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end space-x-4">
            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                Save
            </button>
            <button type="button" @click="cancel"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600 transition">
                Cancel
            </button>
        </div>
    </form>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();
const selectedCategoryId = ref(null); 
const selectedCategoryName = ref(''); 

// Fetch the category to edit
const fetchCategoryData = async (id) => {
    try {
        const response = await axios.get(`/api/categories/${id}/edit`);
        selectedCategoryId.value = response.data.id; 
        selectedCategoryName.value = response.data.name; 
    } catch (error) {
        console.error('Error fetching category:', error);
    }
};

// Fetch data on mounted
onMounted(async () => {
    const categoryId = router.currentRoute.value.params.id;
    if (categoryId) {
        await fetchCategoryData(categoryId); // Fetch the specific category to edit
    }
});

// Submit the updated category
const submitForm = async () => {
    try {
        if (selectedCategoryId.value && selectedCategoryName.value) {
            const updatedCategory = {
                id: selectedCategoryId.value,
                name: selectedCategoryName.value,
            };
            await axios.put(`/api/categories/${selectedCategoryId.value}`, updatedCategory); // Send updated category data
            router.push('/admin/categories'); // Redirect after update
        }
    } catch (error) {
        console.error('Error updating category:', error);
    }
};

const cancel = () => {
    router.push('/admin/categories'); // Redirect to the categories page
};
</script>
