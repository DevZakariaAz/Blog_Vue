<script setup>
import { useProductsStore } from "../stores/ProductsStore";
import { onMounted, computed } from "vue";
import { useAuthStore } from "../stores/authStore"; // Ensure you have imported it
import { NavBar } from "@/components/ui/NavBar";
import { Card, CardContent, CardHeader } from "@/components/ui/card";
import { Button } from "@/components/ui/button";

// Initialize the store
const products = useProductsStore();
const auth = useAuthStore();

const isAuthenticated = computed(() => auth.fetchUser()); // Ensure fetchUser() returns a boolean

// Fetch products data when the component mounts
onMounted(() => {
    products.fetchProducts();
});
</script>

<template>
    <div class="h-full bg-slate-100">
        <NavBar :isAuthenticated="isAuthenticated" />
        <!-- Display products data -->
        <Card v-if="products.data" class="m-4 p-4">
            <CardHeader class="p-4">
                <CardTitle class="text-2xl font-semibold">Products</CardTitle>
                <CardDescription class="text-gray-500">
                    Browse our selection of products
                </CardDescription>
            </CardHeader>
            <div
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-y-6 gap-x-4"
            >
                <Card
                    v-for="product in products.data"
                    :key="product.id"
                    class="w-full h-40 max-w-sm overflow-hidden transition-shadow duration-300 hover:shadow-lg"
                >
                    <CardContent class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-semibold text-gray-900">
                                {{ product.name }}
                            </h3>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">
                            {{ product.description }}
                        </p>
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-900">
                                ${{ product.price }}
                            </span>
                            <Button @click="addToCart">Add to Cart</Button>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </Card>
        <div v-else>
            <p>Loading data...</p>
        </div>
    </div>
</template>
