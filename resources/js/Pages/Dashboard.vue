<script setup>
// Imports
import { ref, onMounted } from "vue";
import { useAuthStore } from "../stores/authStore";
import { useProductsStore } from "../stores/ProductsStore";
import { useForm, Field, Form } from "vee-validate";
import { toTypedSchema } from "@vee-validate/zod";

import * as z from "zod"; // Zod for schema validation

// Importing components from shadcn/ui and lucide-vue-next
import { Aside } from "@/components/ui/aside";
import { FormLabel } from "@/components/ui/form";
import { Button } from "@/components/ui/button";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { Sheet, SheetContent, SheetTrigger } from "@/components/ui/sheet";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
import { TooltipProvider } from "@/components/ui/tooltip";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import {
    Dialog,
    DialogContent,
    DialogTrigger,
    DialogHeader,
    DialogTitle,
    DialogDescription,
} from "@/components/ui/dialog";
import {
    CircleUser,
    File,
    Home,
    Package,
    PanelLeft,
    PlusCircle,
} from "lucide-vue-next";

// Stores
const products = useProductsStore();
const authStore = useAuthStore();

// Form validation schema
const formSchema = toTypedSchema(
    z.object({
        name: z.string().min(2).max(50),
        description: z.string().min(2).max(50),
        price: z.number().min(1).max(10000),
    }),
);

// Form state
const { handleSubmit } = useForm({ validationSchema: formSchema });

// Fetch products when the component mounts
onMounted(async () => {
    await products.fetchProducts(); // Fetch the list of products from the server
});

// Dialog state
const isDialogOpen = ref(false);

// Add product
const onSubmit = async (values) => {
    try {
        await products.addProduct(values);
        isDialogOpen.value = false;
    } catch (error) {
        console.error(error);
    }
};

// Delete product
const deleteProduct = async (productId) => {
    try {
        await products.deleteProduct(productId);
        await products.fetchProducts();
    } catch (error) {
        console.error(error);
    }
};

// Logout
const logout = async () => await authStore.logout();

const formatPrice = (field, event) => {
  let value = event.target.value;

  // Remove non-numeric characters
  value = value.replace(/[^0-9.]/g, '');

  // Ensure only two decimal places
  const parts = value.split('.');
  if (parts.length > 1) {
    value = `${parts[0]}.${parts[1].slice(0, 2)}`;
  }

  // Update the field value
  field.value = value;
  event.target.value = value;
};

</script>

