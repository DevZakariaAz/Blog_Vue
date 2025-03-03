import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";

export const useProductsStore = defineStore("products", () => {
    const data = ref([]);

    // Fetch all products
    const fetchProducts = async () => {
        try {
            const response = await axios.get("/products");
            data.value = response.data;
        } catch (error) {
            console.error("Error fetching products:", error);
        }
    };

    // Add a new product
    const addProduct = async (product) => {
        try {
            const response = await axios.post("/products", product);
            data.value.push(response.data);
            await fetchProducts();
        } catch (error) {
            console.error("Error adding product:", error);
        }
    };

    // Delete a product by ID
    const deleteProduct = async (productId) => {
        try {
            await axios.delete(`/products/${productId}`);
            data.value = data.value.filter(product => product.id !== productId);
        } catch (error) {
            console.error("Error deleting product:", error);
        }
    };

    // Fetch a single product by ID
    const fetchProductById = async (productId) => {
        try {
            const response = await axios.get(`/products/${productId}`);
            return response.data;
        } catch (error) {
            console.error("Error fetching product:", error);
        }
    };

    // Update an existing product
    const updateProduct = async (productId, updatedProduct) => {
        try {
            const response = await axios.put(`/products/${productId}`, updatedProduct);
            const index = data.value.findIndex(product => product.id === productId);
            if (index !== -1) {
                data.value[index] = response.data; // Update the product reactively
            }
        } catch (error) {
            console.error("Error updating product:", error);
        }
    };

    return { 
        data, 
        fetchProducts, 
        addProduct, 
        deleteProduct, 
        fetchProductById, 
        updateProduct 
    };
});
