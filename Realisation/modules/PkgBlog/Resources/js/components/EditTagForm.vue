<template>
    <!-- Tag Form -->
    <form @submit.prevent="submitForm" class="space-y-6">
        <!-- Name -->
        <div>
            <label for="tag" class="block text-gray-700 font-semibold mb-2">Tag</label>
            <input v-model="selectedTagName" type="text"
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
const selectedTagId = ref(null); 
const selectedTagName = ref(''); 

// Fetch the tag to edit
const fetchTagData = async (id) => {
    try {
        const response = await axios.get(`/api/tags/${id}/edit`);
        selectedTagId.value = response.data.id; 
        selectedTagName.value = response.data.name; 
    } catch (error) {
        console.error('Error fetching tag:', error);
    }
};

// Fetch data on mounted
onMounted(async () => {
    const TagId = router.currentRoute.value.params.id;
    if (TagId) {
        await fetchTagData(TagId); // Fetch the specific Tag to edit
    }
});

// Submit the updated Tag
const submitForm = async () => {
    try {
        if (selectedTagId.value && selectedTagName.value) {
            const updatedTag = {
                id: selectedTagId.value,
                name: selectedTagName.value,
            };
            await axios.put(`/api/tags/${selectedTagId.value}`, updatedTag); // Send updated Tag data
            router.push('/admin/tags'); // Redirect after update
        }
    } catch (error) {
        console.error('Error updating tag:', error);
    }
};

const cancel = () => {
    router.push('/tags'); // Redirect to the tags page
};
</script>