<template>
        <TooltipProvider>
        <!-- Main container -->
        <div class="flex min-h-screen w-full flex-col bg-muted/40">
            <!-- Sidebar -->
            <Aside />

            <!-- Main content area -->
            <div class="flex flex-col sm:gap-4 sm:py-4 sm:pl-14">
                <!-- Header section -->
                <header
                    class="sticky top-0 z-30 flex h-14 items-center gap-4 border-b bg-background px-4 sm:static sm:h-auto sm:border-0 sm:bg-transparent sm:px-6"
                >
                    <!-- Menu for small screens -->
                    <Sheet>
                        <SheetTrigger as-child>
                            <Button size="icon" variant="outline" class="sm:hidden">
                                <PanelLeft class="h-5 w-5" />
                                <span class="sr-only">Toggle Menu</span>
                            </Button>
                        </SheetTrigger>
                        <SheetContent side="left" class="sm:max-w-xs">
                            <nav class="grid gap-6 text-lg font-medium">
                                <!-- Navigation links -->
                                <a href="#" class="flex items-center gap-4 px-2.5 text-muted-foreground hover:text-foreground">
                                    <Home class="h-5 w-5" /> Dashboard
                                </a>
                                <a href="#" class="flex items-center gap-4 px-2.5 text-foreground">
                                    <Package class="h-5 w-5" /> Products
                                </a>
                            </nav>
                        </SheetContent>
                    </Sheet>

                    <!-- User Menu -->
                    <div class="ml-auto"></div>
                    <DropdownMenu>
                        <DropdownMenuTrigger as-child>
                            <Button variant="secondary" size="icon" class="rounded-full">
                                <CircleUser class="h-5 w-5" />
                                <span class="sr-only">Toggle user menu</span>
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent class ="align-end">
                            <DropdownMenuItem @click="logout"> Logout </DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </header>

                <!-- Main tabs and content -->
                <main class="grid flex-1 items-start gap-4 p-4 sm:px-6 sm:py-0 md:gap-8">
                    <!-- Table displaying products -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Products</CardTitle>
                            <CardDescription>
                                Manage your products
                            </CardDescription>

                            <div class="flex items-center">
                                <!-- Actions like exporting data and adding new products -->
                                <div class="ml-auto flex items-center gap-2">
                                    <Button size="sm" variant="outline" class="h-7 gap-1">
                                        <File class="h-3.5 w-3.5" />
                                        <span class="sr-only sm:not-sr-only">Export</span>
                                    </Button>

                                    <!-- Add Product Button -->
                                    <Dialog v-model:open="isDialogOpen">
                                        <DialogTrigger as-child>
                                            <Button size="sm" class="h-7 gap-1">
                                                <PlusCircle class="h-3.5 w-3.5" />
                                                <span class="sr-only sm:not-sr-only">Add Product</span>
                                            </Button>
                                        </DialogTrigger>

                                        <DialogContent>
                                            <DialogHeader>
                                                <DialogTitle>Add New Product</DialogTitle>
                                                <DialogDescription>Fill in the details to add a new product.</DialogDescription>
                                            </DialogHeader>

                                            <!-- Add Product Form -->
                                            <Form :validation-schema="formSchema" @submit="onSubmit" class="space-y-4">
                                                <Field name="name" class="mt-2">
                                                    <template
                                                        #default="{
                                                            field,
                                                            meta,
                                                        }"
                                                    >
                                                        <FormLabel for="name"
                                                            >Product
                                                            Name</FormLabel
                                                        >
                                                        <Input
                                                            v-bind="field"
                                                            type="text"
                                                            placeholder="Product Name"
                                                            id="name"
                                                        />
                                                        <span
                                                            v-if="
                                                                meta.touched &&
                                                                meta.error
                                                            "
                                                            class="text-red-500"
                                                            >{{
                                                                meta.error
                                                            }}</span
                                                        >
                                                    </template>
                                                </Field>

                                                <Field name="description">
                                                    <template
                                                        #default="{
                                                            field,
                                                            meta,
                                                        }"
                                                    >
                                                        <FormLabel
                                                            >Product
                                                            Description</FormLabel
                                                        >
                                                        <Textarea
                                                            v-bind="field"
                                                            placeholder="Product Description"
                                                        />
                                                        <span
                                                            v-if="
                                                                meta.touched &&
                                                                meta.error
                                                            "
                                                            class="text-red-500"
                                                            >{{
                                                                meta.error
                                                            }}</span
                                                        >
                                                    </template>
                                                </Field>

                                                <Field name="price">
                                                    <template
                                                        #default="{
                                                            field,
                                                            meta,
                                                        }"
                                                    >
                                                        <FormLabel
                                                            >Product
                                                            Price</FormLabel
                                                        >
                                                        <Input
                                                            v-bind="field"
                                                            type="number"
                                                            placeholder="Product Price"
                                                            @input="formatPrice(field, $event)"
                                                        />
                                                        <span
                                                            v-if="
                                                                meta.touched &&
                                                                meta.error
                                                            "
                                                            class="text-red-500"
                                                            >{{
                                                                meta.error
                                                            }}</span
                                                        >
                                                    </template>
                                                </Field>

                                                <Button
                                                    type="submit"
                                                    class="mt-4"
                                                >
                                                    Add Product
                                                </Button>
                                            </Form>
                                    
                                        </DialogContent>
                                    </Dialog>
                                </div>
                            </div>
                        </CardHeader>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Product</TableHead>
                                    <TableHead>Description</TableHead>
                                    <TableHead>Price</TableHead>
                                    <TableHead>Actions</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="product in products.data" :key="product.id">
                                    <TableCell>{{ product.name }}</TableCell>
                                    <TableCell>{{ product.description }}</TableCell>
                                    <TableCell>{{ product.price }}</TableCell>
                                    <TableCell>
                                        <!-- Edit Button -->
                                        <Button variant="outline" @click="editProduct(product)" class="bg-blue-500 hover:bg-blue-600 text-white">
                                            Edit
                                        </Button>
                                        <!-- Show Button -->
                                        <Button variant="outline" @click="showProduct(product)" class="bg-green-500 hover:bg-green-600 text-white">
                                            Show
                                        </Button>
                                        <!-- Delete Button -->
                                        <Button variant="outline" @click="deleteProduct(product.id)" class="bg-red-500 hover:bg-red-600 text-white">
                                            Delete
                                        </Button>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </Card>
                </main>
            </div>
        </div>
        </TooltipProvider>
</template>
