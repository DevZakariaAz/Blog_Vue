<template>
    <Layout>
        <div class="p-6 space-y-6">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Edit Category</h2>
            </div>
            <div class="overflow-x-auto bg-white p-4 rounded-lg shadow">
                <EditCategoryForm />
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from '../../../components/Layout.vue';
import EditCategoryForm from '../../../components/EditCategoryForm.vue';
</script>
