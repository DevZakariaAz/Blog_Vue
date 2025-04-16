<template>
    <Layout>
        <div class="max-w-4xl mx-auto">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Create New Article</h1>
            </div>

            <!-- Success Message -->
            <div v-if="successMessage"
                class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-md flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-3 mt-0.5" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-green-800">Success</h3>
                    <p class="text-sm text-green-700 mt-1">{{ successMessage }}</p>
                </div>
            </div>

            <!-- Error Message -->
            <div v-if="hasErrors" class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-md flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-3 mt-0.5" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-red-800">Please fix the following errors</h3>
                    <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                        <li v-for="(errorArray, field) in errors" :key="field">
                            {{ errorArray[0] }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Form Container -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Form -->
                <form @submit.prevent="submitArticle" class="divide-y divide-gray-100">
                    <!-- Basic Info Section -->
                    <div class="p-6 space-y-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">Basic Information</h2>
                            <div class="text-sm text-gray-500">* Required fields</div>
                        </div>

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                                Title <span class="text-red-500">*</span>
                            </label>
                            <input id="title" v-model="form.title" type="text"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all"
                                placeholder="Enter a compelling title for your article" />
                            <p v-if="errors.title" class="mt-1.5 text-sm text-red-600">{{ errors.title[0] }}</p>
                        </div>

                        <!-- Slug -->
                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">
                                Slug <span class="text-red-500">*</span>
                            </label>
                            <input id="slug" v-model="form.slug" type="text"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all"
                                placeholder="Enter a slug for your article" />
                            <p v-if="errors.slug" class="mt-1.5 text-sm text-red-600">{{ errors.slug[0] }}</p>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Meta
                                Description <span class="text-red-500">*</span> </label>
                            <textarea v-model="form.description" id="description"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all"
                                placeholder="Enter a meta description for your article"></textarea>
                        </div>

                        <!-- Category & Tags -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">
                                    Category <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="category" v-model="form.category_id"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all appearance-none">
                                        <option value="" disabled>Select category</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">
                                            {{ category.name }}
                                        </option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </div>
                                </div>
                                <p v-if="errors.category_id" class="mt-1.5 text-sm text-red-600">{{
                                    errors.category_id[0] }}</p>
                            </div>

                            <!-- Tags -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tags</label>
                                <div
                                    class="flex flex-wrap gap-2 p-3 bg-gray-50 rounded-lg border border-gray-200 min-h-[42px]">
                                    <div v-for="tag in selectedTags" :key="tag.id"
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <span>{{ tag.name }}</span>
                                        <button type="button" @click="removeTag(tag.id)"
                                            class="ml-1.5 text-blue-600 hover:text-blue-800 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                            </svg>
                                        </button>
                                    </div>
                                    <div v-if="selectedTags.length === 0" class="text-sm text-gray-500 py-1">
                                        No tags selected
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div class="relative">
                                        <select v-model="selectedTagId" @change="addTag"
                                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all appearance-none">
                                            <option value="" disabled>Add a tag</option>
                                            <option v-for="tag in availableTags" :key="tag.id" :value="tag.id">
                                                {{ tag.name }}
                                            </option>
                                        </select>
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="p-6 space-y-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">Article Content</h2>
                            <div class="text-sm text-gray-500">* Required</div>
                        </div>

                        <!-- Content Editor -->
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">
                                Content <span class="text-red-500">*</span>
                            </label>
                            <TiptapEditor v-model="content" />
                            <p v-if="errors.content" class="mt-1.5 text-sm text-red-600">{{ errors.content[0] }}</p>
                        </div>
                    </div>

                    <!-- Media Section -->
                    <div class="p-6 space-y-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Media</h2>

                        <!-- Featured Image -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Featured Image <span class="text-red-500">*</span>
                            </label>

                            <!-- Upload area -->
                            <div v-if="!form.featured_image"
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-lg hover:bg-gray-50 transition-colors cursor-pointer group"
                                @click="triggerImageUpload">
                                <div class="space-y-1 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="mx-auto h-12 w-12 text-gray-400 group-hover:text-gray-500 transition-colors"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>
                                        <circle cx="9" cy="9" r="2"></circle>
                                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label
                                            class="relative cursor-pointer rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                            <span>Upload a file</span>
                                            <input type="file" ref="imageInput" @change="handleImageChange"
                                                accept="image/*" class="sr-only" />
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>

                            <!-- Image Preview -->
                            <div v-if="form.featured_image" class="mt-4">
                                <div class="relative group">
                                    <div
                                        class="h-64 w-full rounded-md bg-gray-100 overflow-hidden border border-gray-200">
                                        <img :src="getImagePreviewUrl(form.featured_image)"
                                            class="h-full w-full object-cover" alt="Featured image preview" />
                                    </div>
                                    <button type="button" @click="removeFeaturedImage"
                                        class="absolute top-2 right-2 bg-white text-red-600 rounded-full p-1.5 shadow-sm opacity-80 hover:opacity-100 transition-opacity">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Click the image to change or the X button to
                                    remove</p>
                            </div>
                            <p v-if="errors.featured_image" class="mt-1.5 text-sm text-red-600">{{
                                errors.featured_image[0] }}</p>
                        </div>
                    </div>

                    <!-- Submit Section -->
                    <div class="p-6 bg-gray-50 flex items-center justify-between">
                        <button type="button"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 text-sm font-medium transition-colors flex items-center"
                            @click="saveDraft">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                <polyline points="7 3 7 8 15 8"></polyline>
                            </svg>
                            Save as Draft
                        </button>

                        <div class="flex items-center gap-3">
                            <button type="button" @click="previewArticle"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 text-sm font-medium transition-colors flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                Preview
                            </button>

                            <button type="submit"
                                class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors flex items-center justify-center disabled:opacity-70 disabled:cursor-not-allowed"
                                :disabled="loading">
                                <svg v-if="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3">
                                    </path>
                                </svg>
                                <span>{{ loading ? 'Publishing...' : 'Publish Article' }}</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Preview Modal -->
        <div v-if="showPreview" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Article Preview</h3>
                    <button @click="showPreview = false" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="overflow-y-auto p-6 flex-grow">
                    <h1 class="text-3xl font-bold mb-4">{{ form.title || 'Untitled Article' }}</h1>
                    <div class="prose prose-lg max-w-none" v-html="content"></div>
                </div>
                <div class="p-4 border-t border-gray-200 bg-gray-50 flex justify-end">
                    <button @click="showPreview = false"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-800">
                        Close Preview
                    </button>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { ref, computed, onMounted, watch, onBeforeUnmount } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import Layout from "../../../components/Layout.vue";
import TiptapEditor from "../../../components/TiptapEditor.vue";

const router = useRouter();

// Form Data
const form = ref({
    title: "",
    content: "",
    slug: "",
    description: "",
    category_id: "",
    tags: [],
    featured_image: null,
    status: "published" // Default status
});

const content = ref("");
watch(content, (val) => {
    form.value.content = val;
});

// Error Messages
const errors = ref({});
const hasErrors = computed(() => Object.keys(errors.value).length > 0);

// Success Message
const successMessage = ref("");

// Loading State
const loading = ref(false);

// Preview State
const showPreview = ref(false);

// Categories & Tags
const categories = ref([]);
const tags = ref([]);
const selectedTagId = ref("");

// Image upload reference
const imageInput = ref(null);

// Computed properties
const selectedTags = computed(() => {
    return tags.value.filter(tag => form.value.tags.includes(tag.id));
});

const availableTags = computed(() => {
    return tags.value.filter(tag => !form.value.tags.includes(tag.id));
});

// Methods
const triggerImageUpload = () => {
    imageInput.value.click();
};

const handleImageChange = (event) => {
    if (event.target.files.length > 0) {
        form.value.featured_image = event.target.files[0];
    }
    // Reset the input to allow selecting the same file again
    event.target.value = null;
};

const getImagePreviewUrl = (image) => {
    // If it's a File object, create a URL
    if (image instanceof File) {
        return URL.createObjectURL(image);
    }
    // If it's already a URL string, return it
    return image;
};

const removeFeaturedImage = () => {
    // If it's a File object with a URL, revoke it to prevent memory leaks
    if (form.value.featured_image instanceof File) {
        URL.revokeObjectURL(form.value.featured_image);
    }
    form.value.featured_image = null;
};

const addTag = () => {
    if (selectedTagId.value && !form.value.tags.includes(selectedTagId.value)) {
        form.value.tags.push(selectedTagId.value);
        selectedTagId.value = "";
    }
};

const removeTag = (tagId) => {
    form.value.tags = form.value.tags.filter(id => id !== tagId);
};

// Preview article
const previewArticle = () => {
    showPreview.value = true;
};

// Save as draft
const saveDraft = async () => {
    form.value.status = "draft";
    await submitArticle();
};

// Fetch Categories & Tags from API
const fetchData = async () => {
    try {
        const response = await axios.get("/api/articles/create");
        categories.value = response.data.categories;
        tags.value = response.data.tags;
    } catch (error) {
        console.error("Error fetching data:", error);
    }
};

// Handle Form Submission
const submitArticle = async () => {
    loading.value = true;
    errors.value = {};
    successMessage.value = "";

    try {
        // Validate form
        if (!form.value.title.trim()) {
            errors.value.title = ["Title is required"];
        }

        if (!form.value.category_id) {
            errors.value.category_id = ["Category is required"];
        }

        if (!form.value.content.trim()) {
            errors.value.content = ["Content is required"];
        }

        if (!form.value.slug.trim()) {
            errors.value.slug = ["Slug is required"];
        }

        if (!form.value.description.trim()) {
            errors.value.description = ["Meta description is required"];
        }

        if (!form.value.featured_image) {
            errors.value.featured_image = ["Featured image is required"];
        }

        // If there are validation errors, stop submission
        if (Object.keys(errors.value).length > 0) {
            loading.value = false;
            return;
        }

        const formData = new FormData();
        formData.append("title", form.value.title);
        formData.append("content", form.value.content);
        formData.append("slug", form.value.slug);
        formData.append("description", form.value.description);
        formData.append("category_id", form.value.category_id);
        formData.append("status", form.value.status);

        form.value.tags.forEach(tag => formData.append("tags[]", tag));
        if (form.value.featured_image) {
            formData.append("featured_image", form.value.featured_image);
        }

        // Send form data
        await axios.post("/api/articles/store", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });

        // Show success message
        successMessage.value = form.value.status === "published"
            ? "Article published successfully!"
            : "Article saved as draft successfully!";

        // Redirect after 1.5 seconds
        setTimeout(() => router.push("/admin/articles"), 1500);
    } catch (error) {
        if (error.response && error.response.data.errors) {
            errors.value = error.response.data.errors;
        } else {
            // Generic error message
            errors.value = { general: ["An error occurred while saving the article. Please try again."] };
        }
    } finally {
        loading.value = false;
    }
};

// Clean up object URLs when component is unmounted
onBeforeUnmount(() => {
    if (form.value.featured_image instanceof File) {
        URL.revokeObjectURL(form.value.featured_image);
    }
});

onMounted(fetchData);
</script>