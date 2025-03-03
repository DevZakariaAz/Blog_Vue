<script setup>
import { useAuthStore } from "@/stores/authStore"; 

const authStore = useAuthStore(); 
const navigation = [
    { name: "Home", href: "/", current: true },
    { name: "Dashboard", href: "/dashboard", current: false },
    { name: "About", href: "/about", current: false }
];

const logout = async () => {
  try {
    await authStore.logout(); 
  } catch (error) {
    console.error('Logout failed:', error);
  }
};
</script>

<template>
  <nav class="bg-background border-b border-border shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center">
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
              <a
                v-for="item in navigation"
                :key="item.name"
                :href="item.href"
                :class="[item.current
                    ? 'bg-accent text-accent-foreground'
                    : 'text-foreground hover:bg-accent hover:text-accent-foreground',
                    'px-3 py-1 rounded-md font-semibold']"
                :aria-current="item.current ? 'page' : undefined"
              >
                {{ item.name }}
              </a>
            </div>
          </div>
        </div>
        <div class="flex">
          <div v-if="!authStore.user" class="flex items-center">
            <router-link
              to="/login"
              type="button"
              class="rounded px-3 py-1 font-semibold text-slate-700 bg-accent hover:text-slate-900"
            >
              Login
            </router-link>
          </div>
          <div v-if="!authStore.user" class="ml-2 flex items-center md:ml-4">
            <router-link
              to="/register"
              type="button"
              class="rounded px-4 py-1 font-semibold text-slate-100 bg-primary hover:text-slate-200 hover:bg-primary"
            >
              Register
            </router-link>
          </div>
          <div v-else class="flex items-center">
            <!-- Display user name and logout button -->
            <span class="text-slate-700 font-semibold mr-4">{{ authStore.user.name }}</span>
            <button
              type="button"
              class="rounded px-3 py-1 font-semibold text-slate-700 bg-accent hover:text-slate-900"
              @click="logout" 
            >
              Logout
            </button>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>